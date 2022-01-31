@extends("layout.profile")

@section("profile_content")
  @if($user->count() > 0)
        <div id="page-contents">
          <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">

              <!-- Friend List
              ================================================= -->
              <div class="friend-list">
                <div class="row">


                  @if($followers->count() > 0)
                    @foreach($followers as $follower)
                        <?php 
                          $follower = $userDB->where("id", "=", $follower->follower_id)->get()[0]; 
                        ?>
                    <div class="col-md-6 col-sm-6">
                      <div class="friend-card">
                        @if($follower->cover_image !== null)
                          <img src="{{$follower->cover_image}}" alt="cover image" class = "img-responsive cover" />
                         @else
                          <div class="img-responsive cover no-cover">No Cover Image</div>
                         @endif
                        <div class="card-info">
                           <img src="{{$follower->image === null ? asset('/images/default_profile_image.png') : $follower->image}}" alt="profile image" alt="user" class="profile-photo-lg">
       
                          <div class="friend-info">
                            
                            <h5><a href="{{route('timeline', $follower->id)}}" class="profile-link">{{ucwords($follower->firstname) ." ". ucwords($follower->lastname)}}</a></h5>
                            <p class = "bio-text">{{$follower->bio}}</p>
                            <button class = "btn btn-primary message-user" data-id = "{{$follower->id}}">Message</button>
                            @auth
                                @if(auth()->user()->id == $id)
                                    <form action = "{{route('user.add', $follower->id)}}" method = "post">
                                      @csrf
                                      <li style = "list-style-type: none">
                                          <a>
                                              <button class = "btn-primary" style = "display: inline-block" type = "submit"> 
                                                  @if($friends->where("user_id", "=", auth()->user()->id)->where("friend_id", "=", $follower->id)->where("status", "=", 1)->count() > 0)
                                                    <span>Unfriend</span>
                                                  @elseif($friends->where("user_id", "=", auth()->user()->id)->where("friend_id", "=", $follower->id)->where("status", "=", 0)->count() > 0)
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
                          </div>
                        </div>
                      </div>
                    </div>
                    @endforeach
                  @else
                  <div style = "padding: 20px;"><strong>No follower found!.</strong></div>
                  @endif




                 


                </div>
              </div>
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
  @endif
@endsection