@extends("layout.profile")

@section("profile_content")
  @if($user->count() > 0)
    <div id="page-contents">
      <div class="row">
        <div class="col-md-3">
          
        </div>

        <div class="col-md-6">

          <!-- About
          ================================================= -->
          <div class="about-profile">
            <div class="about-content-block">
              <h4 class="grey"><i class="ion-ios-information-outline icon-in-title"></i>Personal Information</h4>
              
              <div class="personal-info">
     
                <div class="row">
                  <div class="form-group col-xs-6">
                    <label for="firstname">First name</label>
                    <p>{{ucwords($user->firstname)}}</p>
                  </div>
                  <div class="form-group col-xs-6">
                    <label for="lastname" class="">Last name</label>
                    <p>{{ucwords($user->lastname)}}</p>
                  </div>
                </div>
                <div class="row">
                  <div class="form-group col-xs-12">
                    <label for="email">Email</label>
                    <p>{{ucwords($user->email)}}</p>
                  </div>
                </div>
                <div class="row">
                  <p class="custom-label"><strong>Date of Birth</strong></p>
                  <div class="form-group col-sm-3 col-xs-6">
                    <label for="month" class="sr-only"></label>
                    <p>{{ucwords($user->dob)}}</p>
                  </div>
                </div>
                <div class="form-group gender">
                  <span class="custom-label"><strong>I am a: </strong></span>
                  <span>{{$user->gender == "on" ? "Male": Female}}</span>
                </div>
                <div class="row">
                  <div class="form-group col-xs-6">
                    <label for="city"> City</label>
                    <p>{{ucwords($user->city)}}</p>
                  </div>
                  <div class="form-group col-xs-6">
                    <label for="country">Country</label>
                    <p>{{ucwords($user->country)}}</p>
                  </div>
                </div>
                <div class="row">
                  <div class="form-group col-xs-12">
                    <label for="my-info">Bio</label>
                    <p class = "bio-text">{{ucwords($user->bio)}}</p>
                  </div>
                </div>
              </div>
            </div>
   
            <div class="about-content-block">
              <h4 class="grey"><i class="ion-ios-heart-outline icon-in-title"></i>Interests</h4>
              <div class="row">
                <div class="form-group col-xs-6">
                  <label for="city">Interested in</label>
                    <p>{{ucwords($user->interest)}}</p>
                </div>
                <div class="form-group col-xs-6">
                  <label for="country">Preferred Age</label>
                    <p>{{ucwords($user->interest_age_rage)}}</p>
                </div>
              </div>
            </div>
            <div class="about-content-block">
              <h4 class="grey"><i class="ion-ios-chatbubble-outline icon-in-title"></i>Language</h4>
              <ul>
                @if($user->languages != null)
                  <li><a href="">{{$user->language}}</a></li>
                @else
                  <div>No launguage added</div>
                @endif
              </ul>
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