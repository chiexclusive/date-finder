@extends("layout.index")

@section("content")
    <div id="page-contents">
    	<div class="container">
    		<div class="row">

          <!-- Newsfeed Common Side Bar Left
          ================================================= -->
    			<div class="col-md-3 static" style = "padding-top: 60px;">
            @auth
            <div class="profile-card">
                <img src="{{auth()->user()->image === null ? asset('/images/default_profile_image.png') : auth()->user()->image}}" alt="profile image" alt="user" class="profile-photo">
                <h5><a href="{{route('timeline', auth()->user()->id)}}" class="text-white">{{ucwords(auth()->user()->firstname) ." ". ucwords(auth()->user()->lastname)}}</a></h5>
                <a href="#" class="text-white"><i class="ion ion-android-person-add"></i> {{$followers->where("user_id", "=", auth()->user()->id)->count() == 1 ? $followers->where("user_id", "=", auth()->user()->id)->count() . " follower" : $followers->where("user_id", "=", auth()->user()->id)->count() . " followers"}}</a>
            </div><!--profile card ends-->
            @endauth
            <ul class="nav-news-feed">
              <li><i class="icon ion-ios-paper"></i><div><a href="/dashboard/newsfeed">Newsfeed</a></div></li>
              <!-- <li><i class="icon ion-ios-people"></i><div><a href="newsfeed-people-nearby.html">People Nearby</a></div></li> -->
              @auth
                <li><i class="icon ion-ios-people-outline"></i><div><a href="{{route('friends')}}">Friends</a></div></li>
                <li><i class="icon ion-chatboxes"></i><div><a class = "toggle-messages">Messages</a></div></li>
              @endauth

            </ul><!--news-feed links ends-->
            <div id="chat-block">
              @guest
                <a href = "{{route("login_page")}}"><div class="title">Login</div></a>
                <a href = "{{route("register_page")}}"><div class="title">Register</div></a>
              @endguest
              
              @auth
                <div class="suggestions" style = "text-align: left">
                  <h4 class="grey">Friend Request</h4>

                  @if($friend_request !== null && $friend_request->count() > 0)
                    @foreach($friend_request as $friend)
                      <div class="follow-user">
                        <img src="{{$friend->user()->get()[0]->image === null ? asset('/images/default_profile_image.png') : $friend->user()->get()[0]->image}}" alt="" class="profile-photo-sm pull-left">
                        <div style = "text-align: left">
                          <h5><a href="timeline.html">{{ucwords($friend->user()->get()[0]->firstname) . " ". ucwords($friend->user()->get()[0]->lastname)}}</a></h5>
                          <a href = "{{route('user.accept', $friend->user()->get()[0]->id)}}"><button class = "btn btn-success" href="#" class="text-green">Accept</button></a>
                          <a href = "{{route('user.reject', $friend->user()->get()[0]->id)}}"><button class = "btn btn-danger" href="#" class="text-green">Cancel</button></a>
                        </div>
                      </div>
                    @endforeach
                  @else
                    <span><strong>No pending Request</strong></span>
                  @endif
                </div>
              @endauth
            </div><!--chat block ends-->
          </div>
          
    			<div class="col-md-7" style = "padding-top: 50px;">
            @auth
              <div class="create-post">
                <div class="row">
                    <div class="col-12 pl-3 pr-3">
                      <div class="form-group w-100 create-post-toggle-container">
                        <img src="{{auth()->user()->image === null ? asset('/images/default_profile_image.png') : auth()->user()->image}}" alt="profile image" alt="user" class="profile-photo-sm">
                        <div class = "create-post-toggle" data-toggle = "modal" data-target="#createPostModal">What's on your mind?</div>
                      </div>
                    </div>
                  </form>
                </div>
              </div>

              <!-- Create post modal -->
              <div class="modal" tabindex="-1" id = "createPostModal">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header d-flex justify-between">
                      <span class ="fa fa-arrow-left hidden-sm" data-dismiss = "modal"></span>
                      <h5 class="modal-title">Create a Post</h5>
                      <span class = "close fa fa-close" data-dismiss = "modal"></span>
                    </div>
                    <div class="modal-body">
                      @auth
                      <div class = "create-post-head-content">
                        <img src="{{auth()->user()->image === null ? asset('/images/default_profile_image.png') : auth()->user()->image}}" alt="profile image" alt="user"class="profile-photo-sm">
                        <div style = "padding-left: 10px">
                          <div>{{ucwords(auth()->user()->firstname ." ". auth()->user()->lastname)}}</div>
                          <div class = "privacy-box" data-toggle = "modal" data-target="#modifyPrivacySettings">
                            <span class = "fa fa-group"></span>
                            <span class = "">Friends</span>
                            <span class = "fa fa-arrow-right"></span>
                          </div>
                        </div>
                      </div>
                      <div class = "p-3 post-text-field-container">
                        <textarea class = "post-text-field" placeholder="What's on your mind..."></textarea>
                      </div>
                       <div class="create-post-log">
                
                       </div>
                      <div class = "image-preview-header d-none">
                        <p><strong>Images</strong></p>
                        <hr style = "margin: 0"/>
                      </div>
                      <div class = "media-preview-container image-preview-container">
                          
                      </div>
                      <div class = "video-preview-header d-none">
                        <p><strong>Videos</strong></p>
                        <hr style = "margin: 0"/>
                      </div>
                      <div class = "media-preview-container video-preview-container">
                          
                      </div>
                      <div class="tools">
                        <ul class="publishing-tools list-inline">
                          <li>
                            <label for = "create-post-image-field" class = "text-success"><i class="ion-images"></i></label>
                            <input id = "create-post-image-field" name = "create-post-image-field[]" type = "file"  accept = "image/jpg, image/jpeg, image/png, image/*" multiple style = "display: none"/>
                          </li>
                          <li>
                            <label for = "create-post-video-field" class = "text-success"><i class="ion-ios-videocam"></i></label>
                            <input id = "create-post-video-field" name = "create-post-video-field[]" type = "file"  accept = "video/*" multiple style = "display: none"/>
                        </ul>
                      </div>
                      @endauth
                    </div>
                    @csrf
                    <div class="modal-footer">
                      <button class="publish btn btn-primary pull-right" disabled = "true">Publish</button>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Modify Post Privacy Settings -->
              <div class="modal" tabindex="-1" id = "modifyPrivacySettings">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header d-flex justify-between">
                      <span class ="fa fa-arrow-left hidden-sm" data-dismiss = "modal"></span>
                      <h5 class="modal-title">Post Visibility</h5>
                      <span class = "close fa fa-close" data-dismiss = "modal"></span>
                    </div>
                    <div class="modal-body">
                      <h4>Who can see your posts.</h4>
                      <p>Your post will show up in  New Feed, your Profile and in search result</p>
                      <br/>
                      <div style = "display: flex">
                        <span><input type = "radio" name = "post-visibility" value = "public"></span>
                        <span class = "fa fa-globe pl-3"></span>
                        <span class = "pl-3" style = "line-height: 15px;">
                          <div><strong>Public</strong></div>
                          <div class = "small-ref-text">Anyone one can view</div>
                        </span>
                      </div>
                      <hr />
                      <div style = "display: flex">
                        <span><input type = "radio" name = "post-visibility" checked = "" value = "friends"></span>
                        <span class = "fa fa-group pl-3"></span>
                        <span class = "pl-3" style = "line-height: 15px;">
                          <div><strong>Friends</strong></div>
                          <div class = "small-ref-text">Your friends on Date Finder</div>
                        </span>
                      </div>
                      <hr />
                      <div style = "display: flex">
                        <span><input type = "radio" name = "post-visibility" value = "me"></span>
                        <span class = "fa fa-lock pl-3"></span>
                        <span class = "pl-3" style = "line-height: 15px;">
                          <div><strong>Only Me</strong></div>
                          <div class = "small-ref-text">Only Me</div>
                        </span>
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-primary post-isibility-save" data-dismiss = "modal">Save Changes</button>
                    </div>
                  </div>
                </div>
              </div>

              
            @endauth

            @yield("dashboard_content")

          </div>
          <!-- Newsfeed Common Side Bar Right
          ================================================= -->
          <div class="col-md-2 static" style = "padding-top: 50px;">
            <div class="suggestions" id="sticky-sidebar">
              <h4 class="grey">Suggested Friends</h4>

              @if(count($suggestions) > 0)
                @foreach($suggestions as $suggestion)
                  <div class="follow-user">
                    <img src="{{$suggestion->image === null ? asset('/images/default_profile_image.png') : $suggestion->image}}" alt="profile image" alt="user"class="profile-photo-sm pull-left">
                    <div>
                      <h5><a href="{{route('timeline', $suggestion->id)}}">{{ucwords($suggestion->firstname." ".$suggestion->lastname)}}</a></h5>
                       <form action = "{{route('user.add', $suggestion->id)}}" method = "post">
                            @csrf
                                <a>
                                    <button class = "btn btn-success" style = "display: inline-block" type = "submit"> 
                                          <span>Add friend</span>
                                    </button>
                                </a>
                            </li>
                        </form> 
                    </div>
                  </div>
                @endforeach
              @else
                <div><strong>No suggestions found!.</strong></div>
              @endif
              
            </div>
          </div>
        </div>
      </div>
    </div>
@endsection