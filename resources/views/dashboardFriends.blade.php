@extends("layout.dashboard")

@section('dashboard_content')
            
            
            <div class="friend-list">
            	<div class="row">
              @if($friends->count() > 0)
                @foreach($friends as $friend)
                  <?php $friend = $friend->user ?>
                  <div class="col-md-6 col-sm-6">
                        <div class="friend-card">
                           @if($friend->cover_image !== null)
                           <img src="{{$friend->cover_image}}" alt="cover image" class = "img-responsive cover" />
                           @else
                            <div class="img-responsive cover no-cover">No Cover Image</div>
                           @endif
                          <div class="card-info" style = "position: relative">
                             <img src="{{$friend->image === null ? asset('/images/default_profile_image.png') : $friend->image}}" alt="profile image" alt="user" class="img-responsive cover adjust" style = "object-fit: cover; margin-top: -60px; border: 7px solid white; width: 80px; height: 80px; overflow: hidden;">
         
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

@endsection