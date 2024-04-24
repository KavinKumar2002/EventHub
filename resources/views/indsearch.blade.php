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
                                <th>Name</th>
                                <th>Register No</th>
                                <th>Department</th>
                                <th>Registered Event</th>
                                <th>Email</th>
                                <th>Mark</th>
                                <th>Add Event</th>
                                <th>Remove Event</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($indreg as $ind)
                            <tr>
                                <td>{{$ind->name}}</td>
                                <td>{{$ind->regno}}</td>
                                <td>{{$ind->dept}}</td>
                               
                                <td>{{$ind->registered_event}}</td>
                                <td>{{$ind->email}}</td>
                                <td>{{$ind->mark}}</td>
                                <td>
                                <button type="button" class="btn btn-block btn-bold btn-primary justify-content-center" style="margin-right:20px" data-toggle="modal" data-target="#addevent">
  Add Event
</button>   </td> 
<td><button type="button" class="btn btn-block btn-bold btn-primary justify-content-center"  style="margin-right:20px" data-toggle="modal" data-target="#removeevent">
 Remove Event
</button>     </td>
                               

                            </tr>
                            @endforeach
                        </tbody>
                    </table>
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
      <form name="grpreg" action="/addexieve" method="post">
                        @csrf
                        @foreach($indreg as $ind)
                        <div class="form-group mb-3">
            <label for="eventname">Event Name</label>
            <select class="form-control" name="eventname" id="eventname" required>
              <option value="">Select Event</option>

              @foreach($event as $inds)
    @php
        $eventName = $inds->name;
        $registeredEvents = $ind->registered_event;
    @endphp
    @if(strpos($registeredEvents, $eventName) === false)
        <option value="{{ $eventName }}">{{ $eventName }}</option>
    @endif
@endforeach


            </select>
          </div>
                        
                        <input name="eventtype" value="{{ $ind->eventtype }}" hidden>
                        <input name="email" value="{{ $ind->email }}" hidden>
                        <input name="regno" value="{{ $ind->regno }}" hidden>
                        <input name="fest" value="{{ $ind->fest }}" hidden>
                        <input name="name" value="{{ $ind->name }}" hidden>
                        <input name="department" value="{{ $ind->dept }}" hidden>
                      
                       
                       
                       
        
                      
                    
             
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
      <form name="grpreg" action="/removeexieve" method="post">
                        @csrf
                        @foreach($indreg as $ind)
                        <div class="form-group mb-3">
            <label for="eventname">Event Name</label>
            <select class="form-control" name="eventname" id="eventname" required>
              <option value="">Select Event</option>

              @foreach($event as $inds)
    @php
        $eventName = $inds->name;
        $registeredEvents = $ind->registered_event;
    @endphp
    @if(strpos($registeredEvents, $eventName) !== false)
        <option value="{{ $eventName }}">{{ $eventName }}</option>
    @endif
@endforeach



            </select>
          </div>
                       
                        <input name="regno" value="{{ $ind->regno }}" hidden>
                   
                      
                       
                       
                       
        
                      
                    
             
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
