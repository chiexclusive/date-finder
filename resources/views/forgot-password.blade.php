<!DOCTYPE html>
<html lang="en">


<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="A social network platform for finding potential connections over the internet for the aim of developing personal, romantic and, or sexual relationship">
    <meta name="keywords" content="Social Network, Social Media, Make Friends, Dating site, Online dating, relationship, love, friendship">
    <meta name="robots" content="index, follow">
    <title>{{$title}}</title>

    <!-- Stylesheets
    ================================================= -->
    <link rel="stylesheet" href="{{URL::asset('css/bootstrap.min.css');}}">
    <link rel="stylesheet" href="{{URL::asset('css/jquery.scrollbar.css');}}">
    <link rel="stylesheet" href="{{asset('css/style.css');}}">
    <link rel="stylesheet" href="{{asset('css/ionicons.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/emojione.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/emojionearea.min.css')}}">

    <!--Google Font-->
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,400i,700,700i" rel="stylesheet">

    <!--Favicon-->
    <link rel="shortcut icon" type="image/png" href="images/fav.png">
</head>

  <!-- Change Password
  ================================================= -->
  <div class = "container forgot-password-container">
  <div class="forgot-password-section">

    <a href = "{{route('home')}}">
      <div class="col-12 logo-container">
          <img src = "/images/logo.png"/>
          <span>Date Finder</span>
      </div>
    </a>




    <div class="block-title">
      <h4 class="grey"><i class="icon ion-ios-locked-outline"></i>  Change Password</h4>
      <div class="line"></div>
      <p>Sorry for the inconvenience. Lets see if we can reset your password. </p>
      <div class="line"></div>
    </div>
    <div class="edit-block">
      <form name="update-pass" id="education" class="form-inline" action = "{{route('password.email')}}" method = "post" >
        @csrf
        <div class="row">
          <div class="form-group col-xs-6">
            <label>Email</label>
            <input class="form-control input-group-lg" @error("email") style = "border-color: red" @enderror type="email" name="email" title="Enter email" placeholder="Email...">
          </div>
        </div>
        <button class="btn btn-primary" type = "submit">Reset Password</button>
      </form>
      @if(session("emailError"))
      <div class = "alert alert-danger" style = "margin-top: 20px;">{{session("emailError")}}</div>
      @endif
      @if(session("status"))
      <div class = "alert alert-success" style = "margin-top: 20px;">{{session("status")}}</div>
      @endif
      
    </div>
  </div>


  <ul class="list-inline social-icons">
    <li><a href="#"><i class="icon ion-social-facebook"></i></a></li>
    <li><a href="#"><i class="icon ion-social-twitter"></i></a></li>
    <li><a href="#"><i class="icon ion-social-googleplus"></i></a></li>
    <li><a href="#"><i class="icon ion-social-pinterest"></i></a></li>
    <li><a href="#"><i class="icon ion-social-linkedin"></i></a></li>
  </ul>

   <div class="copyright" style = "padding-top: 20px; color: black; background: unset">
      <p>copyright @xclusiv-team 2021. All rights reserved</p>
    </div>



</div>







</html>