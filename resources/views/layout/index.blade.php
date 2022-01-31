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
    <link rel="shortcut icon" type="image/png" href="/images/fav.png">

    <script>
      
      window.diffForHumans = (time) => {
        //Clean up time
        time = time.toLowerCase().replace("z", "");
        let timeDiff = (Date.now()/1000) - (Date.parse(time)/1000);

        if(timeDiff < 60){
          return parseInt(timeDiff) == 1 ? parseInt(timeDiff) + " second ago": parseInt(timeDiff) + " seconds ago";
        }else if(timeDiff >= 60 && timeDiff < 59 * 60){
          return parseInt(timeDiff/60) == 1 ? parseInt(timeDiff/60) + " min ago" : parseInt((timeDiff/60)) + " mins ago";
        }else if(timeDiff >= (60*60) && timeDiff < (24 * 60 * 60)){
          return parseInt(timeDiff/(60*60)) == 1 ? parseInt(timeDiff/(60*60)) + "hr ago" :parseInt(timeDiff/(60*60)) + "hrs ago";
        }else if(timeDiff >= (60*60*24) && timeDiff < (24 * 60 * 60 * 7)){
          return parseInt(timeDiff/(60*60*24)) == 1 ? parseInt(timeDiff/(60*60*24)) + "day ago" : parseInt(timeDiff/(60*60*24)) + "days ago";
        }else if(timeDiff >= (60*60*24*7) && timeDiff < (24 * 60 * 60 * 7*4)){
          return parseInt(timeDiff/(60*60*24*7)) == 1 ? parseInt(timeDiff/(60*60*24*7)) + "week ago" : parseInt(timeDiff/(60*60*24*7)) + "weeks ago";
        }else if(timeDiff >= (60*60*24*7*4) && timeDiff < (24 * 60 * 60 * 7*4*12)){
          return parseInt(timeDiff/(60*60*24*7*4)) == 1 ? parseInt(timeDiff/(60*60*24*7*4)) + "month ago" :  parseInt(timeDiff/(60*60*24*7*4)) + "months ago";
        }else if(timeDiff >= (60*60*24*7*4*12)){
          return parseInt(timeDiff/(60*60*24*7*4*12)) == 1 ? parseInt(timeDiff/(60*60*24*7*4*12)) + "yr ago" : parseInt(timeDiff/(60*60*24*7*4*12)) + "yrs ago";
        }
        return "working...";
      }


      window.ucwords = (sentence) => {
        let words = sentence.split(" ");
        let result = "";

        words.forEach((item, index) => {
          result += item.charAt(0).toUpperCase() + item.substr(1) + " ";
        })

        return result;
      }
    </script>
</head>





