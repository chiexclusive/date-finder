@extends("layout.profile")

@section("profile_content")
  @if($user->count() > 0)
    <div id="page-contents">
      <div class="row">

        <div class="col-md-3">
          @auth
            <!--Edit Profile Menu-->
            <ul class="edit-menu">
              <li @if($sub_type == "basic") class="active" @endif><i class="icon ion-ios-information-outline"></i><a href="{{route('edit_profile_basic', $id)}}"">Basic Information</a></li>
              <li @if($sub_type == "interests") class="active" @endif><i class="icon ion-ios-heart-outline"></i><a href="{{route('edit_profile_interests', $id)}}">My Interests</a></li>
              <li @if($sub_type == "language") class="active" @endif><i class="icon ion-ios-settings"></i><a href="{{route('edit_profile_langs', $id)}}">Language</a></li>
              <li @if($sub_type == "password") class="active" @endif><i class="icon ion-ios-locked-outline"></i><a href="{{route('edit_profile_password', $id)}}">Change Password</a></li>
            </ul>
          @endauth
        </div>




        <div class="col-md-6">

          <!-- About
          ================================================= -->
          <form action = {{route("edit_profile", $id)}} method = "POST">
            @csrf
            @method("PUT")
            <input type = "text" name = "type" value = {{$sub_type}} class = "hidden" />
            <div class="about-profile">
              @if($sub_type =="basic")
                <div class="about-content-block">
                  <h4 class="grey"><i class="ion-ios-information-outline icon-in-title"></i>Personal Information</h4>
                  <div class="personal-info">
                    <div class="row">
                      <div class="form-group col-xs-6">
                        <label for="firstname">First name</label>
                        @auth
                          @if(auth()->user()->id != $id)
                            <p>{{ucwords($user->firstname)}}</p>
                          @else
                            <input id="firstname" class="form-control input-group-lg" type="text" name="firstname" title="Enter first name" placeholder="First name" value="{{ucwords(auth()->user()->firstname)}}" @error("firstname") style = "border-color: red" @enderror>
                          @endif
                        @endauth
                        @guest
                           <p>{{ucwords($user->firstname)}}</p>
                        @endguest
                      </div>
                      <div class="form-group col-xs-6">
                        <label for="lastname" class="">Last name</label>
                        @auth
                           @if(auth()->user()->id != $id)
                            <p>{{ucwords($user->lastname)}}</p>
                          @else
                            <input id="lastname" class="form-control input-group-lg" type="text" name="lastname" title="Enter last name" placeholder="Last Name" value="{{ucwords(auth()->user()->lastname)}}" @error("lastname") style = "border-color: red" @enderror>
                          @endif
                        @endauth
                        @guest
                           <p>{{ucwords($user->lastname)}}</p>
                        @endguest
                      </div>
                    </div>
                    <div class="row">
                      <div class="form-group col-xs-12">
                        <label for="email">Email</label>
                        @auth
                          @if(auth()->user()->id != $id)
                            <p>{{ucwords($user->email)}}</p>
                          @else
                            <input id="email" class="form-control input-group-lg" type="email" name="email" title="Enter email" placeholder="Email" value="{{ucwords(auth()->user()->email)}}" @error("email") style = "border-color: red" @enderror>
                          @endif
                        @endauth
                        @guest
                          <p>{{ucwords($user->email)}}</p>
                        @endguest
                      </div>
                    </div>
                    <div class="row">
                      <p class="custom-label"><strong>Date of Birth</strong></p>
                      <div class="form-group">
                        <label for="month" class="sr-only"></label>
                        @auth
                          @if(auth()->user()->id != $id)
                            <p>{{ucwords($user->dob)}}</p>
                          @else
                            <input id="dob" class="form-control input-group-lg" type="date" name="dob" title="Select date of birth" placeholder="Date of Birth" value="{{ucwords(auth()->user()->dob)}}" @error("dob") style = "border-color: red" @enderror>

                          @endif
                        @endauth
                        @guest
                          <p>{{ucwords($user->dob)}}</p>
                        @endguest
                      </div>
                    </div>
                    <div class="form-group gender">
                        <span class="custom-label"><strong>I am a: </strong></span>
                        @auth
                          @if(auth()->user()->id != $id)
                            <span>{{ucwords($user->gender)}}</span>
                          @else
                             <label class="radio-inline">
                                <input type="radio" name="gender" @if(auth()->user()->gender == "male" || auth()->user()->gender == "on" ) checked = "checked"  @endif >Male
                              </label>
                              <label class="radio-inline">
                              <input type="radio" name="gender" @if(auth()->user()->gender == "female" || auth()->user()->gender == "off" ) checked = "checked"  @endif >Female
                              </label>
                              @error("country")
                                <span>{{$message}}</span>
                              @enderror
                          @endif
                        @endauth

                        @guest
                          @if($user->gender == "male" || $user->gender == "on")
                            <span>Male</span>
                          @elseif($user->gender == "female" || $user->gender == "off")
                            <span>Female</span>
                          @endif
                        @endguest
                       
                    </div>
                    <div class="row">
                      <div class="form-group col-xs-6">
                        <label for="city"> City</label>
                        @auth
                          @if(auth()->user()->id != $id)
                            <p>{{ucwords($user->city)}}</p>
                          @else
                            <input id="city" class="form-control input-group-lg" type="text" name="city" title="Select a city" placeholder="City" value="{{ucwords(auth()->user()->city)}}" @error("city") style = "border-color: red" @enderror>
                          @endif
                        @endauth
                        @guest
                          <p>{{ucwords($user->city)}}</p>
                        @endguest
                      </div>
                      <div class="form-group col-xs-6">
                        <label for="country">Country</label>
                        @auth
                          @if(auth()->user()->id != $id)
                            <p>{{ucwords($user->country)}}</p>
                          @else
                            <select class="form-control" id="country" title="Select a country" name="country" value="{{ucwords(auth()->user()->country)}}" @error("country") style = "border-color: red" @enderror>
                              <option value="country">Country</option>
                              <option value="AFG">Afghanistan</option>
                              <option value="ALA">Ƭand Islands</option>
                              <option value="ALB">Albania</option>
                              <option value="DZA">Algeria</option>
                              <option value="ASM">American Samoa</option>
                              <option value="AND">Andorra</option>
                              <option value="AGO">Angola</option>
                              <option value="AIA">Anguilla</option>
                              <option value="ATA">Antarctica</option>
                              <option value="ATG">Antigua and Barbuda</option>
                              <option value="ARG">Argentina</option>
                              <option value="ARM">Armenia</option>
                              <option value="ABW">Aruba</option>
                              <option value="AUS">Australia</option>
                              <option value="AUT">Austria</option>
                              <option value="AZE">Azerbaijan</option>
                              <option value="BHS">Bahamas</option>
                              <option value="BHR">Bahrain</option>
                              <option value="BGD">Bangladesh</option>
                              <option value="BRB">Barbados</option>
                              <option value="BLR">Belarus</option>
                              <option value="BEL">Belgium</option>
                              <option value="BLZ">Belize</option>
                              <option value="BEN">Benin</option>
                              <option value="BMU">Bermuda</option>
                              <option value="BTN">Bhutan</option>
                              <option value="BOL">Bolivia, Plurinational State of</option>
                              <option value="BES">Bonaire, Sint Eustatius and Saba</option>
                              <option value="BIH">Bosnia and Herzegovina</option>
                              <option value="BWA">Botswana</option>
                              <option value="BVT">Bouvet Island</option>
                              <option value="BRA">Brazil</option>
                              <option value="IOT">British Indian Ocean Territory</option>
                              <option value="BRN">Brunei Darussalam</option>
                              <option value="BGR">Bulgaria</option>
                              <option value="BFA">Burkina Faso</option>
                              <option value="BDI">Burundi</option>
                              <option value="KHM">Cambodia</option>
                              <option value="CMR">Cameroon</option>
                              <option value="CAN">Canada</option>
                              <option value="CPV">Cape Verde</option>
                              <option value="CYM">Cayman Islands</option>
                              <option value="CAF">Central African Republic</option>
                              <option value="TCD">Chad</option>
                              <option value="CHL">Chile</option>
                              <option value="CHN">China</option>
                              <option value="CXR">Christmas Island</option>
                              <option value="CCK">Cocos (Keeling) Islands</option>
                              <option value="COL">Colombia</option>
                              <option value="COM">Comoros</option>
                              <option value="COG">Congo</option>
                              <option value="COD">Congo, the Democratic Republic of the</option>
                              <option value="COK">Cook Islands</option>
                              <option value="CRI">Costa Rica</option>
                              <option value="CIV">C𴥠d'Ivoire</option>
                              <option value="HRV">Croatia</option>
                              <option value="CUB">Cuba</option>
                              <option value="CUW">Cura袯</option>
                              <option value="CYP">Cyprus</option>
                              <option value="CZE">Czech Republic</option>
                              <option value="DNK">Denmark</option>
                              <option value="DJI">Djibouti</option>
                              <option value="DMA">Dominica</option>
                              <option value="DOM">Dominican Republic</option>
                              <option value="ECU">Ecuador</option>
                              <option value="EGY">Egypt</option>
                              <option value="SLV">El Salvador</option>
                              <option value="GNQ">Equatorial Guinea</option>
                              <option value="ERI">Eritrea</option>
                              <option value="EST">Estonia</option>
                              <option value="ETH">Ethiopia</option>
                              <option value="FLK">Falkland Islands (Malvinas)</option>
                              <option value="FRO">Faroe Islands</option>
                              <option value="FJI">Fiji</option>
                              <option value="FIN">Finland</option>
                              <option value="FRA">France</option>
                              <option value="GUF">French Guiana</option>
                              <option value="PYF">French Polynesia</option>
                              <option value="ATF">French Southern Territories</option>
                              <option value="GAB">Gabon</option>
                              <option value="GMB">Gambia</option>
                              <option value="GEO">Georgia</option>
                              <option value="DEU">Germany</option>
                              <option value="GHA">Ghana</option>
                              <option value="GIB">Gibraltar</option>
                              <option value="GRC">Greece</option>
                              <option value="GRL">Greenland</option>
                              <option value="GRD">Grenada</option>
                              <option value="GLP">Guadeloupe</option>
                              <option value="GUM">Guam</option>
                              <option value="GTM">Guatemala</option>
                              <option value="GGY">Guernsey</option>
                              <option value="GIN">Guinea</option>
                              <option value="GNB">Guinea-Bissau</option>
                              <option value="GUY">Guyana</option>
                              <option value="HTI">Haiti</option>
                              <option value="HMD">Heard Island and McDonald Islands</option>
                              <option value="VAT">Holy See (Vatican City State)</option>
                              <option value="HND">Honduras</option>
                              <option value="HKG">Hong Kong</option>
                              <option value="HUN">Hungary</option>
                              <option value="ISL">Iceland</option>
                              <option value="IND">India</option>
                              <option value="IDN">Indonesia</option>
                              <option value="IRN">Iran, Islamic Republic of</option>
                              <option value="IRQ">Iraq</option>
                              <option value="IRL">Ireland</option>
                              <option value="IMN">Isle of Man</option>
                              <option value="ISR">Israel</option>
                              <option value="ITA">Italy</option>
                              <option value="JAM">Jamaica</option>
                              <option value="JPN">Japan</option>
                              <option value="JEY">Jersey</option>
                              <option value="JOR">Jordan</option>
                              <option value="KAZ">Kazakhstan</option>
                              <option value="KEN">Kenya</option>
                              <option value="KIR">Kiribati</option>
                              <option value="PRK">Korea, Democratic People's Republic of</option>
                              <option value="KOR">Korea, Republic of</option>
                              <option value="KWT">Kuwait</option>
                              <option value="KGZ">Kyrgyzstan</option>
                              <option value="LAO">Lao People's Democratic Republic</option>
                              <option value="LVA">Latvia</option>
                              <option value="LBN">Lebanon</option>
                              <option value="LSO">Lesotho</option>
                              <option value="LBR">Liberia</option>
                              <option value="LBY">Libya</option>
                              <option value="LIE">Liechtenstein</option>
                              <option value="LTU">Lithuania</option>
                              <option value="LUX">Luxembourg</option>
                              <option value="MAC">Macao</option>
                              <option value="MKD">Macedonia, the former Yugoslav Republic of</option>
                              <option value="MDG">Madagascar</option>
                              <option value="MWI">Malawi</option>
                              <option value="MYS">Malaysia</option>
                              <option value="MDV">Maldives</option>
                              <option value="MLI">Mali</option>
                              <option value="MLT">Malta</option>
                              <option value="MHL">Marshall Islands</option>
                              <option value="MTQ">Martinique</option>
                              <option value="MRT">Mauritania</option>
                              <option value="MUS">Mauritius</option>
                              <option value="MYT">Mayotte</option>
                              <option value="MEX">Mexico</option>
                              <option value="FSM">Micronesia, Federated States of</option>
                              <option value="MDA">Moldova, Republic of</option>
                              <option value="MCO">Monaco</option>
                              <option value="MNG">Mongolia</option>
                              <option value="MNE">Montenegro</option>
                              <option value="MSR">Montserrat</option>
                              <option value="MAR">Morocco</option>
                              <option value="MOZ">Mozambique</option>
                              <option value="MMR">Myanmar</option>
                              <option value="NAM">Namibia</option>
                              <option value="NRU">Nauru</option>
                              <option value="NPL">Nepal</option>
                              <option value="NLD">Netherlands</option>
                              <option value="NCL">New Caledonia</option>
                              <option value="NZL">New Zealand</option>
                              <option value="NIC">Nicaragua</option>
                              <option value="NER">Niger</option>
                              <option value="NGA">Nigeria</option>
                              <option value="NIU">Niue</option>
                              <option value="NFK">Norfolk Island</option>
                              <option value="MNP">Northern Mariana Islands</option>
                              <option value="NOR">Norway</option>
                              <option value="OMN">Oman</option>
                              <option value="PAK">Pakistan</option>
                              <option value="PLW">Palau</option>
                              <option value="PSE">Palestinian Territory, Occupied</option>
                              <option value="PAN">Panama</option>
                              <option value="PNG">Papua New Guinea</option>
                              <option value="PRY">Paraguay</option>
                              <option value="PER">Peru</option>
                              <option value="PHL">Philippines</option>
                              <option value="PCN">Pitcairn</option>
                              <option value="POL">Poland</option>
                              <option value="PRT">Portugal</option>
                              <option value="PRI">Puerto Rico</option>
                              <option value="QAT">Qatar</option>
                              <option value="REU">R궮ion</option>
                              <option value="ROU">Romania</option>
                              <option value="RUS">Russian Federation</option>
                              <option value="RWA">Rwanda</option>
                              <option value="BLM">Saint Barthꭥmy</option>
                              <option value="SHN">Saint Helena, Ascension and Tristan da Cunha</option>
                              <option value="KNA">Saint Kitts and Nevis</option>
                              <option value="LCA">Saint Lucia</option>
                              <option value="MAF">Saint Martin (French part)</option>
                              <option value="SPM">Saint Pierre and Miquelon</option>
                              <option value="VCT">Saint Vincent and the Grenadines</option>
                              <option value="WSM">Samoa</option>
                              <option value="SMR">San Marino</option>
                              <option value="STP">Sao Tome and Principe</option>
                              <option value="SAU">Saudi Arabia</option>
                              <option value="SEN">Senegal</option>
                              <option value="SRB">Serbia</option>
                              <option value="SYC">Seychelles</option>
                              <option value="SLE">Sierra Leone</option>
                              <option value="SGP">Singapore</option>
                              <option value="SXM">Sint Maarten (Dutch part)</option>
                              <option value="SVK">Slovakia</option>
                              <option value="SVN">Slovenia</option>
                              <option value="SLB">Solomon Islands</option>
                              <option value="SOM">Somalia</option>
                              <option value="ZAF">South Africa</option>
                              <option value="SGS">South Georgia and the South Sandwich Islands</option>
                              <option value="SSD">South Sudan</option>
                              <option value="ESP">Spain</option>
                              <option value="LKA">Sri Lanka</option>
                              <option value="SDN">Sudan</option>
                              <option value="SUR">Suriname</option>
                              <option value="SJM">Svalbard and Jan Mayen</option>
                              <option value="SWZ">Swaziland</option>
                              <option value="SWE">Sweden</option>
                              <option value="CHE">Switzerland</option>
                              <option value="SYR">Syrian Arab Republic</option>
                              <option value="TWN">Taiwan, Province of China</option>
                              <option value="TJK">Tajikistan</option>
                              <option value="TZA">Tanzania, United Republic of</option>
                              <option value="THA">Thailand</option>
                              <option value="TLS">Timor-Leste</option>
                              <option value="TGO">Togo</option>
                              <option value="TKL">Tokelau</option>
                              <option value="TON">Tonga</option>
                              <option value="TTO">Trinidad and Tobago</option>
                              <option value="TUN">Tunisia</option>
                              <option value="TUR">Turkey</option>
                              <option value="TKM">Turkmenistan</option>
                              <option value="TCA">Turks and Caicos Islands</option>
                              <option value="TUV">Tuvalu</option>
                              <option value="UGA">Uganda</option>
                              <option value="UKR">Ukraine</option>
                              <option value="ARE">United Arab Emirates</option>
                              <option value="GBR">United Kingdom</option>
                              <option value="USA" selected="">United States</option>
                              <option value="UMI">United States Minor Outlying Islands</option>
                              <option value="URY">Uruguay</option>
                              <option value="UZB">Uzbekistan</option>
                              <option value="VUT">Vanuatu</option>
                              <option value="VEN">Venezuela, Bolivarian Republic of</option>
                              <option value="VNM">Viet Nam</option>
                              <option value="VGB">Virgin Islands, British</option>
                              <option value="VIR">Virgin Islands, U.S.</option>
                              <option value="WLF">Wallis and Futuna</option>
                              <option value="ESH">Western Sahara</option>
                              <option value="YEM">Yemen</option>
                              <option value="ZMB">Zambia</option>
                              <option value="ZWE">Zimbabwe</option>
                            </select>
                          @endif
                        @endauth
                        @guest
                          <p>{{ucwords($user->country)}}</p>
                        @endguest
                      </div>
                    </div>
                    <div class="row">
                      <div class="form-group col-xs-12 bio">
                        <label for="my-info">Bio</label>
                        @auth
                          @if(auth()->user()->id != $id)
                            <p>{{ucwords($user->bio)}}</p>
                          @else
                            <textarea maxlength = "50" id="bio" class = "bio" class="form-control input-group-lg" type="text" name="bio" title="Select date of birth" placeholder="Bio" value="{{auth()->user()->bio}}"></textarea>
                            <div class = "hidden bio_initial">{{auth()->user()->bio}}</div>
                          @endif
                        @endauth
                        @guest
                          <p>{{ucwords($user->bio)}}</p>
                        @endguest
                      </div>
                    </div>
                  </div>
                </div>
              @endif
              @if($sub_type == "interests")
                <div class="about-content-block">
                  <h4 class="grey"><i class="ion-ios-heart-outline icon-in-title"></i>Interests</h4>
                  <div class="row">
                    <div class="form-group col-xs-6">
                      <label for="city">Interested in</label>
                      @auth
                        @if(auth()->user()->id != $id)
                          <p>{{ucwords($user->interest)}}</p>
                        @else
                          <select @error('interest') style = "border-color: red" @enderror  class="form-control" id="interest" title="Select an interest" name="interest">
                            <option value="male"  @if(auth()->user()->interest == "male") selected @endif>Men</option>
                            <option value="female"  @if(auth()->user()->interest == "female") selected @endif>Women</option>
                            <option value="*" @if(auth()->user()->interest == "*") selected @endif>Both</option>
                          </select>
                      
                        @endif
                      @endauth
                      @guest
                        <p>{{ucwords($user->interest)}}</p>
                      @endguest
                    </div>
                    <div class="form-group col-xs-6">
                      <label for="country">Preferred Age</label>
                      @auth
                        @if(auth()->user()->id != $id)
                          <p>{{ucwords($user->interest_age_rage)}}</p>
                        @else
                          <select @error('interest_age_range') style = "border-color: red" @enderror class="form-control" id="interest_age_rage" title="Select age" name="interest_age_range" >
                            <option value="18-25" @if(auth()->user()->interest_age_range == "18-25") selected @endif >18-25</option>
                            <option value="25-50" @if(auth()->user()->interest_age_range == "25-50") selected @endif >25-50</option>
                            <option value="50 and above" @if(auth()->user()->interest_age_range == "50 and above") selected @endif>50 and above</option>
                          </select>
                        @endif
                      @endauth
                      @guest
                        <p>{{ucwords($user->interest_age_rage)}}</p>
                      @endguest
                    </div>
                  </div>
                </div>
              @endif
              @if($sub_type == "language")
                <div class="about-content-block">
                  <h4 class="grey"><i class="ion-ios-chatbubble-outline icon-in-title"></i>Language</h4>
                  @auth
                    @if(auth()->user()->id == $id)
                      <div style = "display: flex" class = "btn-group">
                        <input @error('language') style = "border-color: red" @enderror id="language" class="form-control input-group-lg" type="language" name="language" title="Enter language" placeholder="language" value="{{ucwords(auth()->user()->language)}}">
                      </div>
                    @endif
                  @endauth

                  <ul>
                    @if($user->languages != null)
                        <div class = "btn-group">
                          <li><a href="">{{$language}}</a></li>
                        </div>
                    @else
                      <div>No launguage added</div>
                    @endif
                  </ul>
                </div>
              @endif
              @if($sub_type == "password")
                <div class="about-content-block">
                  <h4 class="grey"><i class="icon ion-ios-locked-outline icon-in-title"></i>Password</h4>
                  @auth
                    @if(auth()->user()->id == $id)
                        <input  @error('password') style = "border-color: red" @enderror id="language" class="form-control input-group-lg" type="password" name="password" title="Enter new password" placeholder="New Password..."/>
                    @endif
                  @endauth
                </div>
              @endif
            </div>
            <button class="btn btn-primary">Save Changes</button>

            @if(session('data'))
              <div style = "margin-top: 10px" class = "alert @if(session('data')['success']) alert-success @else alert-danger @endif">{{session('data')['message']}}</div>
            @endif

          </form>






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