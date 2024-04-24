<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<title>Document</title><link rel="stylesheet" href="/bootstrap/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i&amp;display=swap">
    <link rel="stylesheet" href="/bootstrap/fonts/fontawesome-all.min.css">
    <script src="https://cdn.ckeditor.com/ckeditor5/41.1.0/classic/ckeditor.js"></script>
<script src="/bootstrap/bootstrap/js/bootstrap.min.js"></script>
    <script src="/bootstrap/js/bs-init.js"></script>
    <script src="/bootstrap/js/theme.js"></script>
   


</head>
<body>

@include('sidebar')
           
    

       

    <div class="padding">
        <div class="row justify-content-center " style="padding-top: 60px; margin:20px">
<div class="col-md-6 col-lg-4 w-75 h-50 mt-20">
            <form class="card" action="/events" method="post" style="padding: 60px;" enctype="multipart/form-data">
            @csrf
              <h5 class="h3 mb-0 text-gray-800" >Assign Events</h5>

              <div class="card-body mb-30 h-70" style="margin-bottom:20px;">

              <div class="form-group h-40" style="margin-top: 10px; margin-bottom: 10px;">
    <div class="col-md-12">
        <label class="labels">Event Name</label>
        <input class="form-control" name="eventname" type="text" placeholder="Event name" required value="{{ old('name') }}">
    </div>
</div>
<div class="form-group" style="margin-top: 10px; margin-bottom: 10px;">
    <div class="col-md-12">
        <label class="labels">Image</label>
        <input class="form-control" type="file" name="image"/>

    </div>
<div class="form-group" style="margin-top: 10px; margin-bottom: 10px;">
    <div class="col-md-12">
        <label class="labels">Category</label>
        <select class="form-select form-select-lg mb-3"style="border-radius:160px" name="eventid">
                                        <optgroup label="eventid">
                                            <option value="">Select event</option>
        <option value="Technical" >Technical</option>
        <option value="Non Technical" >Non Technical</option>
                                        </optgroup>
                                    </select>    </div>
</div>
<div class="form-group" style="margin-top: 10px; margin-bottom: 10px;">
    <div class="col-md-12">
        <label class="labels">Participant Type</label>
        <select class="form-select form-select-lg mb-3"style="border-radius:160px" name="type">
                                        <optgroup label="eventid">
                                            <option value="">Select Type</option>
        <option value="Individual" >Individual</option>
        <option value="Group" >Group</option>
                                        </optgroup>
                                    </select>    </div>
</div>
<div class="form-group" style="margin-top: 10px; margin-bottom: 10px;">
    <div class="col-md-12">
        <label class="labels">Event Type</label>
        <select class="form-select form-select-lg mb-3"style="border-radius:160px" name="eventtype">
                                        <optgroup label="eventid">
                                            <option value="">Select Type</option>
        <option value="Open" >Open</option>
        <option value="Closed" >Closed</option>
                                        </optgroup>
                                    </select>    </div>
</div>
<div class="form-group" style="margin-top: 10px; margin-bottom: 10px;">
    <div class="col-md-12">
        <label class="labels">Department</label>
        <select class="form-select form-select-lg mb-3"style="border-radius:160px" name="department">
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
<div class="form-group" style="margin-top: 10px; margin-bottom: 10px;">
    <div class="col-md-12">
        <label class="labels">Payment</label>
        <select class="form-select form-select-lg mb-3" style="border-radius: 160px" name="payment" id="paymentSelect">
            <optgroup label="Payment">
                <option value="">Select Payment</option>
                <option value="Paid" >Paid</option>
                <option value="Free" >Free</option>
            </optgroup>
        </select>
    </div>
</div>


 

<label class="labels" style="margin-top: 10px; margin-bottom: 10px;">Details</label>
    <textarea name="details" id="editor" cols="30" rows="10" class="form-control" ></textarea>
    <label class="labels" style="margin-top: 10px; margin-bottom: 10px;">Rules</label>
    <textarea name="rules" id="editor1" cols="30" rows="10" class="form-control" ></textarea>

    <script>
            ClassicEditor
                .create(document.querySelector('#editor'), {
                    minHeight: '300px'
                })
                .catch(error => {
                    console.error(error);
                });
</script> <script>
            ClassicEditor
                .create(document.querySelector('#editor1'), {
                    minHeight: '200px'
                })
                .catch(error => {
                    console.error(error);
                });
       
    </script>
 
  <input type="hidden" name="fest" value="{{ $fest }}">


                <button class="btn btn-block btn-bold btn-primary justify-content-center" style="margin-top: 50px;">Submit</button>
              </div>
            </form>
          </div>
           </div>
            </div>
             </div>


        

















   @if(session('success'))
    
    <div id="notification" style="width: 300px; height: auto; background-color: #1cc88a; color: black; position: fixed; top: 60px; right: 10px; border-radius: 10px; padding: 15px; display: flex; align-items: center;">
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
    <div id="notification" style="width: 300px; height: auto; background-color: #e74a3b; color: white; position: fixed; top: 60px; right: 10px; border-radius: 10px; padding: 15px; display: flex; align-items: center;">
        <div style="flex:top;">
            <img src="{{ asset('/img/error.gif') }}" alt=".gif" style="height: 50px; width: 50px;">
            <strong style="font-size: 20px; padding-right: 10px; padding-left: 5px;">Error</strong>
        </div> 
        <div class="ss" style="flex-bottom; text-size: 10px;">
            <ul>
               {{session('error')}}
            </ul>
        </div>
    </div>
@endif


@if ($errors->any())
    <div id="notification" style="width: 300px; height: auto; background-color: #e74a3b; color: white; position: fixed; top: 60px; right: 10px; border-radius: 10px; padding: 15px; display: flex; align-items: center;">
        <div style="flex:top;">
            <img src="{{ asset('/img/error.gif') }}" alt=".gif" style="height: 50px; width: 50px;">
            <strong style="font-size: 20px; padding-right: 10px; padding-left: 5px;">Error</strong>
        </div> 
        <div class="ss" style="flex-bottom; text-size: 10px;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endif

<script>
    setTimeout(function() {
        document.getElementById('notification').style.display = 'none';
    }, 5000); 
</script>









</body>
</html>
