<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="/bootstrap/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i&amp;display=swap">
    <link rel="stylesheet" href="/bootstrap/fonts/fontawesome-all.min.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="/bootstrap/bootstrap/js/bootstrap.min.js"></script>
    <script src="/bootstrap/js/bs-init.js"></script>
    <script src="/bootstrap/js/theme.js"></script>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .my-custom-scrollbar {
            position: relative;
            height: 200px;
            overflow: auto;
        }

        .table-wrapper-scroll-y {
            display: block;
        }

        img {
            margin-right: 20px;
            cursor: pointer;
        }
    </style>
</head>

<body>

    @include('sidebar')
    <div class="page-content page-container mt-20" id="page-content" style="margin-top:60px !important;">
        <div class="container-fluid" style="margin: bottom 20px; "> 

    <div class="container-fluid" style="margin-top:20px !important">
        <div class="card shadow">
            <div class="card-header py-3">
                <div class="row" style="overflow: hidden;">
                    <div class="col-md-6 text-nowrap flex-left" style="float: left;">
                        <p class="text-primary m-0 fw-bold mk">Group Registration</p>
                    </div>
                    <div class="col-md-6">
                        <div class="text-md-end dataTables_filter" id="dataTable_filter"
                            style="margin-right:20px">
                            <div>
                                <p> <strong><bold>Count:  {{$grpcount }}</bold></strong></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="form-outline mb-4" data-mdb-input-init>
                    <input type="search" placeholder="search" class="form-control" id="datatable-search-input">
                    
                </div>
                <div class="table-responsive table mt-2" id="dataTable-1" role="grid"
                    aria-describedby="dataTable_info">
                    <table class="table my-0" id="dataTable">
                        
                        <thead>
                                <tr>
                                    
                                    <th>Team Name</th>
                                    <th>Type</th>
                                    <th>Leader Name</th>
                                    <th>College Name</th>
                                    <th>Mobile No.</th>
                                  
                                    <th>Registered Events</th>
                                    <th>Add Events</th>
                                    <th>Remove Events</th>
                                </tr>
                            </thead>
                            <tbody>
                          
                                @foreach($grpreg as $grp)
                                @if($grp->fest === $fest)
                               
                                <tr>
                                <td data-bs-toggle="modal" data-bs-target="#exampleModal0"
                                        style="cursor:pointer;">{{$grp->team_name}}<img width="15px" height="15px"
                                            src="{{ asset('/img/about.png') }}" alt="Delete"></td>
                                
                                    <td>{{$grp->type}}</td>
                                    <td>{{$grp->team_leader_name}}</td>
                                    <td>{{$grp->college_name}}</td>
                                    <td>{{$grp->mobile_no}}</td>

                                    <td>{{$grp->registered_event}}</td>
                                    <td>
                                <button type="button" class="btn btn-block btn-bold btn-primary justify-content-center" style="margin-right:20px" data-toggle="modal" data-target="#addevent">
  Add Event
</button>   </td> 
<td><button type="button" class="btn btn-block btn-bold btn-primary justify-content-center"  style="margin-right:20px" data-toggle="modal" data-target="#removeevent">
 Remove Event
</button>     </td>

                                </tr>
                           
  <!-- Modal -->
  <div class="modal fade" id="exampleModal0" tabindex="-1"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="exampleModalLabel">Team Members
                                                </h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                          
                                           
                                                <p>Team Member 1: {!! $grp->team_member_1 !!}</p>
                                            
                                                <p>Team Member 2: {!! $grp->team_member_2  !!}</p>
                                             
                                                <p>Team Member 3 {!! $grp->team_member_3  !!}</p>
                                             
                                          

                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Close</button>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                               

                                @endif
                                @endforeach
                            </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>

    <script>
        $(document).ready(function () {
            $('#datatable-search-input').on('keyup', function () {
                var searchText = $(this).val().toLowerCase();
                $('#dataTable tbody tr').each(function () {
                    var lineStr = $(this).text().toLowerCase();
                    if (lineStr.indexOf(searchText) === -1) {
                        $(this).hide();
                    } else {
                        $(this).show();
                    }
                });
            });
        });
    </script>
    <!-- Modal -->
<div class="modal fade" id="addevent" tabindex="-1" aria-labelledby="addeventLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addeventLabel">Add Existing Event</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form name="grpreg" action="/addexiteameve" method="post">
                        @csrf
                        @foreach($grpreg as $grp)
                        <div class="form-group mb-3">
            <label for="eventname">Event Name</label>
            <select class="form-control" name="eventname" id="eventname" required>
              <option value="">Select Event</option>

              @foreach($eve as $inds)
    @php
        $eventName = $inds->name;
        $registeredEvents = $grp->registered_event;
    @endphp
    @if(strpos($registeredEvents, $eventName) === false)
        <option value="{{ $eventName }}">{{ $eventName }}</option>
    @endif
@endforeach


            </select>
          </div>
                        <input name="userreg" value="{{ $grp->userreg }}" hidden/>
                     <input name="team_leader_email" value="{{ $grp->team_leader_email }}" hidden/>
                     <input name="team_leader_name" value="{{ $grp->team_leader_name }}" hidden/>
                     <input name="teamname" value="{{ $grp->team_name }}" hidden/>
                     <input name="teamdepartment" value="{{ $grp->dept }}" hidden/>
                     <input name="fest" value="{{ $grp->fest }}" hidden/>
                     <input name="userreg" value="{{ $grp->userreg }}" hidden/>
                     <input name="eventtype" value="{{ $grp->eventtype }}" hidden/>
                      
                       
                       
                       
        
                      
                    
             
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>

    @endforeach
        </form>
     
      
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="removeevent" tabindex="-1" aria-labelledby="removeeventLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="removeeventLabel">Remove Existing Event</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form name="grpreg" action="/removeexiteameve" method="post">
                        @csrf
                        @foreach($grpreg as $grp)
                        <div class="form-group mb-3">
            <label for="eventname">Event Name</label>
            <select class="form-control" name="eventname" id="eventname" required>
              <option value="">Select Event</option>

              @foreach($eve as $inds)
              @php
        $eventName = $inds->name;
        $registeredEvents = $grp->registered_event;
    @endphp
    @if(strpos($registeredEvents, $eventName) !== false)
        <option value="{{ $eventName }}">{{ $eventName }}</option>
    @endif
@endforeach



            </select>
          </div>
                        <input name="userreg" value="{{ $grp->userreg }}" hidden/>
                        <input name="teamname" value="{{ $grp->team_name }}" hidden/>
                        <input name="email" value="{{ $grp->team_leader_email }}" hidden/>
                   
                      
                       
                       
                       
        
                      
                    
             
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>

    @endforeach
        </form>
      </div>
     
    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>

</html>
