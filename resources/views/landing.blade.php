@extends("layout.index")

@section('content')
    <!-- Landing Page Contents
    ================================================= -->
    <div id="lp-register">
        <div class="container wrapper">
            <div class="row">
                <div class="col-sm-5">
                <div class="intro-texts">
                    <h1 class="text-white">Meet a Date !!!</h1>
                    <p>Date Finder is a social network platform that enable users to connect to matching partner for the aim of friendship or finding the next perfect date. This platform offers a News Feed system, Chat System, Timeline and lot more. <br> <br>Why are you waiting for? Try it now.</p>
                    <a href = "{{route('newsfeed')}}"><button class="btn btn-primary">Find A Date Now...</button></a>
                </div>
            </div>
            <div class="col-sm-6 col-sm-offset-1">
                <div class="reg-form-container"> 
            
                    <!-- Register/Login Tabs-->
                    <div class="reg-options">
                        <ul class="nav nav-tabs">
                        <li class="active"><a href="{{route("register_page")}}" @if($uri === "login") style = "color: #939598" @else style = "color: white" @endif>Register</a></li>
                        <li><a href="{{route("login_page")}}" @if($uri === "login") style = "color: white" @else style = "color: #939598" @endif>Login</a></li>
                        </ul><!--Tabs End-->
                    </div>
            
                    <!--Registration Form Contents-->
                    <div class="tab-content">
                        <div class="tab-pane @if($uri === "login") @else active @endif" id="register">
                            <h3>Register Now !!!</h3>
                            <p class="text-muted">Be cool and join today. Meet millions</p>
                        
                            <!--Register Form-->
                            <form name="registration_form" id="registration_form" class="form-inline" action = "{{route('register')}}" method = "POST">
                                @error("duplicate email")
                                    <div class="alert alert-danger">{{$message}}</div>
                                @enderror
                                <div class="row">
                                    @csrf
                                    <div class="form-group col-xs-6">
                                        <label for="firstname" class="sr-only">First Name</label>
                                        <input  id="firstname" class="@error("firstname") border-danger @enderror form-control input-group-lg" type="text" name="firstname" title="Enter first name" placeholder="First name" value = {{old("firstname")}}>
                                        @error('firstname')
                                            <span class = "text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-xs-6">
                                        <label for="lastname" class="sr-only">Last Name</label>
                                        <input  id="lastname" class="@error("lastname") border-danger @enderror form-control input-group-lg" type="text" name="lastname" title="Enter last name" placeholder="Last name" value = {{old("lastname")}}>
                                        @error('lastname')
                                            <span class = "text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-xs-12">
                                        <label for="email" class="sr-only">Email</label>
                                        <input  id="email" class="@error("email") border-danger @enderror form-control input-group-lg" type="text" name="email" title="Enter Email" placeholder="Your Email" value = {{old("email")}}>
                                        @error('email')
                                            <span class = "text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-xs-12">
                                        <label for="password" class="sr-only">Password</label>
                                        <input  id="password" class="@error("password") border-danger @enderror form-control input-group-lg" type="password" name="password" title="Enter password" placeholder="Password">
                                        @error('password')
                                            <span class = "text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-xs-12">
                                        <label for="password" class="sr-only">Date of Birth</label>
                                        <input id="password" class="@error("dob") border-danger @enderror form-control input-group-lg" type="date" name="dob" title="Enter Date of birth" value = {{old("dob")}}>
                                        @error('dob')
                                            <span class = "text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div> 
                                <div class = "row">   
                                    <div class="form-group gender">
                                        <label class="radio-inline">
                                            <input type="radio" name="gender">Male
                                        </label>
                                        <label class="radio-inline">
                                            <input type="radio" name="gender">Female
                                        </label>
                                        @error('gender')
                                            <div class = "text-danger">{{$message}}</div>
                                        @enderror
                                    </div>
                                </div>  
                                <div class="row">
                                    <div class="form-group col-xs-6">
                                        <label for="city" class="sr-only">City</label>
                                        <input id="city" class="@error("city") border-danger @enderror form-control input-group-lg reg_name" type="text" name="city" title="Enter city" placeholder="Your city" value = {{old("city")}}>
                                        @error('city')
                                            <span class = "text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-xs-6">
                                        <label for="country" class="sr-only"></label>
                                        <select class="@error("country") border-danger @enderror form-control" id="country" name = "country" value = {{old("country")}}>
                                            <option value="country" disabled="">Country</option>
                                            <option value="AFG">Afghanistan</option>
                                            <option value="ALA">�land Islands</option>
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
                                            <option value="CIV">C�te d'Ivoire</option>
                                            <option value="HRV">Croatia</option>
                                            <option value="CUB">Cuba</option>
                                            <option value="CUW">Cura�ao</option>
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
                                            <option value="REU">R�union</option>
                                            <option value="ROU">Romania</option>
                                            <option value="RUS">Russian Federation</option>
                                            <option value="RWA">Rwanda</option>
                                            <option value="BLM">Saint Barth�lemy</option>
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
                                            <option value="USA">United States</option>
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
                                        @error('country')
                                            <span class = "text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                
                                <p><a href="#">Already have an account?</a></p>
                                <button type = "submit" class="btn btn-primary">Register Now</button>
                            </form><!--Register Now Form Ends-->
                        </div><!--Registration Form Contents Ends-->
                
                        <!--Login-->
                        <div class="tab-pane @if($uri === "login") active @else  @endif" id="login">
                            <h3>Login</h3>
                            <p class="text-muted">Log into your account</p>
                
                            <!--Login Form-->
                            <form name="Login_form" id="Login_form" action = "{{route('login')}}" method = "post">
                                @if(session('message'))
                                    <div class="alert alert-danger">{{session('message')}}</div>
                                @endif
                                @csrf
                                @if(session("status"))
                                  <div class = "alert alert-success" style = "margin-bottom: 20px;">{{session("status")}}</div>
                                @endif
                                <div class="row">
                                    <div class="form-group col-xs-12">
                                        <label for="my-email" class="sr-only">Email</label>
                                        <input id="my-email" class="form-control input-group-lg" type="text" name="email" title="Enter Email" placeholder="Your Email" value = "{{old("email")}}">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-xs-12">
                                        <label for="my-password" class="sr-only">Password</label>
                                        <input id="my-password" class="form-control input-group-lg" type="password" name="password" title="Enter password" placeholder="Password">
                                    </div>
                                </div>
                                <p>
                                    <input type="checkbox" name="remember_me" id="remember_me">
                                    <span>Remember me.</span>
                                </p>
                                <p><a href="{{route('password.request')}}">Forgot Password?</a></p>
                                <button type ="submit" class="btn btn-primary">Login Now</button>
                            </form><!--Login Form Ends-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6 col-sm-offset-6">
            
                <!--Social Icons-->
                <ul class="list-inline social-icons">
                    <li><a href="#"><i class="icon ion-social-facebook"></i></a></li>
                    <li><a href="#"><i class="icon ion-social-twitter"></i></a></li>
                    <li><a href="#"><i class="icon ion-social-googleplus"></i></a></li>
                    <li><a href="#"><i class="icon ion-social-pinterest"></i></a></li>
                    <li><a href="#"><i class="icon ion-social-linkedin"></i></a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class = "registration-counter-box">
        <h2 class="sub-title">Find awesome people like you</h2>
        <div id="incremental-counter" data-value="{{$registered}}">
        </div>
        <p>People already registered</p>
        <img src="{{asset("images/face-map.png")}}" alt="" class="img-responsive face-map slideUp hidden-sm hidden-xs" />
    </div>
@endsection