<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Mail\MailableName;
use Illuminate\Support\Facades\Mail;
use App\Mail\RegistrationConfirmation;

class studentcontroller extends Controller
{
    //
    public function login(Request $req){
        $req->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
    
        $email = $req->input('email');
        $password = $req->input('password');
    
        $user = DB::table('studentprofile')->where('email', $email)->first();
    
        if ($user) {
            if (Hash::check($password, $user->password)) {
                Session::put('email', $email);
                Session::put('collegecode', $user->collegecode);
                Session::put('department', $user->department);
                Session::put('regno', $user->regno);
                Session::put('name', $user->name);
              
                return redirect('sDashboard')->with([ 'success' => 'Login successful. Welcome, ' . session('email') . '!']);
            }else {
                return redirect()->back()->with('error', 'Invalid credentials. Please try again.');
            }
        } else {
            return redirect('SRegister')->with('error', 'User not found. Please try again.');
        }
    }
    
    public function register(Request $req){
        $validator = Validator::make($req->all(), [
            'email' => 'required|email|ends_with:karpagamtech.ac.in|unique:studentprofile,email',
            'password' => 'required|string|min:8',
            'name'=>'required|string',
            'regno'=>'required|digits:12',
            'phone'=>'required|digits:10',
            'collegecode'=>'required',
            'year'=>'required',
            'department'=>'required',
            'image' => 'required',
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    
        if ($req->hasFile('image')) { 
            $image = $req->file('image');
            $extension = $image->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $path = "img/";
            $image->move($path, $filename);
            $imagePath = $path . $filename;
        } else {
            $imagePath = null; 
        }
    
        DB::table('studentprofile')->insert([
            'email' => $req->input('email'),
            'password' => bcrypt($req->input('password')),
            'name'=> $req->input('name'),
            'regno'=> $req->input('regno'),
            'phone'=> $req->input('phone'),
            'collegecode'=> $req->input('collegecode'),
            'year'=> $req->input('year'),
            'department'=> $req->input('department'),
            'image'=> $imagePath, // Use $imagePath variable here
        ]);
    
        return redirect('SLogin')->with('success', 'User created successfully.');
    }
    public function sReg($reg){
        $det=DB::table('regevent')->where('regno',$reg)->get();
        $data = DB::table('grpreg')
        ->whereIn('team_leader_regno', [$reg, session('regno')])
        ->orWhereIn('team_member_1_regno', [$reg, session('regno')])
        ->orWhereIn('team_member_2_regno', [$reg, session('regno')])
        ->orWhereIn('team_member_3_regno', [$reg, session('regno')])
        ->orWhere('userreg', $reg)
        ->get();
    
        $event=DB::table('eventdetail')->get();
        
       
        
        return view('registered')->with(['event'=>$event,'det'=>$det,'data'=>$data ]);
    }
    
    
    public function profile(){
$profile=DB::table('studentprofile')->where('email',session('email'))->first();

return view('stprofile')->with(['profile'=>$profile]);
    }
    public function sDashboard(){
        $events = DB::table('fest')->get();
        $check=DB::table('payverify')->where('rollno',session('regno'))->get();
        $prof=DB::table('studentprofile')->where('regno',session('regno'))->get();
        return view('sDashboard')->with(['events'=>$events,'check'=>$check,'prof'=>$prof]);
    }
    public function festdetails($fest, $department) {

        Session::put('festname', $fest);
        $regno = session('regno');
    $check = DB::table('payverify')
        ->where('rollno', $regno)
        ->first();

 

        
        // Retrieve events for the specified festival and department
        $data = DB::table('eventdetail')
                    ->where('fest', $fest)
                    ->where('department', $department)
                    ->where('eventtype', 'Closed')
                    ->get();
    
        // Retrieve all open events for the festival
        $all = DB::table('eventdetail')
                    ->where('fest', $fest)
                    ->where('eventtype', 'Open')
                    ->get();
        $price = DB::table('fest')
                  ->where('fest_name',$fest)
                  ->get();
                     
        // Retrieve registered events for the current user
        $reg = DB::table('regevent')
                                ->where('regno', session('regno'))
                                ->first(['registered_event']); // Fetch only the registered_event column
    
        // Pass the retrieved data and registered events status to the view
        return view('festdetails')->with([
            'data' => $data,
            'all' => $all,
            'fest' => $fest,
            'department' => $department,
            'reg' => $reg,
            'price'=>$price
        ]);
    
    }


    public function plans($fest){
        $fe=DB::table('fest')
        ->where('fest_name',$fest)
        ->get();
        return view('priceplan')->with(['fe'=>$fe]);
    }
    
    
    public function geteventregister($fest, $department){
        $data = DB::table('eventdetail')
        ->where('fest', $fest)
        ->where('department', $department)
        ->orWhere('department', 'ALL')
                    ->get();
        $boolean=DB::table('festfeed')->where('email',session('email'))->where('fest', $fest)->get('registered');
                    return view('eventregistration')->with(['data'=>$data,'fest'=>$fest,'registered'=>$boolean]);
    }
   
   public function registrations(Request $request) {
        // Validate the request data
        $request->validate([
            'data' => 'required|array', // Check if data array exists and is not empty
            'fest' => 'required|string',
            'email' => 'required|email',
            'regno' => 'required|string',
            'name' => 'required|string',
            'department' => 'required|string'
        ]);

        // Extract the input data
        $fest = $request->fest;
        $email = $request->email;
        $regno = $request->regno;
        $name = $request->name;
        $department = $request->department;
        $events = $request->data;

        foreach ($events as $eventName) {
        $existingRegistrations = DB::table('allocatemark')
            ->where('fest', $fest)
            ->where('email', $email)
            ->where('event',$eventName)
            ->count();

        if ($existingRegistrations > 0) {
            // If email already exists for the fest, handle accordingly
            return redirect()->back()->with('error', 'You have already registered for events in this fest.');
        }}

        // Store registration data for each selected event
        foreach ($events as $eventName) {
            DB::table('allocatemark')->insert([
                'name' => $name,
                'regno' => $regno,
                'email' => $email,
                'department' => $department,
                'fest' => $fest,
                'event' => $eventName,
               
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

DB::table('festfeed')->insert([
    'fest' => $fest,'email' => $email,'registered'=>True,
]);
        return redirect("/sfest/details/$fest/$department");
    }
    public function indreg($fest,$name){
        $events = DB::table('eventdetail')
        ->where('fest', $fest)
        ->where('name',$name)
        
                    ->get();
        return view('indreg')->with(['events'=>$events,'fest'=>$fest,'name'=>$name]);
    }
    public function grpreg($fest,$name){
        $events = DB::table('eventdetail')
        ->where('fest', $fest)
        ->where('name',$name)
        
                    ->get();
        return view('grpreg')->with(['events'=>$events,'fest'=>$fest,'name'=>$name]);
    }
    public function individualregistration(Request $request)
    {
        // Retrieve festival details based on the festival name
        $fest = DB::table('fest')
            ->where('fest_name', $request->input('fest'))
            ->first();
    
        if ($fest) {
            // Retrieve the user's plan associated with the festival
            $userPlan = DB::table('package_manager')
                ->where('fest', $request->input('fest'))
                ->where('regno', session('regno'))
                ->value('package');
    
            if ($userPlan === "Bronze") {
                $limit = $fest->brindlimit;
            } elseif ($userPlan === "Silver") {
                $limit = $fest->siindlimit;
            } else {
                $limit = $fest->goindlimit;
            }
    
            $existingUser = DB::table('regevent')
                ->where('name', $request->input('name'))
                ->where('dept', $request->input('department'))
                ->first();
    
            if ($existingUser) {
                // If the user already exists, check if the event is already registered
                $registeredEvents = explode(',', $existingUser->registered_event);
                $newEvent = $request->input('eventname');
    
                if (!in_array($newEvent, $registeredEvents)) {
                    // Check if the user has already registered the maximum allowed events
                    if (count($registeredEvents) < $limit) {
                        // If the event is not registered and the user has less than the maximum allowed events, proceed with registration
                        $this->updateRegisteredEvents($existingUser, $newEvent, $request);
                        return redirect()->back()->with('success', 'Registration successful!');
                    } else {
                        // If the user has already registered the maximum allowed events, return an error
                        return redirect()->back()->with('error', "You can only register for up to $limit events with the current plan.");
                    }
                } else {
                    // If the event is already registered for the user, return an error
                    return redirect()->back()->with('error', 'You are already registered for this event!');
                }
            } else {
                // If the user does not exist, insert a new record
                $this->insertNewUser($request);
                return redirect()->back()->with('success', 'Registration successful!');
            }
        } else {
            // If the festival details are not found, handle the error accordingly
            return redirect()->back()->with('error', 'Festival details not found.');
        }
    }
    
    
    // Function to update registered events
    private function updateRegisteredEvents($existingUser, $newEvent, $request)
    {
        // Append the new event to the existing registered events
        $updatedEvents = $existingUser->registered_event ? trim($existingUser->registered_event . ',' . $newEvent, ', ') : $newEvent;
    
        // Update the registered_event column
        DB::table('regevent')
            ->where('name', $request->input('name'))
            ->where('dept', $request->input('department'))
            ->update(['registered_event' => $updatedEvents]);
    
            $data = [
                'name' => $request->input('name'), // Assuming the name is stored in the request
                'eventname' => $request->input('eventname') // Assuming the event name is stored in the request
            ];
            // Send email notification since a new event was added for a new user
            $userEmail = $request->session()->get('email'); // Assuming email is stored in session
            Mail::to($userEmail)->send(new MailableName($data));
    }
    
    // Function to insert new user
    private function insertNewUser($request)
    {
        // Insert a new record for the user
        DB::table('regevent')->insert([
            'name' => $request->input('name'),
            'type' => $request->input('type'),
            'dept' => $request->input('department'),
            'eventdept' => $request->input('eventdept'),
            'registered_event' => $request->input('eventname'), // Insert the event directly
            'regno' => $request->input('regno'),
            'fest' => $request->input('fest'),
            'eventtype'=>$request->input('eventtype'),
            'email'=>$request->input('email'),
        ]);
        $data = [
            'name' => $request->input('name'), // Assuming the name is stored in the request
            'eventname' => $request->input('eventname') // Assuming the event name is stored in the request
        ];
        // Send email notification since a new event was added for a new user
        $userEmail = $request->session()->get('email'); // Assuming email is stored in session
        Mail::to($userEmail)->send(new MailableName($data));
        
    }
    
    
    
    public function groupregistration(Request $request)
    {
        // Fetch existing team details based on team name and leader regno
        $fest = DB::table('fest')
        ->where('fest_name', $request->input('fest'))
        ->first();

       
    
        if ($fest) {

            $userPlan = DB::table('package_manager')
            ->where('fest', $request->input('fest'))
            ->where('regno', session('regno'))
            ->value('package');

            if ($userPlan === "Bronze") {
                $limit = $fest->brgrplimit;
            } elseif ($userPlan === "Silver") {
                $limit = $fest->sigrplimit;
            } else {
                $limit = $fest->gogrplimit;
            }

            $existingTeam = DB::table('grpreg')
            ->where('userreg', $request->input('userreg'))
            ->first();
          
    if($existingTeam){


          // Check if the new event is already registered
          $registeredEvents = explode(', ', $existingTeam->registered_event);
          $newEvent = $request->input('eventname');
          if (!in_array($newEvent, $registeredEvents)) {
            // Check if the user has already registered the maximum allowed events
            if (count($registeredEvents) < $limit) {
                // If the event is not registered and the user has less than the maximum allowed events, proceed with registration
                $this->updateRegEvents($existingTeam, $newEvent, $request);
                return redirect()->back()->with('success', 'Registration successful!');
            } else {
                // If the user has already registered the maximum allowed events, return an error
                return redirect()->back()->with('error', "You can only register for up to $limit events with the current plan.");
            }
        } else {
            // If the event is already registered for the user, return an error
            return redirect()->back()->with('error', 'You are already registered for this event!');
        }
    } else {
        // If the user does not exist, insert a new record
        $this->insertUser($request);
        return redirect()->back()->with('success', 'Registration successful!');
    }
} else {
    // If the festival details are not found, handle the error accordingly
    return redirect()->back()->with('error', 'Festival details not found.');
}
       
    }

    private function updateRegEvents($existingTeam, $newEvent, $request)
    {
        $updatedEvents = $existingTeam->registered_event ? trim($existingTeam->registered_event . ',' . $newEvent, ', ') : $newEvent;
        // Update the registered_event column
        DB::table('grpreg')
        ->where('userreg', $request->input('userreg'))
        ->update(['registered_event' => $updatedEvents]);

        $dat = [
            'name'=>$request->input('name'),
            'teamname' => $request->input('team_name'), // Assuming the name is stored in the request
            'eventname' => $request->input('eventname') // Assuming the event name is stored in the request
        ];
        // Send email notification since a new event was added for a new user
        $userEmail = $request->input('team_leader_email'); // Assuming email is stored in session
        Mail::to($userEmail)->send(new RegistrationConfirmation($dat));
    
       
    }
    
    private function insertUser($request)
    {
        // Check if the team name already exists
        $existingTeam = DB::table('grpreg')
        ->where('team_name', $request->input('team_name'))
        ->get();
    
        $teamName = $request->input('team_name');
        $userRegNo = session('regno');
        
        // Check each team in the collection
        foreach ($existingTeam as $team) {
            // Check if the team name matches and the user registration number is different
            if ($team->team_name == $teamName && $team->userreg != $userRegNo) {
                return redirect()->back()->with('error', 'Team already exists. Please choose a different team name or user.');
            }
        }
       
        // If the team name is not taken, proceed with insertion
        DB::table('grpreg')->insert([
            'team_name' => $request->input('team_name'),
            'team_leader_name' => $request->input('team_leader_name'),
            'team_leader_regno' => $request->input('team_leader_regno'),
            'team_leader_email' => $request->input('team_leader_email'),
            'college_name' => $request->input('college_name'),
            'mobile_no' => $request->input('mobile_no'),
            'team_member_1' => $request->input('team_member_1'),
            'team_member_1_regno' => $request->input('team_member_1_regno'),
            'team_member_2' => $request->input('team_member_2'),
            'team_member_2_regno' => $request->input('team_member_2_regno'),
            'team_member_3' => $request->input('team_member_3'),
            'team_member_3_regno' => $request->input('team_member_3_regno'),
            'registered_event' => $request->input('eventname'),
            'type' => $request->input('type'),
            'fest'=>$request->input('fest'),
            'userreg'=>$request->input('userreg'),
            'eventtype'=>$request->input('eventtype'),
            'dept'=>$request->input('teamdepartment'),
        ]);
    
        $dat = [
            'name'=>$request->input('name'),
            'teamname' => $request->input('team_name'), // Assuming the name is stored in the request
            'eventname' => $request->input('eventname') // Assuming the event name is stored in the request
        ];
        // Send email notification since a new event was added for a new user
        $userEmail = $request->input('team_leader_email'); // Assuming email is stored in session
        Mail::to($userEmail)->send(new RegistrationConfirmation($dat));
    
        return redirect()->back()->with('success', 'Registration successful!');
    }
    

   


    public function teams(Request $request)
    {
       
    
        // Proceed with the registration since either the team does not exist or some details do not match
        DB::table('teams')->insert([
            'team_name' => $request->input('team_name'),
            'team_leader_name' => $request->input('team_leader_name'),
            'team_leader_regno' => $request->input('team_leader_regno'),
            'team_leader_email' => $request->input('team_leader_email'),
            'college_name' => $request->input('college_name'),
            'mobile_no' => $request->input('mobile_no'),
            'team_member_1' => $request->input('team_member_1'),
            'team_member_1_regno' => $request->input('team_member_1_regno'),
            'team_member_2' => $request->input('team_member_2'),
            'team_member_2_regno' => $request->input('team_member_2_regno'),
            'team_member_3' => $request->input('team_member_3'),
            'team_member_3_regno' => $request->input('team_member_3_regno'),
            'fest'=>$request->input('fest'),
            'userreg'=>$request->input('regno'),
            'dept'=>$request->input('teamdepartment'),
            
        ]);
    
  
    
        return redirect()->back()->with('success', 'Registration successful!');
    }
    public function teamsupdate(Request $request)
    {
       
    
        // Proceed with the registration since either the team does not exist or some details do not match
        DB::table('teams')
        ->where('userreg',session('regno'))
        ->update([
            'team_name' => $request->input('team_name'),
            'team_leader_name' => $request->input('team_leader_name'),
            'team_leader_regno' => $request->input('team_leader_regno'),
            'team_leader_email' => $request->input('team_leader_email'),
            'college_name' => $request->input('college_name'),
            'mobile_no' => $request->input('mobile_no'),
            'team_member_1' => $request->input('team_member_1'),
            'team_member_1_regno' => $request->input('team_member_1_regno'),
            'team_member_2' => $request->input('team_member_2'),
            'team_member_2_regno' => $request->input('team_member_2_regno'),
            'team_member_3' => $request->input('team_member_3'),
            'team_member_3_regno' => $request->input('team_member_3_regno'),
            'fest'=>$request->input('fest'),
            'userreg'=>$request->input('regno'),
            'dept'=>$request->input('teamdepartment'),
        ]);
    
  
    
        return redirect()->back()->with('success', 'Registration successful!');
    }
    
    
   

    public function pay(Request $request,$fest){
        $department = $request->session()->get('department');
     if($request->input('planname') == 'Bronze'){
        $image=$request->file('TIM');
        $extension=$image->getClientOriginalExtension();
        $filename=time().'.'.$extension;
        $path="img/";
        $image->move($path,$filename);
      DB::table('payverify')->insert([


        'username'=>$request->input('name'),
        'rollno'=>$request->input('rollno'),
        'package'=>$request->input('planname'),
        'transactionid'=>$request->input('TID'),
        'fest'=>$fest,
        'screenshot'=>$path.$filename,
        'status'=>'pending',
            
      ]);

     }
     elseif($request->input('planname')=='Silver'){
        $image=$request->file('TIM');
        $extension=$image->getClientOriginalExtension();
        $filename=time().'.'.$extension;
        $path="img/";
        $image->move($path,$filename);
        DB::table('payverify')->insert([

            'username'=>$request->input('name'),
            'rollno'=>$request->input('rollno'),
            'package'=>$request->input('planname'),
            'transactionid'=>$request->input('TID'),
            'fest'=>$fest,
            'screenshot'=>$path.$filename,
            'status'=>'pending',


        ]);
     }
     else{
        $image=$request->file('TIM');
        $extension=$image->getClientOriginalExtension();
        $filename=time().'.'.$extension;
        $path="img/";
        $image->move($path,$filename);
        DB::table('payverify')->insert([

            'username'=>$request->input('name'),
            'rollno'=>$request->input('rollno'),
            'package'=>$request->input('planname'),
            'transactionid'=>$request->input('TID'),
            'fest'=>$fest,
            'screenshot'=>$path.$filename,
            'status'=>'pending',
            
        ]);
     }
     

     return redirect()->action([studentcontroller::class, 'sDashboard']);



    }

}

    
    

    
    

