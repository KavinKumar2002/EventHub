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
                <div class="card-body">

                    <div class="table-responsive table mt-2" id="dataTable-1" role="grid"
                        aria-describedby="dataTable_info">
                        <table class="table my-0 " id="dataTable">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Rollno</th>
                                    <th>Package</th>
                                    <th>Transactionid</th>
                                    <th>Screenshot</th>
                                    <th>Fest</th>
                                    <th>Status</th>
                                    <th>Verification</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($verificationData as $fes)
                                @if($fes->fest === $fest)
                                <tr>
                                    <td>{{$fes->username}}</td>
                                    <td>{{$fes->rollno}}</td>
                                    <td>{{$fes->package}}</td>
                                    <td>{{$fes->transactionid}}</td>
                                    <td><button data-bs-toggle="modal" data-bs-target="#exampleModal1"
                                            class="btn btn-block btn-bold btn-primary justify-content-center"
                                            style="margin-right:20px">View</button></td>
                                    <td>{{$fes->fest}}</td>
                                    <td>{{$fes->status}}</td>
                                    @if($fes->status == "pending")
                                    <td><form method="post" action="/verifyupdate/{{$fes->fest}}/{{$fes->rollno}}/{{$fes->package}}">
                                        @csrf
                                        <button type="submit"
                                            class="btn btn-block btn-bold btn-primary justify-content-center"
                                            style="margin-right:20px">Verify</button></td>
                                    @else
                                    <td><button 
                                            class="btn btn-block btn-bold btn-primary justify-content-center"
                                            style="margin-right:20px" disabled>Verified</button></td>
                                    @endif
                                </tr>

                                <!-- Modal -->
                                <div class="modal fade" id="exampleModal1" tabindex="-1"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="exampleModalLabel">Payment Screenshot</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
    <!-- Display the image -->
    <img src="{{ asset($fes->screenshot) }}" alt="Payment Screenshot" class="img-fluid">
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
   
</body>

</html>
