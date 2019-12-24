@extends('layouts.adminLayout.admin_design') @section('content')
<!-- left column -->
<script src="{{ asset('bower_components/jquery/src/ajax/jquery.min.js') }}"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.min.js"></script>   
<style type="text/css">
   /*  .accordion-container {
   position: relative;
   width: 100%;
   border: 1px solid #82C030;
   border-top: none;
   outline: 0;
   cursor: pointer
   }*/
   .accordion-container .article-title {
   display: block;
   position: relative;
   margin: 0;
   padding: 0.625em 0.625em 0.625em 2em;
   border-top: 1px solid #ff851b;
   font-size: 1.20em;
   font-weight: bold;
   font-weight: normal;
   color: #444C3A;
   cursor: pointer;
   }
   .checkmark {
   position: absolute;
   top: 0;
   left: 0;
   height: 25px;
   width: 25px;
   background-color: #eee;
   }
   /* On mouse-over, add a grey background color */
   .container:hover input ~ .checkmark {
   background-color: #ccc;
   }
   /* When the checkbox is checked, add a blue background */
   .container input:checked ~ .checkmark {
   background-color: #2196F3;
   }
   /* Create the checkmark/indicator (hidden when not checked) */
   .checkmark:after {
   content: "";
   position: absolute;
   display: none;
   }
   /* Show the checkmark when checked */
   .container input:checked ~ .checkmark:after {
   display: block;
   }
   .container .checkmark:after {
   left: 9px;
   top: 5px;
   width: 5px;
   height: 10px;
   border: solid white;
   border-width: 0 3px 3px 0;
   -webkit-transform: rotate(45deg);
   -ms-transform: rotate(45deg);
   transform: rotate(45deg);
   }
   .accordion-container .article-title:hover,
   .accordion-container .article-title:notActive,
   .accordion-container .content-entry.open .article-title {
   background-color: #82C030;
   color: white;
   }
   .accordion-container .article-title:hover i:before,
   .accordion-container .article-title:hover i:notActive,
   .accordion-container .content-entry.open i {
   color: white;
   }
   .accordion-container .content-entry i {
   position: absolute;
   top: 3px;
   left: 12px;
   font-style: normal;
   font-size: 1.625em;
   sans-serif;
   color: #ff851b;
   }
   .accordion-container .content-entry i:before {
   content: "+ ";
   }
   .accordion-container .content-entry.open i:before {
   content: "- ";
   }
   .accordion-content {
   display: none;
   padding-left: 2.3125em;
   }
   /* This stuff is just for the Codepen demo */
   #content {
   width: 100%;
   }
   .accordion-container,
   #description {
   width: 90%;
   margin: 1.875em auto;
   }
   @media all and (min-width: 860px) {
   #content {
   width: 70%;
   margin: 0 auto;
   }
   }
   .badgebox
   {
   opacity: 0;
   }
   .badgebox + .badge
   {
   /* Move the check mark away when unchecked */
   text-indent: -999999px;
   /* Makes the badge's width stay the same checked and unchecked */
   width: 27px;
   }
   .badgebox:focus + .badge
   {
   /* Set something to make the badge looks focused */
   /* This really depends on the application, in my case it was: */
   /* Adding a light border */
   box-shadow: inset 0px 0px 5px;
   Taking the difference out of the padding 
   }
   .badgebox:checked + .badge
   {
   /* Move the check mark back when checked */
   text-indent: 0;
   }
   .btn-success{
   background-color: #82C030;
   border-color: #82C030;
   }
   .btn-success:hover{
   background-color: #83C530;
   border-color: #83C530;
   }
   #radioBtn .notActive{
   color: #000000;
   background-color: #fff;
   }
   .check
   {
   opacity:0.5;
   color:#996;
   }
   .box{
   margin-bottom:5px;
   }
</style>
<div class="content-wrapper">
<section class="content-header">
   <h2>Membership Form <a href="{{url('viewrequests')}}" class="btn bg-orange"> View All Form</a></h2>

</section>
<!-- general form elements -->

<div class="content">
@if ($errors->any())
<div class="alert alert-danger">
   <button type="button" class="close" data-dismiss="alert">×</button>
   <ul>
      @foreach ($errors->all() as $error)
      <li>{{ $error }}</li>
      @endforeach
   </ul>
</div>
@endif @if ($message = Session::get('message')) @if($message=="Succesfully added")
<div class="alert alert-success alert-block">
   <button type="button" class="close" data-dismiss="alert">×</button> <strong>{{ $message }}</strong>
</div>
@endif @if($message=="User Already exists")
<div class="alert alert-danger alert-block" id="danger-alert1">
   <button type="button" class="close" data-dismiss="alert">×</button> <strong>{{ $message }}</strong>
</div>
@endif @if($message=="User Is Already Exits")
<div class="alert alert-danger alert-block" id="alert1">
   <button type="button" class="close" data-dismiss="alert">×</button> <strong>{{ $message }}</strong>
</div>
@endif @endif
<script type="text/javascript">
   $(document).ready (function(){
           $("#danger-alert1").fadeTo(1000, 500).slideUp(500, function(){
            $("#danger-alert1").slideUp(500);
          });  
           $("#alert").fadeTo(1000, 500).slideUp(500, function(){
            $("#alert").slideUp(500);
          });   
         });
