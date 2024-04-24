<!doctype html>
<html lang="en">
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">

  <title>Bootstrap 5.0 Pricing Table</title>

  <style>

    .card1:hover {
      background:#00ffb6;
      border:1px solid #00ffb6;
    }

    .card1:hover .list-group-item{
      background:#00ffb6 !important
    }


    


    .card2:hover {
      background:#00C9FF;
      border:1px solid #00C9FF;
    }

    .card2:hover .list-group-item{
      background:#00C9FF !important
    }


    .card3:hover {
      background:#ff95e9;
      border:1px solid #ff95e9;
    }

    .card3:hover .list-group-item{
      background:#ff95e9 !important
    }


    .card:hover .btn-outline-dark{
      color:white;
      background:#212529;
    }

  </style>

</head>
<body>

@foreach($fe as $fes)
<div class="container-fluid">
    <div class="container p-5">
      <div class="row">
        <div class="col-lg-4 col-md-12 mb-4">
          <div class="card card1 h-100">
            <div class="card-body">
              <h5 class="card-title">Bronze</h5>
              <br><br>
              <span class="h2">₹{{$fes->pricebronze}}</span>
              <br><br>
              <div class="d-grid my-3">
                <button class="btn btn-outline-dark btn-block" data-bs-toggle="modal" data-bs-target="#bronzeModal{{$fes->id}}">Select</button>
              </div>
              <p><span><strong>PERKS:</strong></span></p>
              <p>INDIVIDUAL EVENTS:{!! $fes->brindlimit !!}</p>
              <p>GROUP EVENTS:{!! $fes->brgrplimit !!}</p>
            </div>
          </div>
        </div>

        <!--model for bronze-->
        <div class="modal fade" id="bronzeModal{{$fes->id}}" tabindex="-1" aria-labelledby="bronzeModalLabel{{$fes->id}}" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="bronzeModalLabel{{$fes->id}}">Bronze Plan Selection</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form method="post" action="/payverify/{{$fes->fest_name}}" enctype="multipart/form-data">
          @csrf

          <div class="mb-3">
        <a href="#"><img class="img" src="{{asset($fes->qrcode)}}" alt="QR Code"></a>
    </div>
            <div class="mb-3">
              <label for="transactionId{{$fes->id}}" class="form-label">Transaction ID</label>
              <input type="text" class="form-control" name="TID" id="transactionId{{$fes->id}}" placeholder="Enter Transaction ID">
            </div>
            <div class="mb-3">
              <label for="imageUpload{{$fes->id}}" class="form-label">Transaction Screenshot</label>
              <input type="file" class="form-control" name="TIM"/>
            </div>
            <input type="hidden" name="planname" value="Bronze">
            <input type="hidden" name="name" value="{{session('name')}}">
            <input type="hidden" name="rollno" value="{{session('regno')}}">
            <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Register</button> 
          
        </div>
          </form>
        </div>
     
      </div>
    </div>
  </div>
        <div class="col-lg-4 col-md-12 mb-4">
          <div class="card card2 h-100">
            <div class="card-body">
             
              <h5 class="card-title">Silver</h5>
           
              <br><br>
              <span class="h2">₹{{$fes->pricesilver}}</span>
              <br><br>
              <div class="d-grid my-3">
              <button class="btn btn-outline-dark btn-block" data-bs-toggle="modal" data-bs-target="#silverModal{{$fes->id}}">Select</button>
              </div>
              <p><span><strong>PERKS:</strong></span></p>
              <p>INDIVIDUAL EVENTS:{!! $fes->siindlimit !!}</p>
              <p>GROUP EVENTS:{!! $fes->sigrplimit !!}</p>
            </div>

            
          </div>
       </div>

       <!-- Modal for Silver -->
<div class="modal fade" id="silverModal{{$fes->id}}" tabindex="-1" aria-labelledby="silverModalLabel{{$fes->id}}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="silverModalLabel{{$fes->id}}">Silver Plan Selection</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form  method="post" action="/payverify/{{$fes->fest_name}}" enctype="multipart/form-data">
                @csrf

                    <div class="mb-3">
                        <a href="#"><img class="img" src="{{asset($fes->qrcode)}}" alt="QR Code"></a>
                    </div>
                    <div class="mb-3">
                        <label for="transactionIdSilver{{$fes->id}}" class="form-label">Transaction ID</label>
                        <input type="text" class="form-control" name="TID" id="transactionIdSilver{{$fes->id}}" placeholder="Enter Transaction ID">
                    </div>
                    <div class="mb-3">
                        <label for="imageUploadSilver{{$fes->id}}" class="form-label">Transaction Screenshot</label>
                        <input type="file" class="form-control" name="TIM" />
                    </div>
                    <input type="hidden" name="planname" value="Silver">
                    <input type="hidden" name="name" value="{{session('name')}}">
            <input type="hidden" name="rollno" value="{{session('regno')}}">

                    <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Register</button> 
            </div>
                </form>
            </div>
         
        </div>
    </div>
</div>

<div class="col-lg-4 col-md-12 mb-4">
    <div class="card card3 h-100">
        <div class="card-body">
            <h5 class="card-title">Gold</h5>
            <br><br>
            <span class="h2">₹{{$fes->pricegold}}</span>
            <br><br>
            <div class="d-grid my-3">
                <button class="btn btn-outline-dark btn-block" data-bs-toggle="modal" data-bs-target="#goldModal{{$fes->id}}" type="button">Select</button>
            </div>
            <p><span><strong>PERKS:</strong></span></p>
            <p>INDIVIDUAL EVENTS: {!! $fes->goindlimit !!}</p>
            <p>GROUP EVENTS: {!! $fes->gogrplimit !!}</p>
        </div>
    </div>
</div>

<!-- Modal for Gold -->
<div class="modal fade" id="goldModal{{$fes->id}}" tabindex="-1" aria-labelledby="goldModalLabel{{$fes->id}}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="goldModalLabel{{$fes->id}}">Gold Plan Selection</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" action="/payverify/{{$fes->fest_name}}" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <a href="#"><img class="img" src="{{asset($fes->qrcode)}}" alt="QR Code"></a>
                    </div>
                    <div class="mb-3">
                        <label for="transactionIdGold{{$fes->id}}" class="form-label">Transaction ID</label>
                        <input type="text" class="form-control" name="TID" id="transactionIdGold{{$fes->id}}" placeholder="Enter Transaction ID">
                    </div>
                    <div class="mb-3">
                        <label for="imageUploadGold{{$fes->id}}" class="form-label">Transaction Screenshot</label>
                        <input type="file" class="form-control" name="TIM" />
                    </div>
                    <input type="hidden" name="planname" value="Gold">
                    <input type="hidden" name="name" value="{{session('name')}}">
                    <input type="hidden" name="rollno" value="{{session('regno')}}">
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Register</button> 
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

    @endforeach
  </body>


  <!-- Option 1: Bootstrap Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>


</body>
</html>