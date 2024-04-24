<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="/bootstrap/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i&amp;display=swap">
    <link rel="stylesheet" href="/bootstrap/fonts/fontawesome-all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            margin-top: 70px;
        }
        .register {

            display: flex;
            align-items: center;
            justify-content: center;
            float: right;
            border-radius: 30px 8px 30px 30px;
            background-color: rgb(0, 96, 99);
            box-shadow: none;
            color: rgb(255, 255, 255);
            z-index: 2147483647;
            cursor: pointer;
            top: 70px;
            right: 20px;
            position: fixed;
            padding: 8px;
            margin-right: 20px;
            transition: all 0.1s ease-out 0s;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            -webkit-font-smoothing: antialiased;
        }
        .cards-1 {
            padding-top: 3.25rem;
            padding-bottom: 3rem;
            text-align: center;
        }
        @media (min-width: 576px) {
            .container {
                max-width: 540px;
            }
        }
        @media (min-width: 768px) {
            .container {
                max-width: 720px;
            }
            .h2-heading {
                width: 90%;
                margin-right: auto;
                margin-left: auto;
            }
        }
        h2 {
            color: #333;
            font: 700 2rem / 2.625rem "Open Sans", sans-serif;
            letter-spacing: -0.2px;
        }
        .card {
            display: inline-block;
            width: 17rem;
            max-width: 100%;
            margin-right: 1rem;
            margin-left: 1rem;
            vertical-align: top;
            max-width: 21rem;
            margin-right: auto;
            margin-bottom: 3.5rem;
            margin-left: auto;
            padding: 0;
            border: none;
        }

    </style>
</head>
<body>

@include('stud')
@php
    $isteam = DB::table('teams')
        ->where('userreg', session('regno'))
        ->where('fest',session('festname'))
        ->first();
@endphp

<div class="d-flex justify-content-center align-items-center mb-3">
    <div class="mr-2">
        <label>Add Team Details For Group Registration</label>
        <button type="button" class="btn btn-primary ml-2" data-toggle="modal" data-target="#exampleModal1" {{ $isteam ? 'disabled' : '' }}>
            Team Details
        </button>
    </div>
    <div>
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal23">
            Edit Team Details
        </button>
    </div>
</div>

   <!-- Modal -->
   
   <div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Team Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form name="grpreg" action="/group" method="post">
                        @csrf
                        <div class="form-group mb-3">
                            <label>Team Name</label>
                            <input class="form-control" name="team_name" type="text" placeholder="Team Name" required >
                        </div>
                        <div class="form-group mb-3">
                            <label>Team Leader Name</label>
                            <input class="form-control" name="team_leader_name" type="text" placeholder="Team Leader Name" required >
                        </div>
                        <div class="form-group mb-3">
                            <label>Team Leader Email</label>
                            <input class="form-control" name="team_leader_email" type="text" placeholder="Team Leader Email" required >
                        </div>
                        <div class="form-group mb-3">
                            <label>Team Leader Reg No</label>
                            <input class="form-control" name="team_leader_regno" type="text" placeholder="Team Leader Reg Nos" required >
                        </div>
                        <div class="form-group" style="margin-top: 10px; margin-bottom: 10px;">
    <div class="col-md-12">
        <label class="labels">Department</label>
        <select class="form-select form-select-lg mb-3"style="border-radius:160px" name="teamdepartment">
                                        <optgroup label="department">
                                            <option value="">Select department</option>
                                            
        <option value="CSE" >CSE</option>
        <option value="ECE" >ECE</option>
        <option value="EEE" >EEE</option>
        <option value="IT" >IT</option>
        <option value="MECH" >MECH</option>
                                        </optgroup>
                                    </select>    </div>
</div>
                        <div class="form-group mb-3">
                            <label>College Name</label>
                            <input class="form-control" name="college_name" type="text" placeholder="College Name" required >
                        </div>
                        <div class="form-group mb-3">
                            <label>Mobile No</label>
                            <input class="form-control" name="mobile_no" type="text" placeholder="Mobile No" required >
                        </div>
                        <div class="form-group mb-3">
                            <label>Team Member 1</label>
                            <input class="form-control" name="team_member_1" type="text" placeholder="Team Member 1" >
                        </div>
                        <div class="form-group mb-3">
                            <label>Team Member 1 Reg No</label>
                            <input class="form-control" name="team_member_1_regno" type="text" placeholder="Team Member 1 Reg no">
                        </div>
                        <div class="form-group mb-3">
                            <label>Team Member 2</label>
                            <input class="form-control" name="team_member_2" type="text" placeholder="Team Member 2" >
                        </div>
                        <div class="form-group mb-3">
                            <label>Team Member 2 Reg No</label>
                            <input class="form-control" name="team_member_2_regno" type="text" placeholder="Team Member 2 Reg no" >
                        </div>
                        <div class="form-group mb-3">
                            <label>Team Member 3</label>
                            <input class="form-control" name="team_member_3" type="text" placeholder="Team Member 3" >
                        </div>
                        <div class="form-group mb-3">
                            <label>Team Member 3 Reg No</label>
                            <input class="form-control" name="team_member_3_regno" type="text" placeholder="Team Member 3 Reg no" >
                        </div>
                       
        
                        <input type="hidden" name="fest" value="{{ session('festname') }}">
                        <input type="hidden" name="regno" value="{{ session('regno') }}">
                    
             
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Submit</button>

        </form>
      </div>
    </div>
  </div>