</script>
<section id="content">

   <form action="{{ url('verify') }}" method="post" enctype="multipart/form-data" enctype="multipart/formdata" id="member_form" onsubmit = "return ValidateForm();">
      {{ csrf_field() }}
      <div id="accordion" class="accordion-container">
      <!--  <article class="content-entry">
         <h4 class="article-title"><i></i>Personal Details</h4>
         <div class="accordion-content"><br/>
            <div class="well well-lg">
             <div class="row">
               <div class="col-md-6">
         
                 <label for="1" class="btn btn-success">Body Building <input type="checkbox" onclick="" id="1" class="badgebox"><span class="badge">&check;</span></label>        
               </div>
               <div class="col-md-6">
                 <label for="2" class="btn btn-success">Weight Gain <input type="checkbox" id="2" class="badgebox"><span class="badge">&check;</span></label>
                 
               </div>
             </div><br/>
             <div class="row">
               <div class="col-md-6">
                  <label for="3" class="btn btn-success">Weight Loss <input type="checkbox" id="3" class="badgebox"><span class="badge">&check;</span></label>
               </div>
               <div class="col-md-6">
                 <label for="4" class="btn btn-success">Height <input type="checkbox" id="4" class="badgebox"><span class="badge">&check;</span></label>  
               </div>
             </div><br/>
             <div class="row">
               <div class="col-md-6">
                  <label for="5" class="btn btn-success">Others, Specify<input type="checkbox" id="5" class="badgebox"><span class="badge">&check;</span></label>
               </div>
             </div>
             
         
         
            </div>
         </div>
         /.accordion-content-->
      <!--         </article> -->

      <article class="content-entry open">
         <h4 class="article-title"><i></i>Registration Details</h4>
         <div class="accordion-content" style="display:block;">
         <br/>
         <div class="well well-lg">
            <div class="form-group">
               <label>First Name<span style="color: red">*</span>
               </label>
               <input type="text" name="firstname" id="firstname" class="form-control" placeholder="Firstname" class="span11" required="" maxlength="60" value="{{ old('firstname') }} @if(!empty($memberdata->firstname)){{ $memberdata->firstname }} @endif" />
            </div>
            <div class="form-group">
               <label>LastName<span style="color: red">*</span>
               </label>
               <input type="text" name="lastname" id="lastname" class="form-control inline-block" placeholder="LastName" class="span11" maxlength="60" value="{{ old('lastname') }}@if(!empty($memberdata->lastname)){{ $memberdata->lastname }} @endif" required="" />
            </div>
            <div class="form-group">
               <label>User Name</label>
               <input type="text" name="username" id="username" class="form-control" placeholder="User Name" class="span11" required="" maxlength="60" value="@if(!empty($memberdata->username)){{ $memberdata->username }} @endif" /><span id="error_username"></span>
            </div>
            <div class="form-group">
               <label>Gender<span style="color: red">*</span>
               </label>
               <label>
               <input type="radio" name="gender" value="Female" required   @if(!empty($memberdata->gender)){{ $memberdata->gender  == 'Female' ? 'checked' : ''}} @endif >Female</label>
               <label>
               <input type="radio" name="gender" value="Male"  @if(!empty($memberdata->gender)){{ $memberdata->gender  == 'Male' ? 'checked' : ''}} @endif>Male</label>
            </div>
            <div class="form-group">
               <label>Email<span style="color: red">*</span>
               </label>
               <input type="email" maxlength="60" value="{{ old('email') }} @if(!empty($memberdata->email)){{ $memberdata->email }} @endif" id="email" name="email" class="form-control" placeholder="Email Id" class="span11" required />
            </div>
            <div class="form-group">
               <label>Cell Phone Number<span style="color: red">*</span>
               </label>
               <input type="text" name="CellPhoneNumber" value="{{ old('mobileno') }} @if(!empty($memberdata->mobileno)){{ $memberdata->mobileno }} @endif" id="MobileNo" minlength="10" maxlength="10" class="form-control number" placeholder="Cell Phone Number" required="" class="span11" /><span id="error_usermobile"></span>
            </div>
            <div class="form-group">
               <label>Preferred Timing</label>
               <br> <span><label>From</label></span>
             
               <select type="time" class="form-control" name="working_hour_from_1" id="fromtime" required="">
                <option value="06:00" @if(old( 'working_hour_from_1')=='06:00' ) selected @endif @if(!empty($memberdata->working_hour_from_1)) {{ $memberdata->working_hour_from_1=='06:00' ? 'selected' : ''}} @endif>06:00 AM</option>
               <option value="07:00" @if(old( 'working_hour_from_1')=='07:00' ) selected @endif >07:00 AM</option>
               <option value="08:00" @if(old( 'working_hour_from_1')=='08:00' ) selected @endif >08:00 AM</option>
               <option value="09:00" @if(old( 'working_hour_from_1')=='09:00' ) selected @endif>09:00 AM</option>
               <option value="10:00" @if(old( 'working_hour_from_1')=='10:00' ) selected @endif >10:00 AM</option>
               <option value="11:00" @if(old( 'working_hour_from_1')=='11:00' ) selected @endif >11:00 AM</option>
               <option value="12:00"  >12:00 PM</option>
               <option value="13:00"  >01:00 PM</option>
               <option value="14:00"  >02:00 PM</option>
               <option value="15:00" @if(old( 'working_hour_from_1')=='15:00' ) selected @endif>03:00 PM</option>
               <option value="16:00" @if(old( 'working_hour_from_1')=='16:00' ) selected @endif>04:00 PM</option>
               <option value="17:00" @if(old( 'working_hour_from_1')=='17:00' ) selected @endif>05:00 PM</option>
               <option value="18:00" @if(old( 'working_hour_from_1')=='18:00' ) selected @endif>06:00 PM</option>
               <option value="19:00" @if(old( 'working_hour_from_1')=='19:00' ) selected @endif >07:00 PM</option>
               <option value="20:00" @if(old( 'working_hour_from_1')=='20:00' ) selected @endif >08:00 PM</option>
               <option value="21:00" @if(old('working_hour_from_1')=='21:00' ) selected @endif >09:00 PM</option>
               <option value="22:00" @if(old( 'working_hour_from_1')=='22:00' ) selected @endif >10:00 PM</option>
               </select>
               <label>To</label>
               <select type="time" class="form-control" id="totime" name="working_hour_to_1" required="">
               <option value="07:00" @if(old( 'working_hour_to_1')=='07:00' ) selected @endif  >07:00 AM</option>
               <option value="08:00" @if(old( 'working_hour_to_1')=='08:00' ) selected @endif>08:00 AM</option>
               <option value="09:00" @if(old( 'working_hour_to_1')=='09:00' ) selected @endif>09:00 AM</option>
               <option value="10:00" @if(old( 'working_hour_to_1')=='10:00' ) selected @endif>10:00 AM</option>
               <option value="11:00" @if(old( 'working_hour_to_1')=='11:00' ) selected @endif>11:00 AM</option>
               <option value="12:00" @if(old( 'working_hour_to_1')=='12:00' ) selected @endif>12:00 PM</option>
               <option value="13:00" @if(old( 'working_hour_to_1')=='13:00' ) selected @endif>01:00 PM</option>
               <option value="14:00" @if(old( 'working_hour_to_1')=='14:00' ) selected @endif>02:00 PM</option>
               <option value="15:00" @if(old( 'working_hour_to_1')=='15:00' ) selected @endif>03:00 PM</option>
               <option value="16:00" @if(old( 'working_hour_to_1')=='16:00' ) selected @endif>04:00 PM</option>
               <option value="17:00" @if(old( 'working_hour_to_1')=='17:00' ) selected @endif>05:00 PM</option>
               <option value="18:00" @if(old( 'working_hour_to_1')=='18:00' ) selected @endif>06:00 PM</option>
               <option value="19:00" @if(old( 'working_hour_to_1')=='19:00' ) selected @endif>07:00 PM</option>
               <option value="20:00" @if(old( 'working_hour_to_1')=='20:00' ) selected @endif>08:00 PM</option>
               <option value="21:00" @if(old( 'working_hour_to_1')=='21:00' ) selected @endif>09:00 PM</option>
               <option value="22:00" @if(old( 'working_hour_to_1')=='22:00' ) selected @endif>10:00 PM</option>
               <option value="22:00" @if(old( 'working_hour_to_1')=='23:00' ) selected @endif>11:00 PM</option>
               </select>
            </div>
         </div>
      </article>
      <article class="content-entry">
         <h4 class="article-title"><i></i>Contact Details</h4>
         <div class="accordion-content">
         <br/>
         <div class="well well-lg">
            <div class="form-group">
               <label>Address</label>
               <textarea rows="2" cols="20" name="Address" maxlength="60" wrap="soft" class="form-control" placeholder="Address" class="span11">{{ old('Address') }} @if(!empty($memberdata->address)){{ $memberdata->address }} @endif</textarea>
            </div>
            <div class="form-group">
               <label>City</label>
               <input type="text" name="City" value="{{ old('City') }} @if(!empty($memberdata->city)){{ $memberdata->city }} @endif" maxlength="60" class="form-control" placeholder="City" class="span11" />
            </div>
            <div class="form-group">
               <label>Home Phone Number</label>
               <input type="text" name="HomePhoneNumber" class="form-control number" id="HomePhoneNumber" placeholder="Home Phone Number" minlength="10" maxlength="10" value="{{ old('HomePhoneNumber') }} @if(!empty($memberdata->homephonenumber)){{ $memberdata->homephonenumber }} @endif" class="span11" /> <span class="errmsg"></span>
            </div>
            <div class="form-group">
               <label>Office Phone Number</label>
               <input type="text" name="OfficePhoneNumber" class="form-control number" id="OfficePhoneNumber"  minlength="10" maxlength="10" class="span11" value="@if(!empty($memberdata->officephonenumber)){{ $memberdata->officephonenumber }} @endif {{ old('OfficePhoneNumber') }} " placeholder="Office Phone Number"/> <span class="errmsg"></span>
            </div>
            <!--/.accordion-content-->
      </article>
  
      <div id="alldata">
      <article class="content-entry">
      <h4 class="article-title"><i></i>Emergancy Contact Details </h4>
      <div class="accordion-content">
      <br/>
      <div class="well well-lg">
      <div class="form-group">
      <label>Emergancy Contact Name</label>
      <input type="text" name="emergancyname" value="{{ old('emergancyname') }} @if(!empty($memberdata->emergancyname)){{ $memberdata->emergancyname }} @endif " maxlength="60" class="form-control" placeholder="EmergancyName" class="span11" id="emergancyname" />
      </div>
      <div class="form-group">
      <label>Emergancy Contact Relation</label>
      <input type="text" name="emergancyrelation" value="{{ old('emergancyrelation') }} @if(!empty($memberdata->emergancyrelation)){{ $memberdata->emergancyrelation }} @endif " maxlength="60" class="form-control" placeholder="EmergancyRelation" class="span11" id="emergancyrelation"/>
      </div>
      <div class="form-group">
      <label>Emergancy Contact Address</label>
      <textarea rows="2" cols="20" name="emergancyaddress" maxlength="60" wrap="soft" class="form-control" placeholder="Emergancy Address" class="span11">{{ old('emergancyaddress') }} @if(!empty($memberdata->emergancyaddress)){{ $memberdata->emergancyaddress }} @endif</textarea>
      </div>
      <div class="form-group">
      <label>Emergancy Contact Number</label>
      <input type="text" name="EmergancyPhoneNumber" class="form-control number" placeholder="EmergancyPhoneNumber" value="{{ old('EmergancyPhoneNumber') }} @if(!empty($memberdata->emergancyphonenumber)){{ $memberdata->emergancyphonenumber }} @endif" id="EmergancyPhoneNumber" minlength="10" maxlength="10" class="span11" />&nbsp;<span class="errmsg"></span>
      </div>
      </div>
      <!--/.accordion-content-->
      </article>
      <article class="content-entry">
      <h4 class="article-title"><i></i>Medical Details</h4>
      <div class="accordion-content">
      <div class="well well-lg">
      <div class="form-group">
      <label>Blood group</label>
      <input type="text" maxlength="3" value="{{ old('bloodgroup') }} @if(!empty($memberdata->bloodgroup)){{ $memberdata->bloodgroup }} @endif" name="bloodgroup" class="form-control" class="span10" />
      </div>
      <div class="form-group">
      <label>Other Medical Details</label>
      <br>
      <label>A</label>
      <input type="text" maxlength="60" value="{{ old('SpecificGoalsa') }}" name="SpecificGoalsa" class="form-control" class="span10" />
      </div>
      <div class="form-group">
      <label>B</label>
      <input type="text" maxlength="60" value="{{ old('SpecificGoalsb') }}" name="SpecificGoalsb" class="form-control" class="span10" />
      </div>
      <div class="form-group">
      <label>C</label>
      <input type="text" maxlength="60" value="{{ old('SpecificGoalsc') }}" name="SpecificGoalsc" class="form-control" class="span10" />
      </div>
      </div>
      </div>
      </article>
      <article class="content-entry">
      <h4 class="article-title"><i></i>Other Information</h4>
      <div class="accordion-content">
      <br/>
      <div class="well well-lg">
      <div class="form-group">
      <label>Hear About..</label>
      <select class="form-control" name="HearAbout">
      <option disabled="" selected>--Select Any--</option>
      <option value="Fitness Five Member" @if(old( 'HearAbout')=='Fitness Five Member' ) selected @endif @if(!empty($memberdata->hearabout == ? )){{ $memberdata->hearabout == 'Fitness Five Member' ? 'selected' :'' }} @endif>Fitness Five Member</option>
      <option value="We Called Them" @if(old( 'HearAbout')=='We Called Them' ) selected @endif>We Called Them</option>
      <option value="Friends/Family" @if(old( 'HearAbout')=='Friends/Family' ) selected @endif>Friends/Family</option>
      <option value="Via Internet" @if(old( 'HearAbout')=='Via Internet' ) selected @endif>Via Internet</option>
      <option value="Word Of Mouth" @if(old( 'HearAbout')=='Word Of Mouth' ) selected @endif>Word Of Mouth</option>
      <option value="Radio Advertise" @if(old( 'HearAbout')=='Radio Advertise' ) selected @endif>Radio Advertise</option>
      <option value="Magazine Advertise" @if(old( 'HearAbout')=='Magazine Advertise' ) selected @endif>Magazine Advertise</option>
      <option value="Other" @if(old( 'HearAbout')=='Other' ) selected @endif>Other</option>
      </select>
      </div>
      <div class="form-group">
      <label>Profession</label>
      <input type="text" maxlength="60" value="{{ old('profession') }}" class="form-control" name="profession" placeholder="Profession" class="span11" />
      </div>
      <div class="form-group">
      <label>Birthdate</label>
      <input placeholder="Birthdate" value="{{ old('birthday') }}" type="date"  class="form-control" max="<?php echo date('Y-m-d');?>" name="birthday" class="span11">
      </div>
      <div class="form-group">
      <label>Anniversary</label>
      <input placeholder="Anniversary" value="{{ old('anniversary') }}" type="date" onkeypress="return false" class="form-control" max="<?php echo date('Y-m-d');?>" name="anniversary" class="span11">
      </div>
         <div class="form-group">
             <label>Are you coming from any company?</label>
             (if Yes than select)
            <select name="bycompany"type="text"class="form-control">
               <option disabled="" selected>--Select Any--</option>
              @foreach($company as $comp)

              <option value="{{$comp->companyid}}" >{{$comp->companyname}}</option>
              @endforeach
            </select>
               </div>
      </div>
      </div>
      <!--/.accordion-content-->
      </article>
      <!-- 
         <div class="row">
         -->
      <!--  <div class="col-md-8 col-sm-5">    
         <label for="happy">Have You Suffering From Heart Problem, High Blood Pressure, Diabetes Or Thyroid?</label>
         </div>  -->
      <!-- 
         <div class="col-md-4 col-sm-4">
           <div class="input-group">
             <div id="radioBtn" class="btn-group">
               <a class="btn btn-success btn-sm notActive showSingle" data-toggle="2"  data-title="Y" id="Problemyes" target="2">YES</a>
               <a class="btn btn-success btn-sm active showno" data-toggle="2" data-title="N"  id="Problemeno" target="2">NO</a>
             </div>
             <input type="hidden" name="2" id="2">
           </div>
         </div>
         </div><br/>
         
         <div class="row">
         <div id="div2" class="targetDiv">
         <textarea placeholder="Please Specify Your Problem..." rows="4" cols="50"></textarea>
         </div>
         </div><br/>
         
         
         
         <div class="row">
         
         <div class="col-md-8 col-sm-5">    
             <label for="happy">Have You Suffering From Fever Or Any Diseases ?</label>
         </div> 
         
         <div class="col-md-4 col-sm-4">
           <div class="input-group">
             <div id="radioBtn" class="btn-group">
               <a class="btn btn-success btn-sm notActive showSingle" data-toggle="3" target="3" data-title="Y">YES</a>
               <a class="btn btn-success btn-sm active showno" data-toggle="3" target="3" data-title="N">NO</a>
             </div>
             <input type="hidden" name="3" id="3">
           </div>
         </div>
         </div><br/>
         
         <div class="row">
         <div id="div3" class="targetDiv">
         <textarea placeholder="Please Specify Your Problem..." rows="4" cols="50"></textarea>
         </div>
         </div><br/>
         
         <div class="row">
         
         <div class="col-md-8 col-sm-5">    
             <label for="happy">Are You Taking Any Medicine ?</label>
         </div> 
         
         <div class="col-md-4 col-sm-4">
           <div class="input-group">
             <div id="radioBtn" class="btn-group">
               <a class="btn btn-success btn-sm notActive showSingle" data-toggle="4" target="4" data-title="Y">YES</a>
               <a class="btn btn-success btn-sm active showno" data-toggle="4" target="4" data-title="N">NO</a>
             </div>
             <input type="hidden" name="4" id="4">
           </div>
         </div>
         </div><br/>
         
         <div class="row">
         <div id="div4" class="targetDiv">
         <textarea placeholder="Please Specify Your Problem..." rows="4" cols="50"></textarea>
         </div>
         </div><br/>
         
         <div class="row">
         
         <div class="col-md-8 col-sm-5">    
             <label for="happy">Are You Suffering From Back Pain, Neck Pain,Knee Pain Or Any Other Orthopadedic Problems ?</label>
         </div> 
         
         <div class="col-md-4 col-sm-4">
           <div class="input-group">
             <div id="radioBtn" class="btn-group">
               <a class="btn btn-success btn-sm notActive showSingle" data-toggle="5" target="5" data-title="Y">YES</a>
               <a class="btn btn-success btn-sm active showno" data-toggle="5" target="5" data-title="N">NO</a>
             </div>
             <input type="hidden" name="5" id="5">
           </div>
         </div>
         </div><br/>
         
         <div class="row">
         <div id="div5" class="targetDiv">
         <textarea placeholder="Please Specify Your Problem..." rows="4" cols="50"></textarea>
         </div>
         </div><br/>
         
         <div class="row">
         
         <div class="col-md-8 col-sm-5">    
             <label for="happy">Are You OverWeight Or UnderWeight ?</label>
         </div> 
         
         <div class="col-md-4 col-sm-4">
           <div class="input-group">
             <div id="radioBtn" class="btn-group">
               <a class="btn btn-success btn-sm notActive" data-toggle="6"  data-title="Y">YES</a>
               <a class="btn btn-success btn-sm active" data-toggle="6" data-title="N">NO</a>
             </div>
             <input type="hidden" name="6" id="6">
           </div>
         </div>
         </div><br/>
         
         
         <div class="row">
         
         <div class="col-md-8 col-sm-5">    
             <label for="happy">Have You Gain Or Loss Weight In Last 3 Month ?</label>
         </div> 
         
         <div class="col-md-4 col-sm-4">
           <div class="input-group">
             <div id="radioBtn" class="btn-group">
               <a class="btn btn-success btn-sm notActive showSingle" data-toggle="7" target="7" data-title="Y">YES</a>
               <a class="btn btn-success btn-sm active showno" data-toggle="7" target="7" data-title="N">NO</a>
             </div>
             <input type="hidden" name="7" id="7">
           </div>
         </div>
         </div><br/>
         
         <div class="row">
         <div id="div7" class="targetDiv">
         <textarea placeholder="Please Specify Your Problem..." rows="4" cols="50"></textarea>
         </div>
         </div><br/>
         
         <div class="row">
         
         <div class="col-md-8 col-sm-5">    
             <label for="happy">Any member Of Your Family is OverWeight ?</label>
         </div> 
         
         <div class="col-md-4 col-sm-4">
           <div class="input-group">
             <div id="radioBtn" class="btn-group">
               <a class="btn btn-success btn-sm notActive" data-toggle="8"  data-title="Y">YES</a>
               <a class="btn btn-success btn-sm active" data-toggle="8" data-title="N">NO</a>
             </div>
             <input type="hidden" name="8" id="8">
           </div>
         </div>
         </div><br/>
         
         
         
         <div class="row">
         
         <div class="col-md-8 col-sm-5">    
             <label for="happy">Do You Smoke ?</label>
         </div> 
         
         <div class="col-md-4 col-sm-4">
           <div class="input-group">
             <div id="radioBtn" class="btn-group">
               <a class="btn btn-success btn-sm notActive" data-toggle="9"  data-title="Y">YES</a>
               <a class="btn btn-success btn-sm active" data-toggle="9" data-title="N">NO</a>
             </div>
             <input type="hidden" name="9" id="9">
           </div>
         </div>
         </div><br/>
         
         <div class="row">
         
         <div class="col-md-8 col-sm-5">    
             <label for="happy">Are You Tacking Tobacco Or Alcohol ?</label>
         </div> 
         
         <div class="col-md-4 col-sm-4">
           <div class="input-group">
             <div id="radioBtn" class="btn-group">
               <a class="btn btn-success btn-sm notActive" data-toggle="10"  data-title="Y">YES</a>
               <a class="btn btn-success btn-sm active" data-toggle="10" data-title="N">NO</a>
             </div>
             <input type="hidden" name="10" id="10">
           </div>
         </div>
         </div><br/>
         -->
      <!--  <div class="row">
         <h4><b><u>For Female</u></b></h4>
         </div><br/>
         
          <div class="row">
         
                <div class="col-md-8 col-sm-5">    
                     <label for="happy">Are You Pregnant ?</label>
                </div> 
         
                 <div class="col-md-4 col-sm-4">
                   <div class="input-group">
                     <div id="radioBtn" class="btn-group">
                       <a class="btn btn-success btn-sm notActive" data-toggle="11"  data-title="Y">YES</a>
                       <a class="btn btn-success btn-sm active" data-toggle="11" data-title="N">NO</a>
                     </div>
                     <input type="hidden" name="11" id="11">
                   </div>
               </div>
             </div><br/> -->
      <!--   <div class="row">
         <div class="col-md-8 col-sm-5">    
              <label for="happy">Have You Given Child Birth Since Last 6 Weeks ?</label>
         </div> 
         
          <div class="col-md-4 col-sm-4">
            <div class="input-group">
              <div id="radioBtn" class="btn-group">
                <a class="btn btn-success btn-sm notActive" data-toggle="12"  data-title="Y">YES</a>
                <a class="btn btn-success btn-sm active" data-toggle="12" data-title="N">NO</a>
              </div>
              <input type="hidden" name="12" id="12">
            </div>
         </div>
         </div><br/>
         
         <div class="row">
         
         <div class="col-md-8 col-sm-5">    
              <label for="happy">Are You Suffering From Thyroid, Pcod, Irreguler Menses Or Any Hormonal Issues ?</label>
         </div> 
         
          <div class="col-md-4 col-sm-4">
            <div class="input-group">
              <div id="radioBtn" class="btn-group">
                <a class="btn btn-success btn-sm notActive showSingle" data-toggle="13" target="13" data-title="Y">YES</a>
                <a class="btn btn-success btn-sm active showno" data-toggle="13" target="13" data-title="N">NO</a>
              </div>
              <input type="hidden" name="13" id="13">
            </div>
         </div>
         </div><br/>
         
         <div class="row">
         <div id="div13" class="targetDiv">
         <textarea placeholder="Please Specify Your Problem..." rows="4" cols="50"></textarea>
         </div> -->
      <!-- </div> -->
      <!-- </div -->
      <!-- 
         </div> -->
      <!--/.accordion-content-->
      <article class="content-entry">
      <h4 class="article-title"><i></i>Fitness Goals & Exercise Program</h4>
      <div class="accordion-content">
      <br/>
      <div class="well well-lg">
      <label>FitnessGoals</label>
      <table class="table" aria-describedby="example1_info">
      <tr>
      <td>
      <label>LoseBodyFat
      <input type="checkbox" name="fitnessgoals[]" class="badgebox" value="1"><span class="badge bg-orange">&check;</span>
      </label>
      </td>
      <td>
      <label>DevelopMuscle
      <input type="checkbox" name="fitnessgoals[]" class="badgebox" value="2"> <span class="badge bg-orange">&check;</span>
      </label>
      </td>
      </tr>
      <tr>
      <td>
      <label>ImproveBalance
      <input type="checkbox" name="fitnessgoals[]" class="badgebox" value="4"> <span class="badge bg-orange">&check;</span>
      </label>
      </td>
      <td>
      <label>RehabilitateAnInjury
      <input type="checkbox" name="fitnessgoals[]" class="badgebox" value="3"> <span class="badge bg-orange">&check;</span>
      </label>
      </td>
      </tr>
      <tr></tr>
      <td>
      <label>ImproveFlexibility
      <input type="checkbox" name="fitnessgoals[]" class="badgebox" value="5"> <span class="badge bg-orange">&check;</span>
      </label>
      </td>
      <td>
      <label>NutritionalEducation
      <input type="checkbox" name="fitnessgoals[]" class="badgebox" value="6"> <span class="badge bg-orange">&check;</span>
      </label>
      </td>
      </tr>
      <tr>
      <td>
      <label>DesignBeginnersProgram
      <input type="checkbox" name="fitnessgoals[]" class="badgebox" value="7"> <span class="badge bg-orange">&check;</span>
      </label>
      </td>
      <td>
      <label>DesignAdvancedProgram
      <input type="checkbox" name="fitnessgoals[]" class="badgebox" value="8"> <span class="badge bg-orange">&check;</span>
      </label>
      </td>
      </tr>
      <tr>
      <td>
      <label>TrainSpecific
      <input type="checkbox" name="fitnessgoals[]" class="badgebox" value="9"> <span class="badge bg-orange">&check;</span>
      </label>
      </td>
      <td>
      <label>Safety
      <input type="checkbox" name="fitnessgoals[]" class="badgebox" value="10"> <span class="badge bg-orange">&check;</span>
      </label>
      </td>
      </tr>
      <tr>
      <td>
      <label>MakeExerciseFun
      <input type="checkbox" name="fitnessgoals[]" class="badgebox" value="11"> <span class="badge bg-orange">&check;</span>
      </label>
      </td>
      <td>
      <label>Motivation
      <input type="checkbox" name="fitnessgoals[]" class="badgebox" value="12"> <span class="badge bg-orange">&check;</span>
      </label>
      </td>
      </tr>
      <tr>
      <td>
      <label>Other
      <input type="checkbox" name="fitnessgoals[]" class="badgebox" value="1"> <span class="badge bg-orange">&check;</span>
      </label>
      </td>
      <td>
      <textarea name="OtherHelp" placeholder="OtherHelp" class="span2"></textarea>
      </td>
      </tr>
      </table>
      <div class="form-group">
      <label>What activities interest you ?</label>
      <br>
      <table class="table table-bordered table-striped dataTable table-wrapper" role="grid" aria-describedby="example1_info">
      <tr>
      <td>
      <label>Baseball
      <input type="checkbox" name="exerciseprograms[]" class="badgebox" value="1"> <span class="badge bg-orange">&check;</span>
      </label>
      </td>
      <td>
      <label>Basketball
      <input type="checkbox" name="exerciseprograms[]" class="badgebox" value="2"> <span class="badge bg-orange">&check;</span>
      </label>
      </td>
      <td>
      <label>Boxing
      <input type="checkbox" name="exerciseprograms[]" class="badgebox" value="3"> <span class="badge bg-orange">&check;</span>
      </label>
      </td>
      </tr>
      <tr>
      <td>
      <label>KickBoxing
      <input type="checkbox" name="exerciseprograms[]" class="badgebox" value="4"> <span class="badge bg-orange">&check;</span>
      </label>
      </td>
      <td>
      <label>Skiing
      <input type="checkbox" name="exerciseprograms[]" class="badgebox" value="5"><span class="badge bg-orange">&check;</span> 
      </label>
      </td>
      <td>
      <label> <span class="checkmark"></span> Football
      <input type="checkbox" name="exerciseprograms[]" class="badgebox" value="6"> <span class="badge bg-orange">&check;</span>
      </label>
      </td>
      </tr>
      <tr>
      <td>
      <label>Golf
      <input type="checkbox" name="exerciseprograms[]" class="badgebox" value="7"> <span class="badge bg-orange">&check;</span>
      </label>
      </td>
      <td>
      <label>Hiking
      <input type="checkbox" name="exerciseprograms[]" class="badgebox" value="8"> <span class="badge bg-orange">&check;</span>
      </label>
      </td>
      <td>
      <label>Pilates
      <input type="checkbox" name="exerciseprograms[]" class="badgebox" value="9"> <span class="badge bg-orange">&check;</span>
      </label>
      </td>
      </tr>
      <tr>
      <td>
      <label>Racquetball
      <input type="checkbox" name="exerciseprograms[]" class="badgebox" value="10"> <span class="badge bg-orange">&check;</span>
      </label>
      </td>
      <td>
      <label>IndoorCycling
      <input type="checkbox" name="exerciseprograms[]" class="badgebox" value="11"> <span class="badge bg-orange">&check;</span>
      </label>
      </td>
      <td>
      <label>Kayaking
      <input type="checkbox" name="exerciseprograms[]" class="badgebox" value="12"> <span class="badge bg-orange">&check;</span>
      </label>
      </td>
      </tr>
      <tr>
      <td>
      <label>RockClimbing
      <input type="checkbox" name="exerciseprograms[]" class="badgebox" value="13"> <span class="badge bg-orange">&check;</span>
      </label>
      </td>
      <td>
      <label>Running
      <input type="checkbox" name="exerciseprograms[]" class="badgebox" value="14"> <span class="badge bg-orange">&check;</span>
      </label>
      </td>
      <td>
      <label>Soccer
      <input type="checkbox" name="exerciseprograms[]" class="badgebox" value="15"> <span class="badge bg-orange">&check;</span>
      </label>
      </td>
      </tr>
      <tr>
      <td>
      <label>Swimming
      <input type="checkbox" name="exerciseprograms[]" class="badgebox" value="16"> <span class="badge bg-orange">&check;</span>
      </label>
      </td>
      <td>
      <label>Tennis
      <input type="checkbox" name="exerciseprograms[]" class="badgebox" value="17"> <span class="badge bg-orange">&check;</span>
      </label>
      </td>
      <td>
      <label>Triathlon
      <input type="checkbox" name="exerciseprograms[]" class="badgebox" value="18"> <span class="badge bg-orange">&check;</span>
      </label>
      </td>
      </tr>
      <tr>
      <td>
      <label>Walking
      <input type="checkbox" name="exerciseprograms[]" class="badgebox" value="19"> <span class="badge bg-orange">&check;</span>
      </label>
      </td>
      <td>
      <label>WeightTrainning
      <input type="checkbox" name="exerciseprograms[]" class="badgebox" value="20"> <span class="badge bg-orange">&check;</span>
      </label>
      </td>
      <td>
      <label>Yoga
      <input type="checkbox" name="exerciseprograms[]" class="badgebox" value="21"> <span class="badge bg-orange">&check;</span>
      </label>
      </td>
      </tr>
      <tr>
      <td>
      <label>Stretching
      <input type="checkbox" name="exerciseprograms[]" class="badgebox" value="22"><span class="badge bg-orange">&check;</span>
      </label>
      </td>
      <td>
      <label>Other
      <input type="checkbox" name="exerciseprograms[]" class="badgebox" value="23"> <span class="badge bg-orange">&check;</span>
      </label>
      </td>
      <td>
      <textarea name="OtherActivity" placeholder="OtherActivity" class="span2"></textarea>
      </td>
      </tr>
      </table>
      </div>
      <div class="form-group">
      <label>How often a week whould you like to exercise ?</label>
      <input type="text" name="OftenWeekExercise" class="form-control number" placeholder="Often Week Exercise" class="span11" />
      </div>
      <div class="form-group">
      <label>Where do you rank in health in your life ?</label>
      <br>
      <label>
      <input type="radio" name="rank" value="h1">HighPriority</label>
      <label>
      <input type="radio" name="rank" value="m1">MediumPriority</label>
      <label>
      <input type="radio" name="rank" value="l1">LowPriority</label>
      </div>
      <div class="form-group">
      <label>How commited are you towards reaching your goals ?</label>
      <br>
      <label>
      <input type="radio" name="goal" value="v1">Very</label>
      <label>
      <input type="radio" name="goal" value="s1">Semi</label>
      <label>
      <input type="radio" name="goal" value="b1">Barely</label>
      </div>
      </div>
      </div>
      <!--/.accordion-content-->
      </article>
      <article class="content-entry">
      <h4 class="article-title"><i></i>Profile Photo</h4>
      <div class="accordion-content">
      <div class="well well-lg">
      <div class="form-group">
      <label>Photo</label>
      <input type="file" name="file" class="form-control" id="profileimage" accept="image/jpg, image/jpeg, image/png" class="span11" />
      <img src="" id="img" height="100px">
       <input type="hidden" name="base64image" class="image-tag">
         <div id="my_camera"></div>

 <input type=button class="btn bg-orange margin" value="Start Camera" onClick="configure()">
 <input type=button class="btn bg-orange margin" value="Capture" onClick="take_snapshot()">

 
 <div id="results"></div>

  <input type=button value="Save image" id="profileimagesave" class="btn bg-orange margin" onClick="saveSnap()" style="display: none;">
      </div>
      </div>
      </div>
      <!-- /.accordion-content -->
      </article>
      <article class="content-entry">
      <h4 class="article-title"><i></i>ID Proof</h4>
      <div class="accordion-content">
      <br/>
      <div class="well well-lg">
      <div class="field" align="left">
      <h3>ID Proofs </h3>
      <h5>(can attach more than one):</h5> 
      <input type="file" id="files" name="attachments[]" multiple />
      <ul id="fn"></ul> <i id="file"></i>
      </div>
      <br>
      <div class="form-group">
      <div class="col-sm-offset-3"></div>
      </div>
      </div>
      </div>
      <div class="col-sm-offset-4">
      <button type="submit" id="save_memberform" class="btn bg-orange margin">Save</button> <a href="{{ url('members') }}" class="btn bg-red margin">Cancel</a>
      </div>
      </div>
   </form>
   <script type="text/javascript">
