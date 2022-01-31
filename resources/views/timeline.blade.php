@extends("layout.profile")

@section("profile_content")
        <div id="page-contents" style="position: relative;">
        <div class="row">
          <div class="col-md-3"></div>
          <div class="col-md-6">

            <!-- Post Create Box
            ================================================= -->
            @auth
              @if(auth()->user()->id == $user->id)
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
                @else
                  <div style = "visibility: hidden; padding: 100px"></div>
                @endif

              @endauth
              @guest
                  <div style = "visibility: hidden; padding: 100px"></div>
              @endguest

            @if($posts !== null && $posts->count() > 0)
              @foreach($posts as $post)
                <!-- Post Content
                ================================================= -->
                <div class="post-content">

                    <!--Post Date-->
                    <div class="post-date hidden-xs hidden-sm">
                        <h5>{{ucwords($user->firstname)}}</h5>
                        <p class="text-muted">{{$post->created_at->diffForHumans()}}</p>
                    </div><!--Post Date End-->


                <div class="post-container">
                <img src="{{$post->user->image === null ? asset('/images/default_profile_image.png') : $post->user->image}}" alt="profile image" alt="user"class="profile-photo-md pull-left">
                <div class="post-detail">
                    <div class="user-info">
                        <div>
                            <h5 style = "display: flex"><a href="{{route('timeline', $post->user->id)}}" class="profile-link">{{ucwords($post->user->firstname ." ". $post->user->lastname)}}</a> 
                              @if($post->visibility == "public")
                                    <span style = "margin-left: 10px; margin-top: 1px; color: #2196f3;" class = "fa fa-globe"><small style = "margin-left: 2px;">Public</small></span>
                                @elseif($post->visibility == "me")
                                    <span style = "margin-left: 10px; margin-top: 1px; color: black;" class = "fa fa-lock"><small style = "margin-left: 2px;">Only Me</small></span>
                                @else
                                    <span style = "margin-left: 10px; margin-top: 1px; color: black;" class = "fa fa-group"><small style = "margin-left: 2px;">Friends</small></span>
                                @endif

                                
                                @auth
                                    @if(auth()->user()->id !== $post->user_id)
                                        <form action = "{{route('user.follow', $post->user_id)}}" method = "post">
                                            @csrf
                                            <button class = "button_rep following" style = "display: inline-block" type = "submit">{{($followers->where("follower_id", "=", auth()->user()->id)->count() > 0)? "following":"follow"}}</button>
                                        </form>                                    
                                    @endif
                                @endauth
                            </h5>
                        </div>
                    <p class="text-muted">{{$post->created_at->diffForHumans()}}</p>
                    </div>
                    
                    <div class="more">
                        <div class="dropdown">
                            <a href="#" data-toggle="dropdown"><span class = "glyphicon glyphicon-option-horizontal"></span></a>
                            <ul class="dropdown-menu">
                                 @auth
                                    @if(auth()->user()->id !== $post->user_id)
                                        <form action = "{{route('user.follow', $post->user_id)}}" method = "post">
                                            @csrf
                                            <li>
                                                <a>
                                                    <button class = "button_rep" style = "display: inline-block" type = "submit"> 
                                                        {{($followers->where("follower_id", "=", auth()->user()->id)->count() > 0)? "Unfollow":"Follow"}}
                                                    </button>
                                                </a>
                                            </li>
                                        </form>                                    
                                    @endif
                                @endauth
                              
                                @auth
                                    @if(auth()->user()->id === $post->user_id)
                                        <li>
                                            <form action = "{{route('post.delete', $post->id)}}" method = "post">
                                                @csrf
                                                {{method_field('DELETE')}}
                                                <button class = "button_rep" type = "submit">Delete Post</button>
                                            </form>
                                        </li>
                                    @else
                                      <li class = "message" data-id = "{{$post->user_id}}"><a>Message</a></li>
                                    @endif
                              
                                    
                                @endauth
                            </ul>
                        </div>
                    </div>
                    @if($post->image !== null && count(json_decode($post->image)) > 0)
                        <?php  
                            $class = ["one-media-grid","two-media-grid", "three-media-grid","four-media-grid","five-media-grid"];
                        ?>

                        <div class = "post-media-size-container">
                            <div class = "post-media-container {{(count(json_decode($post->image)) + count(json_decode($post->video)) > 5) ? $class[4] : $class[count(json_decode($post->image)) + count(json_decode($post->video)) - 1]}}">
                                <?php $counter = 0 ?>
                                @foreach(json_decode($post->image) as $image)
                                    <?php $counter++ ?>
                                    @if($counter <= 5)
                                        @if($counter == 5)
                                            <div class = "media{{$counter}} post-media" style = "position: relative">
                                                <img src="{{$image}}" alt="post-image" class="img-responsive post-image">
                                                @if(count(json_decode($post->image)) > 5)
                                                    <div class = 'post-media-remains'>+ {{count(json_decode($post->image)) + count(json_decode($post->video)) - 5}}</div>
                                                @endif
                                            </div>                                            
                                        @else
                                            <div class = "media{{$counter}} post-media">
                                                <img src="{{$image}}" alt="post-image" class="img-responsive post-image">
                                            </div>
                                        @endif
                                    @endif
                                @endforeach

                                @if($counter <= 5)
                                    @foreach(json_decode($post->video) as $video)
                                        <?php $counter++ ?>
                                        @if($counter <= 5)
                                            @if($counter == 5)
                                                <div class = "media{{$counter}} post-media" style = "position: relative">
                                                    <video muted = "muted" name="media" class = "img-responsive post-video">
                                                      <source src="{{$video}}" type="video/mp4">
                                                    </video>
                                                    @if(count(json_decode($post->image)) > 5)
                                                        <div class = 'post-media-remains'>+ {{count(json_decode($post->image)) - 5}}</div>
                                                    @endif
                                                </div>                                            
                                            @else
                                                <div class = "media{{$counter}} post-media">
                                                     <video muted = "muted"  name="media" class = "img-responsive post-video">
                                                      <source src="{{$video}}" type="video/mp4">
                                                    </video>
                                                </div>
                                            @endif
                                        @endif
                                    @endforeach
                                @endif

                            </div>
                        </div>
                    @endif
                    <div class="line-divider"></div>
                    <div class = "comment-container" style = "width: 100%; display: flex">
                        <div style = "width: 30%"></div>
                        <div style = "width:70%">
                            <div style = "float:right; cursor: pointer"><a class = "refresh-comment" data-post = "{{$post->id}}">Refresh Comments</a></div>
                            <div id = "comment_{{$post->id}}">
                                <?php $comments = $post->comments()->orderBy("created_at", "desc")->paginate(3)?>
                                @foreach($comments as $comment)
                                    <div class="post-comment">
                                        <div>
                                            <img src="{{$comment->user()->get()[0]->image === null ? asset('/images/default_profile_image.png') :$comment->user()->get()[0]->image}}" alt="" class="profile-photo-sm">
                                        </div>
                                        <p style = "position: relative;">
                                            <a href="{{route('timeline', $comment->user()->get()[0]->id)}}" class="profile-link">
                                                {{ucwords($comment->user()->get()[0]->firstname)}} 
                                            </a> 
                                            <span class = "message">{{$comment->comment}}</span>
                                            <span class = "comment-like-container">
                                                <i class="icon ion-thumbsup" data-post = "{{$post->id}}" data-comment = "{{$comment->id}}"></i>
                                                @if($comment->likes()->get()->count() > 0)
                                                <span>{{$comment->likes()->get()->count()}}</span>
                                                @endif
                                            </span>
                                        </p>
                                    </div>
                                @endforeach
                            </div>
                            <div style = "float:right; cursor: pointer"><a class = "view-more-comment" data-post = "{{$post->id}}" data-loaded = "{{$comments->count()}}">View More...</a></div>
                            @auth
                            <div class="post-comment">
                                <div>
                                    <img src="{{auth()->user()->image === null ? asset('/images/default_profile_image.png') : auth()->user()->image}}" alt="profile image" alt="user"class="profile-photo-sm">
                                </div>
                                    <input type="text" class="form-control post-comment-field" placeholder="Post a comment" data-post-id = "{{$post->id}}">
                            </div>
                            @endauth
                        </div>
                    </div>
                    <div class="reaction">
                        <form action = "{{route("post.likes", $post->id)}}" method = "post">
                            @csrf
                            <div>
                                <a class="btn text-green">
                                    <form action = "{{route('post.likes', $post->id)}}" method = "post">
                                        @csrf
                                        <button type = "submit" class = "button_rep"><i class="icon ion-thumbsup"></i></button>
                                    </form>
                                    
                                    @if($post->likes->count() > 0) <span>{{$post->likes->count()}}</span> @endif
                                </a>
                            </div>
                            @auth
                                @if(auth()->user()->likes()->where("post_id", "=", $post->id)->count() > 0)
                                    <div class = "text-green text-sm">You liked this {{auth()->user()->likes()->where("post_id", "=", $post->id)->get()[0]->updated_at->diffForHumans()}}</div>
                                @endif
                            @endauth
                        </form>
                    </div>
                </div>
                </div>
                {{$posts->links()}}
                </div>
              @endforeach
            @else
              <div class = "alert alert-warning">No post found.</div>
            @endif


          </div>
          <div class="col-md-3 static">
            <div id="sticky-sidebar" class="" style="">
              <h4 class="grey">{{ucwords($user->firstname)}}'s activity</h4>

              @if($activities->count() > 0)
              @foreach($activities as $activity)
              <div class="feed-item">
                <div class="live-activity" style = "line-height: 16px;">
                  <div><a href="#" class="profile-link">{{ucwords($activity->user()->get()[0]->firstname)}}</a> {{$activity->activity}}</div>
                  <small class="text-muted">{{$activity->created_at->diffForHumans()}}</small>
                </div>
              </div>
              @endforeach
              @else
                <div><strong>No activity found!.</strong></div>
              @endif
    

            </div>
          </div>
        </div>
      </div>
@endsection