<body>

  @auth
  <!-- User id -->
  <span class = "auth hidden">{{auth()->user()->id}}</span>
  
  @endauth

  @csrf

  <!-- Header
  ================================================= -->
  <header id="header-inverse">
    <nav class="navbar navbar-default navbar-fixed-top menu">
      <div class="container">

        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
           <a href = "{{route('home')}}" class = "header-logo">
              <div class="col-12 logo-container">
                  <img src = "/images/logo.png"/>
                  <span>Date Finder</span>
              </div>
            </a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
          <ul class="nav navbar-nav navbar-right main-menu">
            <li class="dropdown">
              <a href="{{route('home')}}" role="button">Home </a>
            </li>
            <li class="dropdown"><a href="#contacts">Contact</a></li>
            @auth
              <li class="dropdown">
                <a href= "#" class="dropdown-toggle pages" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                  <span class="profile-image-container">
                    <img src="{{auth()->user()->image === null ? asset('/images/default_profile_image.png') : auth()->user()->image}}" alt="profile image" class="profile-image">
                  </span>
                </a>
                <ul class="dropdown-menu logout">
                  <a href = "{{route('timeline', auth()->user()->id)}}"><strong>{{ucwords(auth()->user()->firstname) ." ". ucwords(auth()->user()->lastname)}}</strong></a>
                  <div>
                    <small>{{auth()->user()->email}}</small>
                  </div>
                  <form action = "{{route("logout")}}" method = "post">
                    @csrf
                    <button class = "btn btn-primary" type = "submit">
                        Log Out
                    </button>
                  </form>
                </ul>
                
              </li>
            @endauth
          </ul>
          <form class="navbar-form navbar-right hidden-sm">
            <div class="form-group">
              <i class="icon ion-android-search"></i>
              <input type="text" class="form-control" placeholder="Search friends, photos, videos">
            </div>
          </form>
        </div><!-- /.navbar-collapse -->
      </div><!-- /.container -->
    </nav>
  </header>
  <!--Header End-->

  {{-- Inject content into this layout --}}
  @yield('content')

  @if($type !== "home")

  @auth
    <section class = "chat">





      <input type = "text" value = "{{auth()->user()->id}}" class =  "hidden _chat-user-id-field"/>
      <section class = "chat-content-section">
        <section class = "chat-room">
          <div class="col-12">
            <header class = "chat-section-header">
              <div style = "display: flex; align-items: center;">
                <span class = "fa fa-arrow-left close" style = "margin-right: 10px"></span>
                <img src="" alt="user" class="profile-photo-sm end-user-image">
              </div>
              <div>
                <span class = "end-user-name"></span>
                <span class = "dropdown">
                  <span class = "fa fa-ellipsis-v dropdown-toggle" style = "cursor: pointer" data-toggle = "dropdown"></span>
                  <ul class="dropdown-menu" style = "margin-left: -150px">  
                    <li><a class = "refresh">Refresh</a></li>
                  </ul>
                </span>
              </div>
            </header>

            <!--Chat Messages in Right-->
            <div class="scroll-wrapper tab-content scrollbar-wrapper wrapper scrollbar-outer" style="position: relative;">
              
                      
                      
                <div class="tab-pane" id="contact-5">
                  <div class="chat-body">
                    <ul class="chat-message">
                     
                    </ul>
                  </div>
                </div>
                
              </div>
              <div  class="scroll-element scroll-x scroll-scrolly_visible">
                <div class="scroll-element_outer">
                  <div class="scroll-element_size"></div>
                  <div class="scroll-element_track"></div>
                  <div class="scroll-bar" style="width: 86px;"></div>
                </div>
              </div>


          <div class="send-message-container">
            <div class="send-message-group">
              <textarea class="form-control send-message-field" placeholder="Type your message"></textarea>
              <button class="btn btn-default send-message" type="button"><span class = "fa fa-paper-plane"></span></button>
            </div>
          </div>
        </div>
      </section>
    </section>














    <!-- Chat list section -->
    <secion class = "chat-section">

      <header class = "chat-section-header">
        <div style = "display: flex; align-items: center">
          <span class = "fa fa-arrow-left mobile-chat-toggle display" style = "cursor: pointer"></span>

          <img src="{{auth()->user()->image === null ? asset('/images/default_profile_image.png') : auth()->user()->image}}" alt="profile image" alt="user" class="profile-photo-sm">
        </div>
        <div>
          <span>Messages</span>
          <div style = "display: flex; align-items: center">
            <span class = "fa fa-refresh refresh"></span>
            <div class = "toggle-chevron" style = "margin-left: 20px;">
              <span class = "fa fa-chevron-down"></span>
            </div>
          </div>
        </div>
      </header>
      <div class = "chat-section-body" style = "display: none">
      <section class = "chat-search-section">
        <span class = "fa fa-search"></span>
        <input placeholder = 'Search chats by name...' style = "border-color: grey" class = "search-chats form-control"/>
      </section>
      <section class = "chat-list-section chat-room">
        
        <div class="col-12">

          <!-- Contact List in Left-->
            <div class="scroll-wrapper nav nav-tabs contact-list scrollbar-wrapper scrollbar-outer" style="position: relative;">
              <ul class="nav nav-tabs contact-list scrollbar-wrapper scrollbar-outer scroll-content scroll-scrolly_visible" style="height: auto; margin-bottom: 0px; margin-right: 0px; max-height: 400px;">
                <div style = "text-align: center; padding-top: 10px;">Loading...</div>
              </ul>
            </div>
          </section>
        </div>
      </secion>
    </section>
    <div class = "mobile-message-toggler appear"><span class = "fa fa-envelope"></span></div>
  @endauth
  @endif














  <!--preloader-->
  <div id="spinner-wrapper">
    <div class="spinner"></div>
  </div>

  

  <footer id="footer">
      <div class="container">
      	<div class="row">
          <div class="footer-wrapper">
            <div class="col-md-3 col-sm-3">
              <a href=""><img src="/images/logo.png" alt="" class="footer-logo"> Date Finder</a>
              <ul class="list-inline social-icons">
              	<li><a href="#"><i class="icon ion-social-facebook"></i></a></li>
              	<li><a href="#"><i class="icon ion-social-twitter"></i></a></li>
              	<li><a href="#"><i class="icon ion-social-googleplus"></i></a></li>
              	<li><a href="#"><i class="icon ion-social-pinterest"></i></a></li>
              	<li><a href="#"><i class="icon ion-social-linkedin"></i></a></li>
              </ul>
            </div>
            <div class="col-md-2 col-sm-2">
              <h6>For individuals</h6>
              <ul class="footer-links">
                <li><a href="{{route('register_page')}}">Signup</a></li>
                <li><a href="{{route('login_page')}}">login</a></li>
                <li><a href="">Explore</a></li>
                <li><a href="">Features</a></li>
              </ul>
            </div>
            <div class="col-md-2 col-sm-2">
              <h6>For businesses</h6>
              <ul class="footer-links">
                <li><a href="">Benefits</a></li>
                <li><a href="">Resources</a></li>
                <li><a href="">Advertise</a></li>
              </ul>
            </div>
            <div class="col-md-2 col-sm-2">
              <h6>About</h6>
              <ul class="footer-links">
                <li><a href="#contacts">Contact us</a></li>
                <li><a href="">Privacy Policy</a></li>
                <li><a href="">Terms</a></li>
                <li><a href="">Help</a></li>
              </ul>
            </div>
            <div class="col-md-3 col-sm-3" id = "contacts">
              <h6>Contact Us</h6>
                <ul class="contact">
                	<li><i class="icon ion-ios-telephone-outline"></i>+234 (903) 559 2586</li>
                	<li><i class="icon ion-ios-email-outline"></i>datefinder.web@gmail.com</li>
                </ul>
            </div>
          </div>
      	</div>
      </div>
      <div class="copyright">
        <p>copyright @xclusiv-team 2021. All rights reserved</p>
      </div>
		</footer>

    <div class = "preview-medias-container" style = "overflow-y: auto; padding-top: 30px; padding-bottom: 30px">
      <span class = "close">&times;</span>
      <div class = "content-container container">
  
      </div>
    </div>


  <!-- Scripts
  ================================================= -->
  <script src="{{asset('js/jquery-3.1.1.min.js')}}"></script>
  <script src="{{asset('js/bootstrap.min.js')}}"></script>
  <script src="{{asset('js/jquery.appear.min.js')}}"></script>
  <!-- <script src="{{asset('js/jquery.visible.min.js')}}"></script> -->
  <script src="{{asset('js/jquery.visible.js')}}"></script>

  @if($type === "home")
    <script  src="{{asset('js/jquery.incremental-counter.js')}}"></script>
  @else
    <!-- Coded scripts -->
    <script  src="{{asset('js/emojione.min.js')}}"></script>
    <script  src="{{asset('js/emojionearea.min.js')}}"></script>
    <script  src="{{asset('js/create-post.js')}}"></script>
    <script  src="{{asset('js/post-visibility.js')}}"></script>
    <script  src="{{asset('js/autoPlayVideo.js')}}"></script>
    <script  src="{{asset('js/emojiController.js')}}"></script>
    <script  src="{{asset('js/profilePhotos.js')}}"></script>
    <script  src="{{asset('js/chat.js')}}"></script>
    <script  src="{{asset('js/post-comment.js')}}"></script>
    <script  src="{{asset('js/previewMedia.js')}}"></script>
    <script>
      
      //Convert all EMoji short name to images
      jQuery(document).ready(() => {
        jQuery('.post-text').each(function () {
          var converted = emojione.toImage(jQuery(this).html())
          jQuery(this).html(converted)
        })
      })
    </script>
    <script  src="{{asset('js/jquery.sticky-kit.min.js')}}"></script>

  @endif
  
  <script  src="{{asset('js/script.js')}}"></script>



</body>
</html>