var image='';
 // Configure a few settings and attach camera
 function configure(){
  Webcam.set({
   width: 320,
   height: 240,
   image_format: 'jpeg',
   jpeg_quality: 90
  });
  Webcam.attach( '#my_camera' );
 }
 // A button for taking snaps


 // preload shutter audio clip
 // var shutter = new Audio();
 // shutter.autoplay = false;
 // shutter.src = navigator.userAgent.match(/Firefox/) ? 'shutter.ogg' : 'shutter.mp3';

 function take_snapshot() {


  // take snapshot and get image data
  Webcam.snap( function(data_uri) {
  // display results in page
  document.getElementById('results').innerHTML = 
   '<img id="imageprev" src="'+data_uri+'" height="100px" width="100px"/>';

   image=data_uri;
    $("#profileimagesave").css('display','block');

  } );

  Webcam.reset();
 }

function saveSnap(data_uri){

   var base64image = document.getElementById("imageprev").src;
  // alert(base64image);
  $(".image-tag").val(base64image);
  // alert(image);


}
</script>
<script type="text/javascript">
   function ValidateForm(){

                                                                            
   ErrorText= "";
  
     if( $('#emergancyname').val() == "" ) {
       alert( "Please Provide Emergancy Name!" );
            $('#save_memberform').attr('disabled',false);
       return false;

    }
     if( $('#emergancyrelation').val() == "" ) {
       alert( "Please Provide Emergancy Relation!" );
        $('#save_memberform').attr('disabled',false);
       return false;
    }
      if( $('#EmergancyPhoneNumber').val() == "" ) {
       alert( "Please Provide Emergancy PhoneNumber!" );
        $('#save_memberform').attr('disabled',false);
       return false;
    }


   var fname = document.getElementById('firstname').value;
   if(!fname){
      alert ( "Please Enter Firstname" );
       $('#save_memberform').attr('disabled',false);
      return false; 
   }
   var fromt = document.getElementById('fromtime').value;
   if(!fromt){
       $('#save_memberform').attr('disabled',false);
      alert ( "Please Enter From Time" );
      return false; 
   }
   var tot = document.getElementById('totime').value;
   if(!tot){
      alert ( "Please Enter To Time" );
       $('#save_memberform').attr('disabled',false);
      return false; 
   }
   var lname = document.getElementById('lastname').value;
   if(!lname){
      alert ( "Please Enter LastName" );
       $('#save_memberform').attr('disabled',false);
      return false; 
   }
   var checked_gender = document.querySelector('input[name = "gender"]:checked');
      
      if(checked_gender != null){  //Test if something was checked
       //Alert the value of the checked.
      } else {
          $('#save_memberform').attr('disabled',false);
        alert('Please select gender'); 
      return false;//Alert, nothing was checked.
      }
      var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
      var email = document.getElementById('email').value;
      if (reg.test(email) == false) 
      {
        alert('Invalid Email Address');
         $('#save_memberform').attr('disabled',false);
        return false;
      }
      var len = document.getElementById('MobileNo').value;
      if(len.length < 10){

        alert ( "Please Enter valid Phone number" );
         $('#save_memberform').attr('disabled',false);
        return false; 
      }
      
      var lenh = document.getElementById('HomePhoneNumber').value;
      if(lenh){
        if(lenh.length < 10){
          alert ( "Please Enter valid Home Phone Number" );
           $('#save_memberform').attr('disabled',false);
          return false; 
        }
      }
      
      var leno = document.getElementById('OfficePhoneNumber').value;
      if(leno){
        if(leno.length < 10){
          alert ( "Please Enter valid Office Phone Number" );
           $('#save_memberform').attr('disabled',false);
          return false; 
        }
      }
      var lene = document.getElementById('EmergancyPhoneNumber').value;
  
      
        if(lene.length < 10){
          alert ( "Please Enter valid Emergancy Phone Number" );
           $('#save_memberform').attr('disabled',false);
          return false; 
      
      }

  $('#save_memberform').attr('disabled',true);
      
      if (ErrorText= "") { return true; }
      }
   </script>
   <!--/.accordion-content
      </article>-->
   <!-- 
      <article class="content-entry">
          <h4 class="article-title"><i></i>Vitals</h4>
          <div class="accordion-content">
              <div class="well well-lg">
      
                <div class="row">
                  <div class="col-md-6">
                    <div class="col-md-3"><label>RHR</label></div>
                     <div class="col-md-6"><input type="number" name="" class="form-control" ></div>
                  </div>
                  <div class="col-md-6">
                    <div class="col-md-3"><label>MHR</label></div>
                     <div class="col-md-6"><input type="number" name="" class="form-control"></div>
                  </div>
                </div><br/>
      
                <div class="row">
                  <div class="col-md-6">
                    <div class="col-md-3"><label>HRR</label></div>
                     <div class="col-md-6"><input type="number" name="" class="form-control" ></div>
                  </div>
                  <div class="col-md-6">
                    <div class="col-md-3"><label>RBP</label></div>
                     <div class="col-md-6"><input type="number" name="" class="form-control"></div>
                  </div>
                </div>
      
      
              </div>
          </div>
          /.accordion-content-->
   <!-- </article> -->
   <!--      <article class="content-entry">
      <h4 class="article-title"><i></i>Body Details</h4>
      <div class="accordion-content"><br/>
         <div class="well well-lg">
          <div>
          <div class="row">
            <h4><b><u>Body Composition :</u></b></h4>
          </div><br/>
      
             <div class="row">
              <div class="col-md-6">
                <div class="col-md-3"><label>Height</label></div>
                 <div class="col-md-6"><input type="number" name="" min="1" class="form-control" placeholder="Height"></div>
              </div>
              <div class="col-md-6">
                <div class="col-md-3"><label>Body Fat %</label></div>
                 <div class="col-md-6"><input type="number" name="" min="1" class="form-control" placeholder="Body Fat %"></div>
              </div>
            </div>
      
              <div class="row">
              <div class="col-md-6">
                <div class="col-md-3"><label>Weight</label></div>
                 <div class="col-md-6"><input type="number" name="" min="1" class="form-control" placeholder="Weight"></div>
              </div>
              <div class="col-md-6">
                <div class="col-md-3"><label>VISC Fat %</label></div>
                 <div class="col-md-6"><input type="number" name="" min="1" class="form-control" placeholder="VISC Fat %"></div>
              </div>
            </div>
      
              <div class="row">
              <div class="col-md-6">
                <div class="col-md-3"><label>BMI</label></div>
                 <div class="col-md-6"><input type="number" name="" min="1" class="form-control" placeholder="BMI" ></div>
              </div>
              <div class="col-md-6">
                <div class="col-md-3"><label>BMR</label></div>
                 <div class="col-md-6"><input type="number" name="" min="1" class="form-control" placeholder="BMR"></div>
              </div>
            </div>
      
            <div class="row">
            <h4><b><u>Body Circumference :</u></b></h4>
          </div><br/>
      
             <div class="row">
               <div class="col-md-6"><label>Upper Arm </label></div>
               <div class="col-md-3"><input type="number" name="" placeholder="Left Upper Arm" min="1" class="form-control"></div>
                <div class="col-md-3"><input type="number" name="" placeholder="Right Upper Arm" min="1" class="form-control"></div>
             </div><br/>
      
             <div class="row">
               <div class="col-md-6"><label>Chest</label></div>
                <div class="col-md-6"><input type="number" name="" class="form-control" placeholder="Chest"></div>
             </div><br/>
      
          <div class="row" >
              <div class="col-md-6">
              <label>Waist</label>
              </div>
              <div class="col-md-6">
              <select class="form-control">
                <option> -- Select --</option>
                <option value="">ATUMBI</option>
                <option value="">A/V 3 CM</option>
                <option value="">A/V 5 CM</option>
                <option value="">B/W 3 CM</option>
                <option value="">B/W 5 CM</option>
              </select>
              </div>
          </div><br/>
      
           <div class="row">
               <div class="col-md-6"><label>Hips</label></div>
                <div class="col-md-6"><input type="number" name="" min="1" class="form-control" placeholder="Hips" ></div>
             </div><br/>
      
             <div class="row">
               <div class="col-md-6"><label>Thigh</label></div>
               <div class="col-md-3"><input type="number" name="" min="1" placeholder="Left Thigh" class="form-control"></div>
                <div class="col-md-3"><input type="number" name=""  min="1" placeholder="Right Thigh" class="form-control"></div>
             </div><br/>
      
             <div class="row">
            <h4><b><u>Strength Test:</u></b></h4>
          </div><br/>
      
          <div class="row">
            <div class="col-md-6"><label>Bench Press</label></div>
            <div class="col-md-6"><input type="number" min="1" name="" class="form-control" placeholder="Bench Press"></div>
          </div><br/>
      
          <div class="row">
            <div class="col-md-6"><label>Squat</label></div>
            <div class="col-md-6"><input type="number" name="" min="1" class="form-control" placeholder="Squat"></div>
          </div><br/>
      
          <div class="row">
            <div class="col-md-6"><label>O/H Press</label></div>
            <div class="col-md-6"><input type="number" name="" min="1" class="form-control" placeholder="O/H Press"></div>
          </div><br/>
      
            <div class="row">
            <h4><b><u>Strength Endurance Test:</u></b></h4>
          </div><br/>
      
          <div class="row">
            <div class="col-md-6"><label>Push UPS</label></div>
            <div class="col-md-6"><input type="number" name="" min="1" class="form-control" placeholder="Push UPS"></div>
          </div><br/>
      
          <div class="row">
            <div class="col-md-6"><label>Crul UPS</label></div>
            <div class="col-md-6"><input type="number" name="" min="1" class="form-control" placeholder="Crul UPS"></div>
          </div><br/>
      
          <div class="row">
            <div class="col-md-6"><label>Plank Hold</label></div>
            <div class="col-md-6"><input type="number" name="" min="1" class="form-control" placeholder="Plank Hold"></div>
          </div><br/>
      
            <div class="row">
            <h4><b><u>Flexibility :</u></b></h4>
          </div><br/>
      
          <div class="row">
            <div class="col-md-6"><label>Sitand Reach</label></div>
            <div class="col-md-6"><input type="number" name="" min="1" class="form-control" placeholder="Sitand Reach"></div>
          </div><br/>
      
          <div class="row">
            <div class="col-md-6"><label>Mobility</label></div>
            <div class="col-md-6"><input type="number" name="" min="1" class="form-control" placeholder="Mobility"></div>
          </div><br/>
      
          <div class="row">
            <div class="col-md-6"><label>Other</label></div>
            <div class="col-md-6"><input type="number" name="" min="1" class="form-control" placeholder="Other"></div>
          </div><br/>
         </div>
      </div>
      <!--/.accordion-content-->
   <!--      </article> -->
   <!-- <article class="content-entry"> -->
   <!-- <h4 class="article-title"><i></i>Static Postural Assessment</h4>
      <div class="accordion-content">
        <div class="row"> -->
   <!--   <form method="get">
      <div class="form-group">  
      <div class="col-md-2 box"><label class="btn btn-primary"><img src="http://content.nike.com/content/dam/one-nike/globalAssets/menu_header_images/OneNike_Global_Nav_Icons_Running.png" alt="..." class="img-thumbnail img-check"><input type="radio" name="chk1" id="item4" value="val1" class="hidden" autocomplete="off"></label></div>
      <div class="col-md-2 box"><label class="btn btn-primary"><img src="http://content.nike.com/content/dam/one-nike/globalAssets/menu_header_images/OneNike_Global_Nav_Icons_Basketball.png" alt="..." class="img-thumbnail img-check"><input type="radio" name="chk1" id="item4" value="val2" class="hidden" autocomplete="off"></label></div>
      <div class="col-md-2 box"><label class="btn btn-primary"><img src="http://content.nike.com/content/dam/one-nike/globalAssets/menu_header_images/OneNike_Global_Nav_Icons_Football.png" alt="..." class="img-thumbnail img-check"><input type="radio" name="chk1" id="item4" value="val3" class="hidden" autocomplete="off"></label></div>
      <div class="col-md-2 box"><label class="btn btn-primary"><img src="http://content.nike.com/content/dam/one-nike/globalAssets/menu_header_images/OneNike_Global_Nav_Icons_Soccer.png" alt="..." class="img-thumbnail img-check"><input type="radio" name="chk1" id="item4" value="val4" class="hidden" autocomplete="off"></label></div>
      <div class="col-md-2 box"><label class="btn btn-primary"><img src="http://content.nike.com/content/dam/one-nike/globalAssets/menu_header_images/OneNike_Global_Nav_Icons_Soccer.png" alt="..." class="img-thumbnail img-check"><input type="radio" name="chk1" id="item4" value="val4" class="hidden" autocomplete="off"></label></div>
      </div>
      <div class="clearfix"></div>
      
      
      
      </form> -->
   <!--  </div>
      </div>
      /.accordion-content
      </article> -->
   <!-- article class="content-entry">
      <h4 class="article-title"><i></i>Dynamic Postural Assessment</h4>
      <div class="accordion-content">
          <p>Accordion content 4</p>
        </div> -->
   <!--/.accordion-content
      </article> -->
   <!-- </div> -->
   <!--/#accordion-->
