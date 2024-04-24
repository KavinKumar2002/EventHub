<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;

use Illuminate\Support\Facades\Storage;
use App\Models\StudentData;
use Barryvdh\DomPDF\Facade\PDF;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Spatie\Browsershot\Browsershot;
use Dompdf\Dompdf;
use App\Mail\MailableName;
use App\Mail\RegistrationConfirmation;




class EventController extends Controller
{
    public function Festdata($fest){

        return view('addEvents')->with('fest',$fest);
    }
    public function dashboard() {
        $collegecode = session('collegecode');
        $events = DB::table('fest')->where('collegecode', $collegecode)->count();
        $completed = DB::table('fest')->where('completed', true)->count();
        return view('dashboard', ['events' => $events, 'completed' => $completed]);
    }
    public function Assign(Request $req) {
        $req->validate([
            'fest_name' => 'required|unique:fest',
            'start' => 'required|date',
            'end' => 'required|date',
            'image' => 'required',
            'details'=>'required'
        ]);
    
        $image=$req->file('image');
        $extension=$image->getClientOriginalExtension();
        $filename=time().'.'.$extension;
        $path="img/";
        $image->move($path,$filename);

        $image1=$req->file('qrcode');
        $extension1=$image1->getClientOriginalExtension();
        $path1="img/";
        $filename1=time().'.'.$extension1;
        $image1->move($path,$filename1);
        DB::table('fest')->insert([
            'fest_name' => $req->input('fest_name'),
            'start' => $req->input('start'),
            'end' => $req->input('end'),
            'collegecode' => $req->input('collegecode'),
            'image'=> $path.$filename,
            'details'=>$req->input('details'),
            'pricesilver'=>$req->input('pricesilver'),
            'siindlimit'=>$req->input('siindlimit'),
            'sigrplimit'=>$req->input('sigrplimit'),
            'pricebronze'=>$req->input('pricebronze'),
            'brindlimit'=>$req->input('brindlimit'),
            'brgrplimit'=>$req->input('brgrplimit'),
            'pricegold'=>$req->input('pricegold'),
            'goindlimit'=>$req->input('goindlimit'),
            'gogrplimit'=>$req->input('gogrplimit'),
            'upi'=>$req->input('upi'),
            'qrcode'=> $path.$filename1,

            'completed' => 0,


        ]);
    
        return redirect('AssignedFest');
    }
    
    public function Viewfest($fest){

        $eve=DB::table('eventdetail')->where('fest',$fest)->get();
        $eventcount=DB::table('eventdetail')->where('fest',$fest)->count();
        $indcount=DB::table('regevent')->where('type','Individual')->count();
        $grpcount=DB::table('grpreg')->where('type','Group')->count();
        
        $event=DB::table('eventdetail')->where('fest',$fest)->get();
       
        $indreg=DB::table('regevent')->where('type','Individual')->get();
        $grpreg=DB::table('grpreg')->where('type','Group')->get();
        session()->put('festname', $fest);

        
        return view('Viewfest')->with(['eve'=>$eve,'indcount'=>$indcount,'grpcount'=>$grpcount,'indreg'=>$indreg,'grpreg'=>$grpreg,'event'=>$event,'fest'=>$fest,'eventcount'=>$eventcount]);


    }
    public function Assigned(){
        $fest = DB::table('fest')
                    ->where('collegecode', session('collegecode'))
                    ->where('completed',0)
                    ->get();
                    
        return view('assignedFest')->with('fest', $fest);
    }

