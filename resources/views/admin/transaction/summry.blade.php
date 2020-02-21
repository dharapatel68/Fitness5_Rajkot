

<style type="text/css">
  

a:focus {
  outline: none !important;
}

a:hover {
  text-decoration: none;
}

/*---------------------------------------------*/
h1,h2,h3,h4,h5,h6 {
  margin: 0px;
}



ul, li {
  margin: 0px;
  list-style-type: none;
}


/*---------------------------------------------*/
input {
  outline: none;
  border: none;
}

input[type="number"] {
    -moz-appearance: textfield;
    appearance: none;
    -webkit-appearance: none;
}

input[type="number"]::-webkit-outer-spin-button,
input[type="number"]::-webkit-inner-spin-button {
    -webkit-appearance: none;
}

textarea {
  outline: none;
  border: none;
}

textarea:focus, input:focus {
  border-color: transparent !important;
}

input:focus::-webkit-input-placeholder { color:transparent; }
input:focus:-moz-placeholder { color:transparent; }
input:focus::-moz-placeholder { color:transparent; }
input:focus:-ms-input-placeholder { color:transparent; }

textarea:focus::-webkit-input-placeholder { color:transparent; }
textarea:focus:-moz-placeholder { color:transparent; }
textarea:focus::-moz-placeholder { color:transparent; }
textarea:focus:-ms-input-placeholder { color:transparent; }