</div>
                        


<div class="modal fade" id="exampleModal23" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Team</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      
      <form name="grpreg" action="/teamupdate" method="post">
                        @csrf
                        @php
                        $team=DB::table('teams')
                        ->where('userreg',session('regno'))
                        ->get();

                        @endphp
                        @foreach($team as $tea)
                        <div class="form-group mb-3">
                            <label>Team Name</label>
                            <input class="form-control" name="team_name" type="text" placeholder="Team Name" required value="{{$tea->team_name }}">
                        </div>
                        <div class="form-group mb-3">
                            <label>Team Leader Name</label>
                            <input class="form-control" name="team_leader_name" type="text" placeholder="Team Leader Name" required value="{{ $tea->team_leader_name}}">
                        </div>
                        <div class="form-group mb-3">
                            <label>Team Leader Email</label>
                            <input class="form-control" name="team_leader_email" type="text" placeholder="Team Leader Email" required value="{{ $tea->team_leader_email }}">
                        </div>
                        <div class="form-group mb-3">
                            <label>Team Leader Reg No</label>
                            <input class="form-control" name="team_leader_regno" type="text" placeholder="Team Leader Reg Nos" required value="{{ $tea->team_leader_regno }}">
                        </div>
                        <div class="col-md-12">
        <label class="labels">Department</label>
        <select class="form-select form-select-lg mb-3"style="border-radius:160px" name="teamdepartment">
                                        <optgroup label="department">
                                            <option value="">Select department</option>
                                            
        <option value="CSE" >CSE</option>
        <option value="ECE" >ECE</option>
        <option value="EEE" >EEE</option>
        <option value="IT" >IT</option>
        <option value="MECH" >MECH</option>
                                        </optgroup>
                                    </select>    </div>
</div>
                        <div class="form-group mb-3">
                            <label>College Name</label>
                            <input class="form-control" name="college_name" type="text" placeholder="College Name" required value="{{ $tea->college_name }}">
                        </div>
                        <div class="form-group mb-3">
                            <label>Mobile No</label>
                            <input class="form-control" name="mobile_no" type="text" placeholder="Mobile No" required value="{{ $tea->mobile_no}}">
                        </div>
                        <div class="form-group mb-3">
                            <label>Team Member 1</label>
                            <input class="form-control" name="team_member_1" type="text" placeholder="Team Member 1" value="{{ $tea->team_member_1 }}">
                        </div>
                        <div class="form-group mb-3">
                            <label>Team Member 1 Reg No</label>
                            <input class="form-control" name="team_member_1_regno" type="text" placeholder="Team Member 1 Reg no" value="{{ $tea->team_member_1}}">
                        </div>
                        <div class="form-group mb-3">
                            <label>Team Member 2</label>
                            <input class="form-control" name="team_member_2" type="text" placeholder="Team Member 2" value="{{ $tea->team_member_2 }}">
                        </div>
                        <div class="form-group mb-3">
                            <label>Team Member 2 Reg No</label>
                            <input class="form-control" name="team_member_2_regno" type="text" placeholder="Team Member 2 Reg no" value="{{ $tea->team_member_1 }}">
                        </div>
                        <div class="form-group mb-3">
                            <label>Team Member 3</label>
                            <input class="form-control" name="team_member_3" type="text" placeholder="Team Member 3" value="{{ $tea->team_member_3}}">
                        </div>
                        <div class="form-group mb-3">
                            <label>Team Member 3 Reg No</label>
                            <input class="form-control" name="team_member_3_regno" type="text" placeholder="Team Member 3 Reg no" value="{{ $tea->team_member_1 }}">
                        </div>
                        <input type="hidden" name="fest" value="{{ session('festname') }}">
                        <input type="hidden" name="regno" value="{{ session('regno') }}">
                    
             @endforeach
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Submit</button>

        </form>
      </div>
    </div>
  </div>