    public function events(Request $request){
 
    
        $existingEvent = DB::table('eventdetail')
            ->where('name', $request->input('eventname'))
            ->where('fest', $request->input('fest'))
            ->first();
    
        if ($existingEvent) {
            return redirect()->back()->with('error', 'Event already exists!');
        }
    
        $image=$request->file('image');
        $extension=$image->getClientOriginalExtension();
        $filename=time().'.'.$extension;
        $path="img/";
        $image->move($path,$filename);
      
    if ($request->input('payment') === 'Paid') {   
      
        DB::table('eventdetail')->insert([
            'name' => $request->input('eventname'),
            'cost' => $request->input('eventcost'), 
            'fest' => $request->input('fest'), 
            'event_id' => $request->input('eventid'),
            'rules'=>$request->input('rules'),
            'details'=>$request->input('details'),
            'department'=>$request->input('department'),
            'type'=>$request->input('type'),
            'image'=> $path.$filename,
            'eventtype'=>$request->input('eventtype'),
            'payment'=>$request->input('payment'),
        ]);
    }
    elseif($request->input('payment') === 'Free')
    {
        DB::table('eventdetail')->insert([
            'name' => $request->input('eventname'),
            'cost' => $request->input('eventcost'), 
            'fest' => $request->input('fest'), 
            'event_id' => $request->input('eventid'),
            'rules'=>$request->input('rules'),
            'details'=>$request->input('details'),
            'department'=>$request->input('department'),
            'type'=>$request->input('type'),
            'image'=> $path.$filename,
            'eventtype'=>$request->input('eventtype'),
            'payment'=>$request->input('payment'),
        ]); 
    }



        return redirect()->back()->with('success', 'Event added successfully!');
    }
    
    
public function completed(){
    
    $completed = DB::table('fest')->where('completed', 1)->count();
    return view('completed', [ 'completed' => $completed]);
}
public function EventsEdit(Request $request){
  
    if ($request->input('payment') === 'Paid') {   
        DB::table('eventdetail')
        ->where('id', $request->input('id'))
        ->update([
            'name' => $request->input('eventname'),
            'cost' => $request->input('eventcost'), 
            'fest' => $request->input('fest'), 
            'event_id' => $request->input('eventid'),
            'rules'=>$request->input('rules'),
            'details'=>$request->input('details'),
            'department'=>$request->input('department'),
            'type'=>$request->input('type'),
         
            'eventtype'=>$request->input('eventtype'),
            'payment'=>$request->input('payment'),
        ]);
    
    }
    elseif($request->input('payment') === 'Free')
    {
        DB::table('eventdetail')
        ->where('id', $request->input('id'))
        ->update([
            'name' => $request->input('eventname'),
            'cost' => $request->input('eventcost'), 
            'fest' => $request->input('fest'), 
            'event_id' => $request->input('eventid'),
            'rules'=>$request->input('rules'),
            'details'=>$request->input('details'),
            'department'=>$request->input('department'),
            'type'=>$request->input('type'),
          
            'eventtype'=>$request->input('eventtype'),
            'payment'=>$request->input('payment'),
        ]);
    
    }

    return redirect("/View/{$request->input('fest')}");
}

public function EditEvent($fest, $name) {
    $event = DB::table('eventdetail')
        ->where('fest', $fest)
        ->where('name', $name)
        ->first();
    return view('editevent')->with(['event' => $event]);
}
public function DeleteEvent($fest, $id, $name) {
    // Delete from eventdetail table
    DB::table('eventdetail')
        ->where('id', $id)
        ->delete();
    DB::table('separatereg')
        ->where('fest',$fest)
        ->where('event',$name)
        ->delete();
       
// Remove $name from the registered_event column in the regevent table
DB::table('regevent')
    ->where('registered_event', 'like', "%,$name,%") // Check for comma before and after $name
    ->orWhere('registered_event', 'like', "%,$name") // Check for comma before $name
    ->orWhere('registered_event', 'like', "$name,%") // Check for comma after $name
    ->orWhere('registered_event', '=', $name) // Check if $name is the only value
    ->update([
        'registered_event' => DB::raw("TRIM(BOTH ',' FROM REPLACE(CONCAT(',', registered_event, ','), ',$name,', ','))")
    ]);

    DB::table('grpreg')
    ->where('registered_event', 'like', "%,$name,%") // Check for comma before and after $name
    ->orWhere('registered_event', 'like', "%,$name") // Check for comma before $name
    ->orWhere('registered_event', 'like', "$name,%") // Check for comma after $name
    ->orWhere('registered_event', '=', $name) // Check if $name is the only value
    ->update([
        'registered_event' => DB::raw("TRIM(BOTH ',' FROM REPLACE(CONCAT(',', registered_event, ','), ',$name,', ','))")
    ]);

    return redirect("/View/{$fest}");
}


public function StudentFest($fest){
    $student=DB::table('studentdata')->where('fest',$fest);
    return view('StudentGet')->with(['fest'=>$fest,'student'=>$student]);
}
public function StudentFestPost(Request $request) {
    // Validate request data
    $validatedData = $request->validate([
        'data.*' => 'required',
        'fest' => 'required',
    ]);

    // Access the form data
    $fest = $request->input('fest');
    $data = $request->input('data');

    // Check for duplicates
    $hasDuplicate = DB::table('studentdata')
        ->where('fest', $fest)
        ->whereIn('data', $data)
        ->exists();

    if ($hasDuplicate) {
        return redirect("/fest/StudentGet/$fest")->with('error1', 'Failed to store data. Duplicate found.');
    }

    try {
        // Store data in the database using bulk insert
        $insertData = [];
        foreach ($data as $item) {
            $insertData[] = [
                'fest' => $fest,
                'data' => $item,
            ];
        }

        DB::table('studentdata')->insert($insertData);

        // Redirect with success message
        return redirect("/fest/StudentGet/$fest")->with('success', 'Data successfully stored!');
    } catch (\Exception $e) {
        // Redirect with error message
        return redirect("/fest/StudentGet/$fest")->with('error', 'Failed to store data. Please try again.');
    }
}
public function allocate($fest, $event) {
    // Retrieve registered events from regevent table
    $regevents = DB::table('regevent')->where('fest', $fest)->get();

    // Retrieve registered events from grpreg table
    $grpevents = DB::table('grpreg')->where('fest', $fest)->get();

    // Loop through regevents
    foreach ($regevents as $regevent) {
        // Split the registered event string into individual events
        $individualEvents = explode(',', $regevent->registered_event);

        // Loop through each individual event for this user
        foreach ($individualEvents as $individualEvent) {
            // Trim whitespace from each individual event
            $individualEvent = trim($individualEvent);

            // Check if the entry already exists in separatereg table
            $exists = DB::table('separatereg')
                ->where('name', $regevent->name)
                ->where('fest', $regevent->fest)
                ->where('event', $individualEvent)
                ->where('regno', $regevent->regno)
                ->exists();

            // If the entry doesn't exist, insert it into separatereg table
            if (!$exists) {
                DB::table('separatereg')->insert([
                    'name' => $regevent->name,
                    'fest' => $regevent->fest,
                    'event' => $individualEvent,
                    'regno' => $regevent->regno,
                    'mark' => $regevent->mark
                ]);
            }
        }
    }

    // Loop through grpevents
    foreach ($grpevents as $grpevent) {
        // Split the registered event string into individual events
        $individualEvents = explode(',', $grpevent->registered_event);

        // Loop through each individual event for this team
        foreach ($individualEvents as $individualEvent) {
            // Trim whitespace from each individual event
            $individualEvent = trim($individualEvent);

            // Check if the entry already exists in separatereg table
            $exists = DB::table('separatereg')
                ->where('name', $grpevent->team_name)
                ->where('fest', $grpevent->fest)
                ->where('event', $individualEvent)
                ->where('regno', $grpevent->team_leader_regno)
                ->exists();

            // If the entry doesn't exist, insert it into separatereg table
            if (!$exists) {
                DB::table('separatereg')->insert([
                    'name' => $grpevent->team_name,
                    'fest' => $grpevent->fest,
                    'event' => $individualEvent,
                    'regno' => $grpevent->team_leader_regno,
                    'mark' => $grpevent->mark
                ]);
            }
        }
    }

    // Retrieve data from the SeparateReg table
    $sep = DB::table('separatereg')
        ->where('fest', $fest)
        ->where('event', $event)
        ->get();

    return view('allocate')->with(['sep' => $sep]);
}


public function result($fest, $event){
$topThree = DB::table('separatereg')
    ->where('fest', $fest)
    ->where('event', $event)
    ->orderBy('mark', 'desc')
    
    ->limit(3)  
    ->get();

    $next = DB::table('separatereg')
    ->where('fest', $fest)
    ->where('event', $event)
    ->orderBy('mark', 'desc')
    ->skip(3)
    ->limit(PHP_INT_MAX) 
    ->get();

return view('eventresult')->with(['topThree' => $topThree, 'next' => $next,'event'=>$event]);

}

public function allocatemarks(Request $request)
{
    // Retrieve data from the request
    $name = $request->input('name');
    $fest = $request->input('fest');
    $event = $request->input('event');
    $regno = $request->input('regno');
    $marks = $request->input('mark');

    // Check if the data exists in the table
    $existingData = DB::table('separatereg')
        ->where('name', $name)
        ->where('fest', $fest)
        ->where('event', $event)
        ->where('regno', $regno)
        ->first();

    if ($existingData) {
        // Update marks if the data exists
        DB::table('separatereg')
            ->where('name', $name)
            ->where('fest', $fest)
            ->where('event', $event)
            ->where('regno', $regno)
            ->update(['mark' => $marks]);
    } 
    

    // Redirect back with success message
    return redirect()->back()->with('success', 'Marks updated successfully!');
}




public function generateCertificate(Request $request)
{
    $eventName = $request->input('eventname');

    // Fetch entries from the separatereg table matching the event name and where mark is not null
    $entries = DB::table('separatereg')
                ->where('event', $eventName)
                ->whereNotNull('mark')
                ->get();

    foreach ($entries as $entry) {
        $name = $entry->name;
        $regno = $entry->regno;

        // Fetch email from grpreg table using teamleader_regno
        $student = DB::table('studentprofile')->where('regno', $regno)->first();
        $email = $student ? $student->email : null;
       

        // If email not found in grpreg table, fetch email from student_detail table using regno
        if (!$email) {
            $teamLeader = DB::table('grpreg')->where('team_leader_regno', $regno);
        $email = $teamLeader ? $teamLeader->team_leader_email : null;
        }

        // If email found, generate PDF and send email
        if ($email) {
            // Generate PDF
            $pdf = PDF::loadView('certificate.pdf', ['name' => $name, 'event' => $eventName])->setPaper('a4', 'landscape');

            // Send email with PDF attachment
            Mail::send([], [], function ($message) use ($pdf, $name, $email) {
                $message->to($email)
                        ->subject('Certificate for Event')
                        ->attachData($pdf->output(), 'certificate.pdf');
            });

            // Update the 'certificates' column of the current entry with the generated PDF certificate
            DB::table('separatereg')
                ->where('name', $name)
                ->where('event', $eventName)
                ->update(['certificates' => 'generated']);
        }
    }

    return redirect()->back();
}

public function verify($fest){
    $verificationData = DB::table('payverify')
    ->where('fest', $fest)
    ->get();

    return view('paymentverification')->with(['verificationData'=>$verificationData,'fest'=>$fest]);
    

}
public function verifyupdate($fest, $regno, $package)
{
    // Check if the record already exists in the package_manager table
    $existingRecord = DB::table('package_manager')
        ->where('fest', $fest)
        ->where('regno', $regno)
        ->first();

    // If the record already exists, return the view without inserting new data
    if ($existingRecord) {
        $verificationData = DB::table('payverify')
            ->where('fest', $fest)
            ->get();

        return view('paymentverification')->with(['verificationData' => $verificationData, 'fest' => $fest]);
    }

    // If the record doesn't exist, insert new data into the package_manager table
    DB::table('package_manager')->insert([
        'package' => $package,
        'fest' => $fest,
        'regno' => $regno
    ]);

    // Update the status in the payverify table to 'verified'
    DB::table('payverify')
        ->where('fest', $fest)
       
        ->update(['status' => 'verified']);

    // Retrieve verification data for the view
    $verificationData = DB::table('payverify')
        ->where('fest', $fest)
        ->get();

    // Return the view with the updated data
    return view('paymentverification')->with(['verificationData' => $verificationData, 'fest' => $fest]);
}

public function indsearch(){
    $event=DB::table('eventdetail')->where('fest',session('festname'))
    ->where('type','Individual')
    ->get();
    $indcount=DB::table('regevent')->where('type','Individual')->count();
       
    $indreg=DB::table('regevent')->where('type','Individual')->get();
    return view('indsearch')->with(['event'=>$event,'indreg'=>$indreg,'indcount'=>$indcount]);
}
public function addexieve(Request $request){
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
                
                return redirect()->back()->with('success', 'Registration successful!');
            }
        } else {
            // If the festival details are not found, handle the error accordingly
            return redirect()->back()->with('error', 'Festival details not found.');
        }
}
private function updateRegisteredEvents($existingUser, $newEvent, $request)
    {
        // Append the new event to the existing registered events
        $updatedEvents = $existingUser->registered_event ? trim($existingUser->registered_event . ',' . $newEvent, ', ') : $newEvent;
    $eventtyp=$request->input('eventtype');
     $ch=DB::table('regevent')
       ->where('regno',$request->input('regno'))
       ->get();
        // Update the registered_event column
        if($eventtyp == 'Open'){
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
        elseif($eventtyp =='Closed' && $ch->eventdept == $request->input('department') ){
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
        else{
            return redirect()->back()->with('error','It is a closed Event');
        }
    }

    public function removeexieve(Request $request){
        $name=$request->input('eventname');
        DB::table('regevent')
        ->where('regno',$request->input('regno'))
    ->orwhere('registered_event', 'like', "%,$name,%") // Check for comma before and after $name
    ->orWhere('registered_event', 'like', "%,$name") // Check for comma before $name
    ->orWhere('registered_event', 'like', "$name,%") // Check for comma after $name
    ->orWhere('registered_event', '=', $name) // Check if $name is the only value
    ->update([
        'registered_event' => DB::raw("TRIM(BOTH ',' FROM REPLACE(CONCAT(',', registered_event, ','), ',$name,', ','))")
    ]);
    return redirect()->back()->with('success','Deleted Successfully');

    }
public function teamsearch(){
    $eve=DB::table('eventdetail')->where('fest',session('festname'))
    ->where('type','Group')
    ->get();
   
    $grpcount=DB::table('grpreg')->where('type','Group')->count();
    
    $event=DB::table('eventdetail')->where('fest',session('festname'))->get();

    $grpreg=DB::table('grpreg')->where('type','Group')->get();
 $fest=DB::table('eventdetail')->where('fest',session('festname'))->value('fest');
    return view('groupsearch')->with(['eve'=>$eve,'grpcount'=>$grpcount,'event'=>$event,'grpreg'=>$grpreg,'fest'=>$fest]);
}
public function addexiteameve(Request $request)
{
    // Fetch existing team details based on team name and leader regno
    $fest = DB::table('fest')
    ->where('fest_name', $request->input('fest'))
    ->first();

   

    if ($fest) {

        $userPlan = DB::table('package_manager')
        ->where('fest', $request->input('fest'))
        ->where('regno', $request->input('userreg'))
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

    $eventtyp = $request->input('eventtype');
    $ch = DB::table('grpreg')
        ->where('userreg', $request->input('userreg'))
        ->first(); // Retrieve the first record

    if ($eventtyp == 'Open') {
        $dat = [
            'name' => $request->input('team_leader_name'),
            'teamname' => $request->input('teamname'),
            'eventname' => $request->input('eventname')
        ];
        // Send email notification since a new event was added for a new user
        $userEmail = $request->input('team_leader_email');
        Mail::to($userEmail)->send(new RegistrationConfirmation($dat));
    } elseif ($eventtyp == 'Closed' && $ch->eventdept == $request->input('department')) {
        $dat = [
            'name' => $request->input('team_leader_name'),
            'teamname' => $request->input('teamname'),
            'eventname' => $request->input('eventname')
        ];
        // Send email notification since a new event was added for a new user
        $userEmail = $request->input('team_leader_email');
        Mail::to($userEmail)->send(new RegistrationConfirmation($dat));
    } else {
        return redirect()->back()->with('error', 'It is a closed Event');
    }
}



public function removeexiteameve(Request $request){
    $name=$request->input('eventname');
    DB::table('grpreg')
    ->where('userreg',$request->input('userreg'))
->orwhere('registered_event', 'like', "%,$name,%") // Check for comma before and after $name
->orWhere('registered_event', 'like', "%,$name") // Check for comma before $name
->orWhere('registered_event', 'like', "$name,%") // Check for comma after $name
->orWhere('registered_event', '=', $name) // Check if $name is the only value
->update([
    'registered_event' => DB::raw("TRIM(BOTH ',' FROM REPLACE(CONCAT(',', registered_event, ','), ',$name,', ','))")
]);
return redirect()->back()->with('success','Deleted Successfully');

}
public function viewfull(){
    $eve=DB::table('eventdetail')->where('fest',session('festname'))->get();
    $eventcount=DB::table('eventdetail')->where('fest',session('festname'))->count();
    $event=DB::table('eventdetail')->where('fest',session('festname'))->get();
    $fest=DB::table('eventdetail')->where('fest',session('festname'))->value('fest');
   return view('viewfull')->with(['eve'=>$eve,'eventcount'=>$eventcount,'event'=>$event,'fest'=>$fest]);

}
public function checkmarks(Request $request)
    {
        // Retrieve regno from the request
        $regno = $request->input('regno');

        // Check if marks are assigned for the given regno
        $marksAssigned =DB::table('separatereg')->where('regno', $regno)->exists();

        // Return response as JSON
        return response()->json(['marksAssigned' => $marksAssigned]);
    }


}