</section>
<!--/#content-->
<script type="text/javascript">
   $(function(){
                 $('#profileimage').change(function(){

                   var input = this;
                   var url = $(this).val();
                   var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
                   if (input.files && input.files[0]&& (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg")) 
                   {
                     var reader = new FileReader();
   
                     reader.onload = function (e) {
                      $('#img').attr('src', e.target.result);
                    }
                    reader.readAsDataURL(input.files[0]);
                  }
                  else
                  {
                   $('#img').attr('src', '/assets/no_preview.png');
                 }
               });
   
               });
               $(function() {
                 var Accordion = function(el, multiple) {
                   this.el = el || {};
                   this.multiple = multiple || false;
   
                   var links = this.el.find('.article-title');
                   links.on('click', {
                     el: this.el,
                     multiple: this.multiple
                   }, this.dropdown)
                 }
   
                 Accordion.prototype.dropdown = function(e) {
                   var $el = e.data.el;
                   $this = $(this),
                   $next = $this.next();
   
                   $next.slideToggle();
                   $this.parent().toggleClass('open');
   
                   if (!e.data.multiple) {
                     $el.find('.accordion-content').not($next).slideUp().parent().removeClass('open');
                   };
                 }
                 var accordion = new Accordion($('.accordion-container'), false);
               });
   
               $('#radioBtn a').on('click', function(){
                 var sel = $(this).data('title');
                 var tog = $(this).data('toggle');
                 $('#'+tog).prop('value', sel);
   
                 $('a[data-toggle="'+tog+'"]').not('[data-title="'+sel+'"]').removeClass('notActive').addClass('notnotActive');
                 $('a[data-toggle="'+tog+'"][data-title="'+sel+'"]').removeClass('notnotActive').addClass('notActive');
               });
</script>
<script type="text/javascript">
   $("#div1,#div2,#div3,#div4,#div5,#div7,#div13").hide();
   
               jQuery('.showSingle').click(function(){
                 // jQuery('.targetDiv').hide();
                 jQuery('#div'+$(this).attr('target')).hide(500);
                 
               });
               jQuery('.showno').click(function(){
   
                 jQuery('#div'+$(this).attr('target')).show(500);
               });
   
   
               $('.img-check').click(function(e) {
                 $('.img-check').not(this).removeClass('check')
                 .siblings('input').prop('checked',false);
                 $(this).addClass('check')
                 .siblings('input').prop('checked',true);
               });
</script>
<!-- left column -->
<style type="text/css">
input[type="file"] {
display: block;
}
.imageThumb {
max-height: 75px;
border: 2px solid;
padding: 1px;
cursor: pointer;
}
.pip {
display: inline-block;
margin: 10px 10px 0 0;
}
.remove {
display: block;
background: #444;
border: 1px solid black;
color: white;
text-align: center;
cursor: pointer;
}
.remove:hover {
background: white;
color: black;
}
</style>
<!--  </div>
   </div>-->
<!-- /.box-body -->
<!-- </form>  
   </div>
   </div>
   <div class="modal fade" id="modal-default" style="display: none">
           <div class="modal-dialog">
             <div class="modal-content">
               <div class="modal-header">
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                   <span aria-hidden="true">&times;</span></button>
                 <h4 class="modal-title">Default Modal</h4>
               </div>
               <div class="modal-body">
                 <p>One fine body&hellip;</p>
               </div>
               <div class="modal-footer">
                 <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                 <button type="button" class="btn btn-primary">Save changes</button>
               </div>
             </div>-->
<!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
</div>
</section>
<script type="text/javascript">
   $('#membersave').on('click',function(){
             $('#otp').css("display", "block");
           });
</script>
<script type="text/javascript">
   $('#submit').on('click',function() {
             var FinalAmount = $('#FinalAmount').val();
             var total = $('#total').val();
             if(FinalAmount == total)
              return true;
            else
             $("#modal-default").css("display", "block");
   
           return false;
         });
</script>
<script>
   // we used jQuery 'keyup' to trigger the computation as the user type
   $('.price').keyup(function () {
   
       // initialize the sum (total price) to zero
       var sum = 0;
   
       // we use jQuery each() to loop through all the textbox with 'price' class
       // and compute the sum for each loop
       $('.price').each(function() {
         sum += Number($(this).val());
       });
   
       // set the computed value to 'totalPrice' textbox
       $('#total').val(sum);
   
     });
</script>
<script type="text/javascript">
   $('#MobileNo').on('keyup',function(){
      var error_usermobile = '';
      var usermobile = $('#MobileNo').val();
      var _token = $('input[name="_token"]').val();
   
      $.ajax({
       url:"{{ route('MemberController.checkmobile') }}",
       method:"POST",
       data:{usermobile:usermobile, _token:_token},
       success:function(result)
       {
        if(result == 'unique')
        {
         $('#error_usermobile').html('<label class="text-success"></label>');
         $('#MobileNo').removeClass('has-error');
         
       }
       else
       {
           // alert("hi1");
           $('#error_usermobile').html('<label class="text-danger">Mobile number is Already exist</label>');
           $('#MobileNo').addClass('has-error');
   
         }
       }
     })
    });
</script>
<script type="text/javascript">
   $('#firstbtn').on('click',function(){
     var username = $('#username').val();
       // alert(username);
       var mobileno = $('#MobileNo').val();
       var _token = $('input[name="_token"]').val();
       // alert("hi");
       $.ajax({
         url:"{{ route('createuser') }}",
         method:"POST",
         data:{username:username, mobileno:mobileno, _token:_token},
         success:function(result) 
         {
           // alert(result);
           $('#selectusername').append('<option selected="selected" value="'+result+'">'+$('#username').val()+'</option>');
           $('#selectmoblieno').append('<option selected="selected" value="'+$('#MobileNo').val()+'">'+$('#MobileNo').val()+'</option>');
           // alert("hi1");
           $('#firststep').hide();
           $('#secondstep').show();
         },
         // dataType:"json"
       })
     });
</script>
<script type="text/javascript">
   $(document).ready(function() {
       if (window.File && window.FileList && window.FileReader) {
         $("#files").on("change", function(e) {
          var fileName = $(this).parent().children("strong").text();
          var files = e.target.files,
          filesLength = files.length;
          
   
          for (var i = 0; i < filesLength; i++) {
           var f = files[i];
           var filename1 = f.name;
           var fileReader = new FileReader();
           fileReader.onload = (function(e) {
             var file = e.target;
          // alert(file);
   
          $("<span class=\"pip\">" +
           "<img class=\"imageThumb\" src=\"" + e.target.result + "\" title=\"" + f.name + "\"/>" +
           "<br/><span class=\"remove\">Remove image</span>" +
           "</span>").insertAfter("#files");
   
          $(".remove").click(function(){
           $(this).parent(".pip").remove();
   
             // alert(e.target.result);
             // $('#files').val(e.target.result);
   
           });
   
             // Old code here
             /*$("<img></img>", {
               class: "imageThumb",
               src: e.target.result,
               title: file.name + " | Click to remove"
             }).insertAfter("#files").click(function(){$(this).remove();});*/
             
           });
           // $('#fn').append('<br><li>'+filename1+'</li>');
           fileReader.readAsDataURL(f);
         }
       });
       } else {
         alert("Your browser doesn't support to File API")
       }
     });
</script>
<script type="text/javascript">
   $('input[type="checkbox"]').on('change',function(){
      // event.preventDefault();
     // var searchIDs = $('input[type="checkbox"]').map(function(){     return $(this).val();    }).get(); // <----
        // $next = $('input[type="checkbox"]').next('td').find('[type=text]');
        //  $next.attr('required','required');
        var x= true;
        $('input[type="checkbox"]').map(function(){
         if($(this).prop("checked") == true){
           var y=  $(this).closest('tr').find('[type=text]').val();
           $(this).closest('tr').find('[type=text]').prop("disabled", false).attr('required','');
           if (y == "")
           {
             alert("kindly enter values of selected PaymentType !");
             x= false;
           }
         }
         else if($(this).prop("checked") == false){
   
         }
       });
             //alert(x);
             if (x == false)
              return false;
            else
             return true;
         });
</script>
<script type="text/javascript">
   $('#rootscheme').on('change',function(){
           $('#scheme').find('option:not(:first)').remove();
     // $('#scheme').find('option').remove();
     var name=document.getElementById("rootscheme").value;
     var _token = $('input[name="_token"]').val();
     if(name)
     {
      $.ajax({
       url:"{{ route('scheme') }}",
       method:"POST",
       data:{name:name, _token:_token},
       success:function(result)
       {
         var data=result;
         $.each(data, function(i,item){
                     // $('#scheme').append('<option value="'+item.id+'">'+item.SchemeName+'</option>');
                     $('#scheme').append($("<option></option>").attr("value",item.id).text(item.SchemeName));
   
                   })
       },
       dataType:"json"
     })
    }
   });
         $("#fromtime").on("change", function(){
          var from=$("#fromtime").prop('selectedIndex');
            // alert(from);
            $('#totime option').eq(from).prop('selected', true);
          });
         $("#totime").on("change", function(){
          var to=$("#totime").prop('selectedIndex');
            // alert(from);
            $('#fromtime option').eq(to).prop('selected', true);
          });
         $(".number").keypress(function (e) {
        //if the letter is not digit then display error and don't type anything
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
           //display error message
           $(this).find('.errmsg').html("Digits Only are allowed gbghbdfhbdbdfgbdfgfv").show().fadeOut("slow");
           return false;
         }
       });
         $('#scheme').on('change',function(){
          $('#MembershipAmount').val('');
   
     // $('#scheme').find('option').remove();
     var name = document.getElementById("scheme").value;
     var _token = $('input[name="_token"]').val();
     if(name)
     {
      $.ajax({
       url:"{{ route('schemeActualPrice') }}",
       method:"POST",
       data:{name:name, _token:_token},
       success:function(result)
       {
         var data=result;
         $.each(data, function(i,item){
   
   
          $('#MembershipAmount').attr("value",item.id).val(item.ActualPrice);
          $('#BasePrice').attr("value",item.id).val(item.BasePrice);
          $('#FinalAmount').attr("value",item.id).val(item.ActualPrice);
        })
   
       },
       dataType:"json"
     })
    }
   });
</script>
<script type="text/javascript">
   $('#firstname').on('keyup',function(){
       var  first = document.getElementById("firstname").value;
       var  second = document.getElementById("lastname").value;
       $( "#username" ).trigger( "keyup" );
       $('#username').val(first+""+second);
       var error_username = '';
       var username = $('#username').val();
       var _token = $('input[name="_token"]').val();
   
       $.ajax({
         url:"{{ route('MemberController.check') }}",
         method:"POST",
         data:{username:username, _token:_token},
         success:function(result)
         {
          if(result == 'unique')
          {
           $('#error_username').html('<label class="text-success">User Name is Valid</label>');
           $('#username').removeClass('has-error');
           $('#firstbtn').attr('disabled', false);
         }
         else
         {
           // alert("hi1");
           $('#error_username').html('<label class="text-danger">User Name is Already Exist</label>');
           $('#username').addClass('has-error');
           $('#firstbtn').attr('disabled', 'disabled');
         }
       }
     })
     });
     $('#lastname').on('keyup',function(){
   
       var  first = document.getElementById("firstname").value;
       var  second = document.getElementById("lastname").value;
       $( "#username" ).trigger( "keyup" );
   
       $('#username').val(first+""+second);
       var error_username = '';
       var username = $('#username').val();
       var _token = $('input[name="_token"]').val();
   
       $.ajax({
         url:"{{ route('MemberController.check') }}",
         method:"POST",
         data:{username:username, _token:_token},
         success:function(result)
         {
          if(result == 'unique')
          {
           $('#error_username').html('<label class="text-success">User Name is Valid</label>');
           $('#username').removeClass('has-error');
           $('#firstbtn').attr('disabled', false);
         }
         else
         {
           // alert("hi1");
           $('#error_username').html('<label class="text-danger">User Name is Already Exist</label>');
           $('#username').addClass('has-error');
           $('#firstbtn').attr('disabled', 'disabled');
         }
       }
     })
     });
</script>
<script type="text/javascript">
   $('#username').on('keyup',function(){
         // alert("hi");
         var error_username = '';
         var username = $('#username').val();
         var _token = $('input[name="_token"]').val();
   
         $.ajax({
           url:"{{ route('MemberController.check') }}",
           method:"POST",
           data:{username:username, _token:_token},
           success:function(result)
           {
            if(result == 'unique')
            {
             $('#error_username').html('<label class="text-success">User Name is Valid</label>');
             $('#username').removeClass('has-error');
             $('#firstbtn').attr('disabled', false);
           }
           else
           {
           // alert("hi1");
           $('#error_username').html('<label class="text-danger">User Name is Already Exist</label>');
           $('#username').addClass('has-error');
           $('#firstbtn').attr('disabled', 'disabled');
         }
       }
     })
       });
</script>@endsection @push('script')
<script type="text/javascript">
   $(document).ready(function(){
         $('#member_form').validate({
           rules: {
             firstname : {
               required : true,
               maxlength : 60
             },
             lastname : {
               required : true,
               maxlength : 60
             },
             username : {
               required : true,
               maxlength : 60
             },
             email : {
               required : true,
               maxlength : 60,
               email : true
             },
           }
         });
       });
 /* $('#member_form').on('submit',function(){
  });*/

</script>@endpush