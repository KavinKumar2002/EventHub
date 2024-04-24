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
    <script src="/bootstrap/bootstrap/js/bootstrap.min.js"></script>
    <script src="/bootstrap/js/bs-init.js"></script>
    <script src="/bootstrap/js/theme.js"></script>
    <style>.flex-container {
  display: flex;
}

#sidebar {
  flex: 1;
}

#page-content {
  flex: 2;
}
</style>
</head>
<body>
    @include('sidebar')
    <div class="container-fluid">

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800 " style="margin-top:60px !important;text-weight:bold !important">Ongoing Festival</h1>
</div>

<div class="container mt-5 mb-5">
    <div class="d-flex justify-content-center"> <!-- Centering the content horizontally -->
        <div class="col-md-10">
            @if($fest)
            @foreach($fest as $fes)
            <div class="row p-2 bg-white border rounded mt-2">
                <div class="col-md-3 mt-1"><img class="img-fluid img-responsive rounded product-image" src="{{ asset($fes->image) }}"></div>
                <div class="col-md-6 mt-1">
                    <h3>{{$fes->fest_name}}</h3>
                    <div class="mt-1 mb-1 spec-1 w-50 justify-content"><span>{!! $fes->details !!}</span></div>
                </div>
                <div class="align-items-center align-content-center col-md-3 border-left mt-1">
                    <div class="d-flex flex-row align-items-center">
                        <span class="strike-text">From {{$fes->start}} To {{$fes->end}}</span>
                    </div>
                    <div class="d-flex flex-column mt-4" ><a href="/View/{{$fes->fest_name}}"><button class="btn btn-primary btn-sm" type="button">Details</button></a></div>
                    <div class="d-flex flex-column mt-4" ><a href="/verify/{{$fes->fest_name}}"><button class="btn btn-primary btn-sm" type="button">Payment Verification</button></a></div>
                </div>
            </div>
            @endforeach
            @else
            <p>No fest Available</p>
            @endif
        </div>
    </div>
</div>
</div>



</body>
</html>