input::-webkit-input-placeholder {color: #999999;}
input:-moz-placeholder {color: #999999;}
input::-moz-placeholder {color: #999999;}
input:-ms-input-placeholder {color: #999999;}

textarea::-webkit-input-placeholder {color: #999999;}
textarea:-moz-placeholder {color: #999999;}
textarea::-moz-placeholder {color: #999999;}
textarea:-ms-input-placeholder {color: #999999;}

/*---------------------------------------------*/
button {
  outline: none !important;
  border: none;
  background: transparent;
}

button:hover {
  cursor: pointer;
}

iframe {
  border: none !important;
}

.green{
  color: green;
}

.red{
   color: red;
}
/*//////////////////////////////////////////////////////////////////
[ Contact ]*/

.container-contact100 {
  width: 100%;  
  min-height: 100vh;
  display: -webkit-box;
  display: -webkit-flex;
  display: -moz-box;
  display: -ms-flexbox;
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
  align-items: center;
  padding: 15px;
  background: transparent;
  position: relative;
  z-index: 1;
}

.contact100-map {
  position: absolute;
  z-index: -2;
  width: 100%;
  height: 100%;
  top: 0;
  left: 0;
}

.wrap-contact100 {
  width: 670px;
  background: #fff;
  border-radius: 10px;
  overflow: hidden;
  position: relative;
}

/*==================================================================
[ Title form ]*/
.contact100-form-title {
  width: 100%;
  position: relative;
  z-index: 1;
  display: -webkit-box;
  display: -webkit-flex;
  display: -moz-box;
  display: -ms-flexbox;
  display: flex;
  flex-wrap: wrap;
  flex-direction: column;
  align-items: center;

  background-repeat: no-repeat;
  background-size: cover;
  background-position: center;

  padding: 64px 15px 64px 15px;
}

.contact100-form-title-1 {
  font-family: Poppins-Bold;
  font-size: 20px;
  color: #fff;
  line-height: 1.2;
  text-align: center;
  padding-bottom: 7px;
}

.contact100-form-title-2 {
  font-family: Poppins-Regular;
  font-size: 15px;
  color: #fff;
  line-height: 1.5;
  text-align: center;
}


.contact100-form-title::before {
  content: "";
  display: block;
  position: absolute;
  z-index: -1;
  width: 100%;
  height: 100%;
  top: 0;
  left: 0;
  background-color: rgba(54,84,99,0.7);
}


/*==================================================================
[ Form ]*/

.contact100-form {
  width: 100%;
  display: -webkit-box;
  display: -webkit-flex;
  display: -moz-box;
  display: -ms-flexbox;
  display: flex;
  flex-wrap: wrap;
  justify-content: space-between;
  padding: 43px 88px 57px 190px;
}


/*------------------------------------------------------------------
[ Input ]*/

.wrap-input100 {
  width: 100%;
  position: relative;
  border-bottom: 1px solid #b2b2b2;
  margin-bottom: 26px;
}

.label-input100 {
  font-family: Poppins-Regular;
  font-size: 15px;
  color: #808080;
  line-height: 1.2;
  text-align: right;

  position: absolute;
  top: 14px;
  left: -105px;
  width: 80px;

}

/*---------------------------------------------*/
.input100 {
  font-family: Poppins-Regular;
  font-size: 15px;
  color: #555555;
  line-height: 1.2;

  display: block;
  width: 100%;
  background: transparent;
  padding: 0 5px;
}

.focus-input100 {
  position: absolute;
  display: block;
  width: 100%;
  height: 100%;
  top: 0;
  left: 0;
  pointer-events: none;
}

.focus-input100::before {
  content: "";
  display: block;
  position: absolute;
  bottom: -1px;
  left: 0;
  width: 0;
  height: 1px;

  -webkit-transition: all 0.6s;
  -o-transition: all 0.6s;
  -moz-transition: all 0.6s;
  transition: all 0.6s;

  background: #57b846;
}


/*---------------------------------------------*/
input.input100 {
  height: 45px;
}


textarea.input100 {
  min-height: 115px;
  padding-top: 14px;
  padding-bottom: 13px;
}


.input100:focus + .focus-input100::before {
  width: 100%;
}

.has-val.input100 + .focus-input100::before {
  width: 100%;
}


/*------------------------------------------------------------------
[ Button ]*/
.container-contact100-form-btn {
  width: 100%;
  display: -webkit-box;
  display: -webkit-flex;
  display: -moz-box;
  display: -ms-flexbox;
  display: flex;
  flex-wrap: wrap;
  /*padding-top: 8px;*/
}

.contact100-form-btn {
  display: -webkit-box;
  display: -webkit-flex;
  display: -moz-box;
  display: -ms-flexbox;
  display: flex;
  justify-content: center;
  align-items: center;
  padding: 0 20px;
  min-width: 160px;
  height: 50px;
  background-color: #57b846;
  border-radius: 25px;

  font-family: Poppins-Regular;
  font-size: 16px;
  color: #fff;
  line-height: 1.2;

  -webkit-transition: all 0.4s;
  -o-transition: all 0.4s;
  -moz-transition: all 0.4s;
  transition: all 0.4s;
}

.contact100-form-btn i {
  -webkit-transition: all 0.4s;
  -o-transition: all 0.4s;
  -moz-transition: all 0.4s;
  transition: all 0.4s;
}

.contact100-form-btn:hover {
  background-color: #333333;
}

.contact100-form-btn:hover i {
  -webkit-transform: translateX(10px);
  -moz-transform: translateX(10px);
  -ms-transform: translateX(10px);
  -o-transform: translateX(10px);
  transform: translateX(10px);
}


/*------------------------------------------------------------------
[ Responsive ]*/

@media (max-width: 576px) {
  .contact100-form {
    padding: 43px 15px 57px 117px;
  }
}

@media (max-width: 480px) {
  .contact100-form {
    padding: 43px 15px 57px 15px;
  }

  .label-input100 {
    text-align: left;
    position: unset;
    top: unset;
    left: unset;
    width: 100%;
    padding: 0 5px;
  }
}


/*------------------------------------------------------------------
[ Alert validate ]*/

.validate-input {
  position: relative;
}

.alert-validate::before {
  content: attr(data-validate);
  position: absolute;
  max-width: 70%;
  background-color: #fff;
  border: 1px solid #c80000;
  border-radius: 2px;
  padding: 4px 25px 4px 10px;
  top: 50%;
  -webkit-transform: translateY(-50%);
  -moz-transform: translateY(-50%);
  -ms-transform: translateY(-50%);
  -o-transform: translateY(-50%);
  transform: translateY(-50%);
  right: 2px;
  pointer-events: none;

  font-family: Poppins-Medium;
  color: #c80000;
  font-size: 13px;
  line-height: 1.4;
  text-align: left;

  visibility: hidden;
  opacity: 0;

  -webkit-transition: opacity 0.4s;
  -o-transition: opacity 0.4s;
  -moz-transition: opacity 0.4s;
  transition: opacity 0.4s;
}

.alert-validate::after {
  content: "\f06a";
  font-family: FontAwesome;
  display: block;
  position: absolute;
  color: #c80000;
  font-size: 15px;
  top: 50%;
  -webkit-transform: translateY(-50%);
  -moz-transform: translateY(-50%);
  -ms-transform: translateY(-50%);
  -o-transform: translateY(-50%);
  transform: translateY(-50%);
  right: 8px;
}

.alert-validate:hover:before {
  visibility: visible;
  opacity: 1;
}

@media (max-width: 992px) {
  .alert-validate::before {
    visibility: visible;
    opacity: 1;
  }
}



</style>
@extends('layouts.adminLayout.admin_design')
@section('content')
  <div class="content-wrapper">
   @if($errors->any())
   <h4>{{$errors->first()}}</h4>
   @endif
   <!-- <section class="content-header"><h2>Summary </h2></section> -->
   <!-- general form elements -->
   <section class="content container-contact100">
      <div class="wrap-contact100">
         <!-- style="background-image: url(/images/Fitness5-logo.jpg);" -->
         </span>
         <div class="col-lg-8">
            <section class="content-header"><center>
               <h3>Payment Summary</h3></center>
            </section>
         </div>
         <table class="table">
            <thead>
               <tr>
                  <td>Full name</td>
                  <td>{{$summry['fullname']}}</td>
               </tr>
               <tr>
                  <td>Package</td>
                  <td>{{$summry['package']}}</td>
               </tr>
               <tr>
                  <td>Starting Date</td>
                  <td>{{ date('d-m-Y', strtotime($summry['joindate'])) }}</td>
               </tr>
               <tr>
                  <td>Expire Date</td>
                  <td>{{ date('d-m-Y', strtotime($summry['enddate'])) }}</td>
               </tr>
               <tr>
                  <td>Amount</td>
                  <td>{{$summry['amount']}}</td>
               </tr>
               <tr>
                  <td>InvoiceID</td>
                  <td>M{{$summry['InvoiceID']}}</td>
               </tr>
               <tr>
                  <td>Transaction Type</td>
                  <td>{{$summry['TransactionType']}}</td>
               </tr>
               <?php
                  $due_date = !empty($summry['duedate']) ?  date('d-m-Y', strtotime($summry['duedate'])) : null;
                  ?>
               <tr>
                  <td>Due Date</td>
                  <td>{{ $due_date }}</td>
               </tr>
               <tr>
                  <td>Due Amount</td>
                  <td>{{ $summry['dueamnt'] }}</td>
               </tr>
           
            
            </thead>
            <tbody>
              <tr>
                <td  style="text-align: left;"><a id="smsafterpack"  class="green"><i class="fa fa-commenting"></i> Send SMS</a></td>
                <td  style="text-align: left;"><a id="emailafterpack" class="red margin"><i class="fa fa-envelope-o" aria-hidden="true"></i> Send Email</a>
                @if($summry['rootschemeid'])
                @if($summry['rootschemeid'] == 2)
                <a href="{{ url('/personaltrainer/assignmembertotrainer/'.$summry['memberid']) }}" 
                style="color: #8200ff;float:right"> <img src="{{ asset('images/icon/pt.png') }}" style="height: 18px; width: 18px;margin-left: -3px;">&nbsp;&nbsp;Assign Member To PT</a> 
                @endif
              @endif
                </td>
              </tr>
               <tr>
                  <td  style="text-align: left;"><a href="{{url('transactionpaymentreceipt/'.$summry['InvoiceID'].'/'.$summry['mobileno'])}}" target="_blank"><b style="font-size: 20px;">Download Print  <i class="fa fa-print" style="size: 20px;"></i></b></a></td>
                  <td  style="text-align: left;"><a href="{{url('dashboard')}}"><b style="font-size: 20px;"> Dashboard  <i class="fa fa-tachometer" style="size: 20px;"></i></b></a></td>
               </tr>
               <tr>
                  <td colspan="2" style="text-align: center;display: none;" id="expiry_set"><button class="btn btn-success">Expiry Set</button></td>
               </tr>
               <tr>
                  <td colspan="2" style="text-align: center;display: none;" id="expiry_not_set"><button class="btn btn-danger">Expiry Not Set</button></td>
               </tr>
               <tr>
                  <td colspan="2" style="text-align: center;">
                     <a href="{{url('enrolldevicecomman/'.$summry['userid'] )}}" id="enrolluserfromsummary">
                        <b class="btn bg-orange" style="font-size: 17px;">
                           Enroll In Device  <!-- <i class="fa fa-print" style="size: 20px;"></i> -->
                        </b>
                     </a>
                  </td>
               </tr>
               <tr>
                  <td colspan="2" style="text-align: center;">
                     <a class="btn bg-danger" id="usernotset" style="font-size: 15px;">User Not Set Into Device</a>
                  </td>
               </tr>
            </tbody>
         </table>
      </div>
</div>
</section>
</div>
<button type="button" id="modal" class="btn btn-primary " data-toggle="modal" data-target="#exampleModal" style="display:none;">
  Msg modal
 </button>
 <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog" role="document">
     <div class="modal-content">
       <div class="modal-header">
         <h5 class="modal-title" id="exampleModalLabel">Are you sure want to send this SMS ? </h5>
         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
           <span aria-hidden="true">&times;</span>
         </button>
       </div>
       <div class="modal-body">
       <div class="msg">{{ $summry['msg']}}</div>
       </div>
       <div class="modal-footer">
         <button type="button" class="btn bg-orange hide" data-dismiss="modal">No</button>
         <button type="button" id="sendsmsyes" class="btn bg-orange">Yes</button>
       </div>
     </div>
   </div>
 </div>
@php 
 $msg = urlencode($summry['msg']);
 $mobileno = $summry['mobileno'];
@endphp
<script Language="javascript">

  /*window.onbeforeunload = function(e) {
    return 'Please press the Logout button to logout.';
  };*/

    function printfile(no) {
      
        //window.frames['objAdobePrint'+no].focus();
          window.frames['objAdobePrint'+no].print();
        
    }

    // function disableF5(e) { if ((e.which || e.keyCode) == 116 || (e.which || e.keyCode) == 82) e.preventDefault(); };

// $(document).ready(function(){
//      $(document).on("keydown", disableF5);
// });



$(document).ready(function(){
  var msg = '<?php echo $msg ?>';
    if(msg){
      $('#modal').trigger('click');
    }
    //  $(document).on("keydown", disableF5);
   
});


$('#sendsmsyes').on('click',function(){
  var mobileno = '<?php echo $mobileno ;?>';
  var msg='<?php echo $msg ; ?>';
  $.ajax({
    url:"{{ url('remianingamount/sendsmsyes') }}",
    method:"POST",
    data:{mobileno:mobileno,msg:msg,"_token": "{{ csrf_token() }}"},
    success: function (response) {
      },
    dataType:"json"
  });
  $('#exampleModal').modal('hide');
});


 $(document).bind("contextmenu",function(e){
      return false;
   });



/*<script type="text/javascript">
  $(document).ready(function() {
  alert('dddddddd');

  let userid = {{$summry['userid']}};
  let joindate = {{$summry['joindate']}};
  let enddate = {{$summry['enddate']}};
  let username = {{$summry['fullname']}};

  alert('hbjkl');

  $.ajax({

      url : "{{route('setuserfromsummary')}}",
      type: "POST",
      data : {_token:"{{csrf_token()}}",userid:userid,joindate:joindate,enddate:enddate,username:username},
      success : function(data){
        alert(data);
        console.log('aaaaaa');
      },
  });
});

   alert(userid);*/
</script> 
<script type="text/javascript">
  $('#smsafterpack').on('click',function(){
    var invoiceid=<?php echo $summry['InvoiceID']; ?>;
    var userid=<?php echo $summry['userid']; ?>;
    $.ajax({
        url : "{{url('smsafterpack')}}",
        type: "POST",
        data : {_token:"{{csrf_token()}}",invoiceid:invoiceid,userid:userid},
        success : function(data){
           var result=data; 
         if(result == 'true'){
          alert('SMS SuccessFully Send');
         }
        },
    });
  });
   $('#emailafterpack').on('click',function(){
    var invoiceid=<?php echo $summry['InvoiceID']; ?>;
    var userid=<?php echo $summry['userid']; ?>;

    $.ajax({
        url : "{{url('emailafterpack')}}",
        type: "POST",
        data : {_token:"{{csrf_token()}}",invoiceid:invoiceid,userid:userid},
        success : function(data){
        
         if(data == 'true'){
          alert('SMS SuccessFully Send');
         }
        },
    });
  });
</script>
@endsection