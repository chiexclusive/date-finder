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


                  @if($profile_friends->count() > 0)
                    @foreach($profile_friends as $friend)
                        <?php $friend = $friend->user()->get()[0] ?>
                    <div class="col-md-6 col-sm-6">
                      <div class="friend-card">
                        <div class = "cover-photo-container">
                          @if($friend->cover_image !== null)
                           <img src="{{$friend->cover_image}}" alt="cover image" class = "img-responsive cover" />
                           @else
                            <div class="img-responsive cover no-cover">No Cover Image</div>
                           @endif
                          
                        </div>
                        <div class="card-info" >
                           <img src="{{$friend->image === null ? asset('/images/default_profile_image.png') : $friend->image}}" alt="profile image" alt="user" class="profile-photo-lg" >
    
                          <div class="friend-info">
                            @auth
                                @if(auth()->user()->id !== $friend->id)
                                    <form action = "{{route('user.follow', $friend->id)}}" method = "post">
                                        @csrf
                                        <button style = "width: unset !important; padding-left: 0px!important" class = "pull-right text-green button_rep following" style = "display: inline-block" type = "submit">{{($followers->where("follower_id", "=", auth()->user()->id)->count() > 0)? "following":"follow"}}</button>
                                    </form>                                    
                                @endif
                            @endauth
                            <h5><a href="{{route('timeline', $friend->id)}}" class="profile-link">{{ucwords($friend->firstname) ." ". ucwords($friend->lastname)}}</a></h5>
                            <p class = "bio-text">{{$friend->bio}}</p>
                            <button class = "btn btn-primary message-user" data-id = "{{$friend->id}}">Message</button>
                          </div>
                        </div>
                      </div>
                    </div>
                    @endforeach
                  @else
                  <div style = "padding: 20px;"><strong>No friend found!.</strong></div>
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