</div>


<div class="cards-1">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="above-heading"  style="font-size:20px;font-weight:bold;">Events</div>
                <h2 class="h2-heading">Events conducted by the {{session('department')}} department include both technical and non-technical activities.</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <!-- Card 1 -->@foreach($data as $events)
                <div class="card">
                    <div class="card-image">
                        <img class="img-fluid" src="{{asset($events->image)}}" alt="alternative">
                    </div>
                    <div class="card-body">
                   

                    <p><strong>Event Name:</strong> {{$events->name}}</p>
                    <p><strong>Participant Type:</strong> {{ $events->type }}</p>
                    <p><strong>Department:</strong> {{ $events->department }}</p>
                    @if($events->payment == 'Free')
                    <p><strong>Cost:</strong> Free</p>
                    @else
                    <p><strong>Cost:</strong> Paid</p>
                    @endif
                    <p><strong>Event Details:</strong>{!! $events->details !!}</p>
                    <p><strong>Event Rules:</strong>{!! $events->rules !!}</p>
    
            @if($events->type == 'Individual')
            <form id="registrationForm_{{ $events->id }}" action="/individualregistration" method="POST">
                            @csrf
                            <input type="hidden" name="eventname" value="{{ $events->name }}">
                            <input type="hidden" name="type" value="{{ $events->type }}">
                            <input type="hidden" name="eventdept" value="{{ $events->department }}">
                            <input type="hidden" name="name" value="{{ session('name') }}">
                            <input type="hidden" name="department" value="{{ session('department') }}">
                            <input type="hidden" name="regno" value="{{ session('regno') }}">
                            <input type="hidden" name="fest" value="{{ $events->fest }}">
                            <input type="hidden" name="eventtype" value="{{ $events->eventtype }}">
                            <input type="hidden" name="email" value="{{ session('email') }}">
                          
                            @php
    // Retrieve existing data from the table
    $existingData = DB::table('regevent')
        ->where('regno', session('regno'))
        ->where('dept', session('department'))
        ->first();
    
    // Check if the eventname is present in the registered events
    $appendedValueExists = $existingData && strpos($existingData->registered_event, $events->name) !== false;
    
    // Set disabled attribute based on whether the eventname exists in the registered events
    $disabled = $appendedValueExists ? 'disabled' : '';
@endphp

    <button type="submit" class="btn btn-primary individual-register-btn" data-id="{{ $events->id }}" {{ $disabled }}>Individual Registration</button>
                        </form>
                        @elseif($events->type == 'Group')
                        @php
$team=DB::table('teams')
->where('userreg',session('regno'))
->get();
                            @endphp 
                        @if($team->isNotEmpty())
                        <form id="registrationForm1_{{ $events->id }}" action="/groupregistration" method="POST">
                            @csrf
                            @php
$team=DB::table('teams')
->where('userreg',session('regno'))
->get();
                            @endphp
                            @foreach($team as $tea)
                            <input type="hidden" name="team_name" value="{{ $tea->team_name }}">
    <input type="hidden" name="team_leader_name" value="{{ $tea->team_leader_name }}">
    <input type="hidden" name="team_leader_email" value="{{ $tea->team_leader_email }}">
    <input type="hidden" name="team_leader_regno" value="{{ $tea->team_leader_regno }}">
    <input type="hidden" name="college_name" value="{{ $tea->college_name }}">
    <input type="hidden" name="mobile_no" value="{{ $tea->mobile_no }}">
    <input type="hidden" name="team_member_1" value="{{ $tea->team_member_1 }}">
    <input type="hidden" name="team_member_1_regno" value="{{ $tea->team_member_1 }}">
    <input type="hidden" name="team_member_2" value="{{ $tea->team_member_2 }}">
    <input type="hidden" name="team_member_2_regno" value="{{ $tea->team_member_1 }}">
    <input type="hidden" name="team_member_3" value="{{ $tea->team_member_3 }}">
    <input type="hidden" name="team_member_3_regno" value="{{ $tea->team_member_1 }}">
    <input type="hidden" name="teamdepartment" value="{{ $tea->dept }}">
    
   
    <input type="hidden" name="type" value="{{$events->type}}">
                        <input type="hidden" name="eventname" value="{{ $events->name }}">
                        <input type="hidden" name="fest" value="{{ $events->fest }}">
                        <input type="hidden" name="userreg" value="{{ session('regno') }}">
                        <input type="hidden" name="eventtype" value="{{ $events->eventtype }}">
                          
                            @php
    // Retrieve existing data from the table
    $existingData = DB::table('grpreg')
        ->where('userreg', session('regno'))
        ->first();
    
    // Check if the eventname is present in the registered events
    $appendedValueExists = $existingData && strpos($existingData->registered_event, $events->name) !== false;
    
    // Set disabled attribute based on whether the eventname exists in the registered events
    $disabled = $appendedValueExists ? 'disabled' : '';
