@extends("layout.index")

@section("content")

<div class="container">

    <!-- Timeline
    ================================================= -->
    <div class="timeline">
      <div class="timeline-cover">
        @if($user->count() > 0)
          <div class="timeline-cover-container">
            No cover image
            @if($user->cover_image !== null)
              <img src="{{asset('storage/images/cover/'.$user->cover_image)}}" alt="cover image" class = "cover-photo" />
            @endif
          </div>
          @if(auth()->user() !== null && auth()->user()->id == $user->id)
          <div class = "timeline-cover-option" data-toggle = "modal" data-target = "#profile-cover">
            <span class = "fa fa-camera"></span>
          </div>
          @endif
        @endif

        <!--Timeline Menu for Large Screens-->
        <div class="timeline-nav-bar hidden-sm hidden-xs">
          <div class="row">
            <div class="col-md-3">
              <div class="profile-info">
                @if($user->count() > 0)
                    <div style = "position: relative; display: inline-block">
                      @if(auth()->user() !== null && auth()->user()->id == $user->id)
                      <div class = "timeline-profile-option" data-toggle = "modal" data-target = "#profile-photo">
                        <span class = "fa fa-camera"></span>
                      </div>
                      @endif
                    
                      <img src="{{$user->image === null ? asset('/images/default_profile_image.png') : asset('storage/images/profile/'.$user->image)}}" alt="profile image" class="img-responsive profile-photo">
                    </div>
                    <h3>{{ucwords($user->firstname) ." ". ucwords($user->lastname)}}</h3>
                    @if($user->bio !== null)
                        <p class="text-muted bio-text">{{$user->bio}}</p>
                    @endif
                @endif
              </div>
            </div>
            <div class="col-md-9">
              <ul class="list-inline profile-menu">
                <li><a href="{{route('timeline', $id)}}" @if($page == "timeline") class="active" @endif>Timeline</a></li>
                <li><a href="{{route('about_user', $id)}}" @if($page == "about") class="active" @endif>About</a></li>
                @auth
                  @if($user->id == auth()->user()->id)
                    <li><a href="{{route('edit_profile', $id)}}" @if($page == "edit") class="active" @endif>Edit</a></li>
                  @endif
                @endauth
                <li><a href="{{route('profile_friends', $id)}}" @if($page == "friends") class="active" @endif>Friends</a></li>
                <li><a href="{{route('profile_followers', $id)}}" @if($page == "followers") class="active" @endif>Followers</a></li>
              </ul>
              <ul class="follow-me list-inline" style = "display: flex; align-items: center">
                <li>{{$followers->count()}} {{$followers->count() == 1? "follower": "followers"}}</li>
                @auth
                    @if(auth()->user()->id != $id)
                        <form action = "{{route('user.follow', $user->id)}}" method = "post">
                            @csrf
                            <li style = "list-style-image: none">
                                <a>
                                    <button class = "btn-primary" style = "display: inline-block" type = "submit"> 
                                        {{($followers->where("follower_id", "=", auth()->user()->id)->count() > 0)? "Unfollow":"Follow"}}
                                    </button>
                                </a>
                            </li>
                        </form>  
                        <form action = "{{route('user.add', $id)}}" method = "post">
                            @csrf
                            <li style = "list-style-image: none">
                                <a>
                                    <button class = "btn-primary" style = "display: inline-block" type = "submit"> 
                                        @if($friends->where("user_id", "=", auth()->user()->id)->where("friend_id", "=", $user->id)->where("status", "=", 1)->count() > 0)
                                          <span>Unfriend</span>
                                        @elseif($friends->where("user_id", "=", auth()->user()->id)->where("friend_id", "=", $user->id)->where("status", "=", 0)->count() > 0)
                                          <span>Cancel request</span>
                                        @else
                                          <span>Add friend</span>
                                        @endif
                                    </button>
                                </a>
                            </li>
                        </form> 
                    @endif
                @endauth
              </ul>
            </div>
          </div>
        </div><!--Timeline Menu for Large Screens End-->

        <!--Timeline Menu for Small Screens-->
        <div class="navbar-mobile hidden-lg hidden-md">
          <div class="profile-info" style = "position: relative;">
            <div style = "position: relative; display : inline-block">
              @if(auth()->user() !== null && auth()->user()->id == $user->id)
              <div class = "timeline-profile-mobile-option" data-toggle = "modal" data-target = "#profile-photo">
                <span class = "fa fa-camera"></span>
              </div>
              @endif
             <img src="{{$user->image === null ? asset('/images/default_profile_image.png') : asset('storage/images/profile/'.$user->image)}}" alt="profile image" alt="user" class="img-responsive profile-photo">
            </div>
            <h4 style = "background:white; padding-top: 15px;">{{ucwords($user->firstname) ." ". ucwords($user->lastname)}}</h4>
            <p class="text-muted bio-text">{{$user->bio}}</p>
          </div>
          <div class="mobile-menu">
            <ul class="list-inline">
              <li><a href="{{route('timeline', $id)}}" @if($page == "timeline") class="active" @endif>Timeline</a></li>
                <li><a href="{{route('about_user', $id)}}" @if($page == "about") class="active" @endif>About</a></li>
                @auth
                  @if($user->id == auth()->user()->id)
                    <li><a href="{{route('edit_profile', $id)}}" @if($page == "edit") class="active" @endif>Edit</a></li>
                  @endif
                @endauth
                <li><a href="{{route('profile_friends',$id)}}" @if($page == "friends") class="active" @endif>Friends</a></li>
            </ul>
            @auth
                @if(auth()->user()->id != $id)
                  <form action = "{{route('user.follow', $user->id)}}" method = "post">
                    @csrf
                    <li style = "list-style-type: none">
                        <a>
                            <button class = "btn-primary" style = "display: inline-block" type = "submit"> 
                                {{($followers->where("follower_id", "=", auth()->user()->id)->count() > 0)? "Unfollow":"Follow"}}
                            </button>
                        </a>
                    </li>
                  </form>  
                  <form action = "{{route('user.add', $id)}}" method = "post">
                            @csrf
                            <li style = "list-style-type: none; margin-top: 10px">
                                <a>
                                    <button class = "btn-primary" style = "display: inline-block" type = "submit"> 
                                        @if($friends->where("user_id", "=", auth()->user()->id)->where("friend_id", "=", $user->id)->where("status", "=", 1)->count() > 0)
                                          <span>Unfriend</span>
                                        @elseif($friends->where("user_id", "=", auth()->user()->id)->where("friend_id", "=", $user->id)->where("status", "=", 0)->count() > 0)
                                          <span>Cancel request</span>
                                        @else
                                            <span>{{$friends->where("user_id", "=", 1)->where("friend_id", "=", 2)->where("status", "=", 0)->count()}}</span>
                                          <span>Add friend</span>
                                        @endif
                                    </button>
                                </a>
                            </li>
                        </form> 
                @endif
            @endauth

          </div>
        </div><!--Timeline Menu for Small Screens End-->

      </div>

      @yield("profile_content")

    </div>
  </div>

  <!-- Profile photo modals -->

  <div>
    <div class="modal" tabindex="-1" id = "profile-photo" style = "padding-right: unset !important">
      <div class="modal-content">
        <div class="modal-body" style = "padding: 0px; margin: 0px;">
          <ul class = "list-group" style = "padding: 0px; margin: 0px;">
            <li class = "list-group-item view-profile-image">View Profile Image</li>
            <label  for = "profile-photo-input-1" style = "width: 100%">
              <li class = "list-group-item upload">
                Upload Profile Image
              </li>
            </label>
            <input type = "file" accept = "image/*" class = "upload-field-profile hidden" id = "profile-photo-input-1"/>
          </ul>
        </div>
      </div>
    </div>
    

    <div class="modal" tabindex="-1" id = "profile-cover" style = "padding-right: unset !important">
      <div class="modal-content">
        <div class="modal-body" style = "padding: 0px; margin: 0px;">
          <ul class = "list-group" style = "padding: 0px; margin: 0px;">
            <li class = "list-group-item view-cover-image">View Cover Image</li>
            <label  for = "profile-photo-input-2" style = "width: 100%">
              <li class = "list-group-item upload">
                Upload Cover Image
              </li>
            </label>
              <input type = "file" accept = "image/*" class = "upload-field-cover hidden" id = "profile-photo-input-2"/>
          </ul>
        </div>
      </div>
    </div>


    <div class = "profile-image-preview">
      <span>&times;</span>
      <img src = "" >
    </div>


  </div>

@endsection