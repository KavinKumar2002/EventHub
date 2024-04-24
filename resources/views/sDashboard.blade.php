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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script>
    setTimeout(function() {
        document.getElementById('notification').style.display = 'none';
    }, 2000); 
</script>
   <style>
   h3{
  text-align:left;
  margin:40px;
}
   body{
    margin-top:100px;
   }
   .blog-card-blog {
    margin-top: 30px;
}
.blog-card {
    display: inline-block;
    position: relative;
    width: 100%;
    margin-bottom: 30px;
    border-radius: 6px;
    color: rgba(0, 0, 0, 0.87);
    background: #fff;
    box-shadow: 0 2px 2px 0 rgba(0, 0, 0, 0.14), 0 3px 1px -2px rgba(0, 0, 0, 0.2), 0 1px 5px 0 rgba(0, 0, 0, 0.12);
}
.blog-card .blog-card-image {
    height: 60%;
    position: relative;
    overflow: hidden;
    margin-left: 15px;
    margin-right: 15px;
    margin-top: -30px;
    border-radius: 6px;
    box-shadow: 0 16px 38px -12px rgba(0, 0, 0, 0.56), 0 4px 25px 0px rgba(0, 0, 0, 0.12), 0 8px 10px -5px rgba(0, 0, 0, 0.2);
}
.blog-card .blog-card-image img {
    width: 100%;
    height: 100%;
    border-radius: 6px;
    pointer-events: none;
}
.blog-card .blog-table {
    padding: 15px 30px;
}
.blog-table {
    margin-bottom: 0px;
}
.blog-category {
    position: relative;
    line-height: 0;
    margin: 15px 0;
}
.blog-text-success {
    color: #28a745!important;
}
.blog-card-blog .blog-card-caption {
    margin-top: 5px;
}
.blog-card-caption {
    font-weight: 700;
    font-family: "Roboto Slab", "Times New Roman", serif;
}
.fa {
    display: inline-block;
    font: normal normal normal 14px/1 FontAwesome;
    font-size: inherit;
    text-rendering: auto;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
}
.blog-card-caption, .blog-card-caption a {
    color: #333;
    text-decoration: none;
}

p {
    color: #3C4857;
}

p {
    margin-top: 0;
    margin-bottom: 1rem;
}
.blog-card .ftr {
    margin-top: 15px;
}
.blog-card .ftr .author {
    color: #888;
}

.blog-card .ftr div {
    display: inline-block;
}
.blog-card .author .avatar {
    width: 36px;
    height: 36px;
    overflow: hidden;
    border-radius: 50%;
    margin-right: 5px;
}
.blog-card .ftr .stats {
    position: relative;
    top: 1px;
    font-size: 14px;
}
.blog-card .ftr .stats {
    float: right;
    line-height: 30px;
}

.blog-card-caption a.btn {
            display: block;
            width: 100%;
            margin-top: 20px; /* Adjust margin as needed */
            text-align: center;
            text-decoration: none;
            background-color: #007bff; /* Change to your preferred button color */
            color: #fff;
            padding: 10px 15px;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }

        .blog-card-caption a.btn:hover {
            background-color: #0056b3; /* Change to your preferred hover color */
        }
</style>

</head>
<body>
<div class="flex-container">
@include('stud')
    
    
       
        @if(session('success'))
    <div id="notification" style="width: auto; height:64px; background-color: #1cc88a; color: white; position: fixed; bottom: 10px; right: 10px; border-radius: 10px; padding: 15px; display: flex; align-items: center;">
        <div style="flex:top;">
            <img src="{{ asset('/img/success.gif') }}" alt=".gif" style="height: 50px; width: 50px;">
           
        </div> 
        <div class="ss" style="flex-bottom; text-size: 10px;padding-top:3px">
            <strong>
            {{session('success')}}
</strong>
        </div>
    </div>
    
    
    @endif
    

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Logout</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        
        
        
        <p>Are you sure to Logout</p>
       
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <a href="/Logout"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Yes</button></a>
      </div>
    </div>
  </div>
</div>
    
</div>   
<h3>Ongoing Fest</h3>

<div class="row">
            @foreach($events as $event)
            <div class="col-md-3">
                <div class="blog-card blog-card-blog">
                    <div class="blog-card-image">
                        <a href="#"><img class="img" src="{{ asset($event->image) }}"></a>
                        <div class="ripple-cont"></div>
                    </div>
                    <div class="blog-table">
                        <p class="blog-card-description">{!! $event->details !!}</p>
                        <div class="ftr">
                            <div class="author" style="text-decoration: none;">
                                <a href="#"><img src="https://icons.veryicon.com/png/o/miscellaneous/yuanql/icon-admin.png" alt="..." class="avatar img-raised"><span>Admin</span></a>
                            </div>
                            <div class="stats"><i class="far fa-clock"></i> From {{ $event->start }}</div>
                        </div>
                    </div>
                    <div class="blog-card-caption" style="text-align: center;">
                    <?php $userExists = false; ?>
@foreach($check as $ch)
    @if($ch->rollno == session('regno') && $ch->fest == $event->fest_name)
        @if($ch->status == "verified")
            <a href="/sfest/details/{{$event->fest_name}}/{{session('department')}}" class="btn btn-primary">View</a>
        @elseif($ch->status == "pending")
            <button class="btn btn-primary" type="button" disabled>
                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                Pending...
            </button>
        @endif
        <?php $userExists = true; ?>
        @break
    @endif
@endforeach

@if(!$userExists)
    <a href="/plans/{{$event->fest_name}}" class="btn btn-primary">Register Now</a>
@endif


                        
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    
    
  </div>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