@endphp

    <button type="submit" class="btn btn-primary group-register-btn" data-id="{{ $events->id }}" {{ $disabled }}>Group Registration</button>
    @endforeach                  
</form>
@else
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#demobutton">
                                                    Group Registration
</button>
@endif

                      <!-- Modal -->
                      <div class="modal fade" id="demobutton" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
    <div class="modal-content">
      <!-- Modal Header -->
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Modal Title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <!-- Modal Body -->
      <div class="modal-body">
      Please ensure your team is created before proceeding with event registration
      </div>
      <!-- Modal Footer with OK button acting as close button -->
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
      </div>
    </div>
  </div>
</div>

                     
           


    @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<div class="cards-1">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="above-heading" style="font-size:20px;font-weight:bold;">Events</div>
                <h2 class="h2-heading">Students from the {{session('department')}} department and all other departments can participate in the events, which include both technical and non-technical activities.</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <!-- Card 1 -->@foreach($all as $events)
                <div class="card">
                    <div class="card-image">
                        <img class="img-fluid" src="{{asset($events->image)}}" alt="alternative">
                    </div>
                    <div class="card-body">
                       
                        <p><strong>Event Name:</strong> {{$events->name}}</p>
                    <p><strong>Participant Type:</strong> {{ $events->type }}</p>
                    <p><strong>Department:</strong> {{ $events->department }}</p>
                    @if($events->payment == 'Free')
                    <p><strong>Cost:</strong> Free</p>
                    @else
                    <p><strong>Cost:</strong> Paid</p>
                    @endif
                    <p><strong>Event Details:</strong>{!! $events->details !!}</p>
                    <p><strong>Event Rules:</strong>{!! $events->rules !!}</p>
                        @if($events->type == 'Individual')
                        <form id="registrationForm_{{ $events->id }}" action="/individualregistration" method="POST">
                            @csrf
                            <input type="hidden" name="eventname" value="{{ $events->name }}">
                            <input type="hidden" name="type" value="{{ $events->type }}">
                            <input type="hidden" name="eventdept" value="{{ $events->department }}">
                            <input type="hidden" name="name" value="{{ session('name') }}">
                            <input type="hidden" name="department" value="{{ session('department') }}">
                            <input type="hidden" name="regno" value="{{ session('regno') }}">
                            <input type="hidden" name="email" value="{{ session('email') }}">
                            <input type="hidden" name="fest" value="{{ $events->fest }}">
                            <input type="hidden" name="eventtype" value="{{ $events->eventtype }}">
                          
                            @php
    // Retrieve existing data from the table
    $existingData = DB::table('regevent')
        ->where('regno', session('regno'))
        ->where('dept', session('department'))
        ->first();
    
    // Check if the eventname is present in the registered events
    $appendedValueExists = $existingData && strpos($existingData->registered_event, $events->name) !== false;
    
    // Set disabled attribute based on whether the eventname exists in the registered events
    $disabled = $appendedValueExists ? 'disabled' : '';
@endphp

    <button type="submit" class="btn btn-primary individual-register-btn" data-id="{{ $events->id }}" {{ $disabled }}>Individual Registration</button>
                        </form>
                        @elseif($events->type == 'Group') 
                        @php
$team=DB::table('teams')
->where('userreg',session('regno'))
->get();
                            @endphp 
                        @if($team->isNotEmpty())

                        <form id="registrationForm1_{{ $events->id }}" action="/groupregistration" method="POST">
                            @csrf
                           
                            @foreach($team as $tea)
                            <input type="hidden" name="team_name" value="{{ $tea->team_name }}">
    <input type="hidden" name="team_leader_name" value="{{ $tea->team_leader_name }}">
    <input type="hidden" name="team_leader_email" value="{{ $tea->team_leader_email }}">
    <input type="hidden" name="team_leader_regno" value="{{ $tea->team_leader_regno }}">
    <input type="hidden" name="college_name" value="{{ $tea->college_name }}">
    <input type="hidden" name="mobile_no" value="{{ $tea->mobile_no }}">
    <input type="hidden" name="team_member_1" value="{{ $tea->team_member_1 }}">
    <input type="hidden" name="team_member_1_regno" value="{{ $tea->team_member_1 }}">
    <input type="hidden" name="team_member_2" value="{{ $tea->team_member_2 }}">
    <input type="hidden" name="team_member_2_regno" value="{{ $tea->team_member_1 }}">
    <input type="hidden" name="team_member_3" value="{{ $tea->team_member_3 }}">
    <input type="hidden" name="team_member_3_regno" value="{{ $tea->team_member_1 }}">
    <input type="hidden" name="teamdepartment" value="{{ $tea->dept }}">
    
    <input type="hidden" name="type" value="{{$events->type}}">
                        <input type="hidden" name="eventname" value="{{ $events->name }}">
                        <input type="hidden" name="fest" value="{{ $events->fest }}">
                        <input type="hidden" name="userreg" value="{{ session('regno') }}">
                        <input type="hidden" name="eventtype" value="{{ $events->eventtype }}">
                        
                          
                            @php
    // Retrieve existing data from the table
    $existingData = DB::table('grpreg')
        ->where('userreg', session('regno'))
        ->first();
    
    // Check if the eventname is present in the registered events
    $appendedValueExists = $existingData && strpos($existingData->registered_event, $events->name) !== false;
    
    // Set disabled attribute based on whether the eventname exists in the registered events
    $disabled = $appendedValueExists ? 'disabled' : '';
@endphp

    <button type="submit" class="btn btn-primary group-register-btn" data-id="{{ $events->id }}" {{ $disabled }}>Group Registration</button>
    @endforeach                       
</form>
@else
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#demobutton1">
                                                    Group Registration
</button>
@endif

                      <!-- Modal -->
                      <div class="modal fade" id="demobutton1" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
    <div class="modal-content">
      <!-- Modal Header -->
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Modal Title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <!-- Modal Body -->
      <div class="modal-body">
      Please ensure your team is created before proceeding with event registration
      </div>
      <!-- Modal Footer with OK button acting as close button -->
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
      </div>
    </div>
  </div>
</div>

              
                        

                



    @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<script>
    function showPopupForm() {
        $('#popupForm').modal('show');
    }
</script>
<script>
    $(document).ready(function() {
        $('.individual-register-btn').click(function() {
            var eventId = $(this).data('id');
            var formData = $('#registrationForm_' + eventId).serialize();
            $.ajax({
                url: '/individualregistration', // Updated URL
                type: 'POST',
                data: formData,
                success: function(response) {
                    alert('Registration successful!');
                    // Handle success, if needed
                },
                error: function(xhr, status, error) {
                    alert('Registration failed. Please try again later.');
                    // Handle error, if needed
                }
            });
        });

        $('.group-register-btn').click(function() {
            var eventId = $(this).data('id');
            var formData = $('#registrationForm1_' + eventId).serialize();
            $.ajax({
                url: '/groupregistration', // Updated URL
                type: 'POST',
                data: formData,
                success: function(response) {
                    alert('Registration successful!');
                    // Handle success, if needed
                },
                error: function(xhr, status, error) {
                    alert('Registration failed. Please try again later.');
                    // Handle error, if needed
                }
            });
        });
    });
</script>

@if(session('success'))
    <div id="notification-success" style="width: 300px; height: auto; background-color: #1cc88a; color: black; position: fixed; top: 60px; right: 10px; border-radius: 10px; padding: 15px; display: flex; align-items: center;">
        <div style="flex:top;">
            <img src="{{ asset('/img/success.gif') }}" alt=".gif" style="height: 50px; width: 50px;">
            <strong style="font-size: 20px; padding-right: 10px; padding-left: 5px;">Success</strong>
        </div> 
        <div class="ss" style="flex-bottom; text-size: 10px;">
            <ul>
                {{ session('success') }}
            </ul>
        </div>
    </div>
@endif

@if (session('error'))
    <div id="notification-error" style="width: 300px; height: auto; background-color: #e74a3b; color: white; position: fixed; top: 60px; right: 10px; border-radius: 10px; padding: 15px; display: flex; align-items: center;">
        <div style="flex:top;">
            <img src="{{ asset('/img/error.gif') }}" alt=".gif" style="height: 50px; width: 50px;">
            <strong style="font-size: 20px; padding-right: 10px; padding-left: 5px;">Error</strong>
        </div> 
        <div class="ss" style="flex-bottom; text-size: 10px;">
            <ul>
                {{ session('error') }}
            </ul>
        </div>
    </div>
@endif

<script>
    // Function to hide the success notification after 10 seconds
    setTimeout(function() {
        document.getElementById('notification-success').style.display = 'none';
    }, 5000);

    // Function to hide the error notification after 10 seconds
    setTimeout(function() {
        document.getElementById('notification-error').style.display = 'none';
    }, 5000);
</script>



<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
