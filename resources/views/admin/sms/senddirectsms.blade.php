@extends('layouts.adminLayout.admin_design')

@push('css')
<style type="text/css">
  .help-block{
    color: red;
  }
  .error{
    color: red;
  }

  .container {
  display: block;
  position: relative;
  padding-left: 35px;
  margin-bottom: 18px;
  margin-top: 20px;
  cursor: pointer;
  font-size: 15px;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
}

/* Hide the browser's default checkbox */
.container input {
  position: absolute;
  opacity: 0;
  cursor: pointer;
  height: 0;
  width: 0;
}

/* Create a custom checkbox */
.checkmark {
  position: absolute;
  top: 0;
  left: 0;
  height: 25px;
  width: 25px;
  background-color: #F6C968;
}

/* On mouse-over, add a grey background color */
.container:hover input ~ .checkmark {
  background-color: #F5B01B;
}

/* When the checkbox is checked, add a blue background */
.container input:checked ~ .checkmark {
  background-color: #F5B01B;
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

/* Style the checkmark/indicator */
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
.pointer {
  cursor: pointer;
}
.tagcolor{
  background-color: #DF9A04;
  color: #fff;
}
.tagcolor:hover{
  color: #fff;
}
li {
    list-style-type: none;
}
</style>
@endpush
@section('content')

<script type="text/javascript">
   $(document).ready(function(){
    $('#example2').DataTable();
   });
</script>
<!-- left column -->
  <div class="content-wrapper">
   
     
         <section class="content-header"><!-- <h2>Add Notification</h2> --></section>
          <!-- general form elements -->
           <section class="content">
          
             @if ($msg = Session::get('msg'))
<div class="alert alert-success alert-block" id="#success-alert">
 <button type="button" class="close" data-dismiss="alert">×</button>
       <strong class="whitetext">{{ $msg }}</strong>
</div>
@endif
@if ($errors->any())
<div class="alert alert-danger">
  <button type="button" class="close" data-dismiss="alert">×</button>
  <ul>
     @foreach ($errors->all() as $error)
     <li>{{ $error }}</li>
     @endforeach
  </ul>
</div>
@endif

            

            <script type="text/javascript">
              $(".alert-danger").fadeTo(2000, 500).slideUp(500, function(){
              $(".alert-danger").slideUp(500);
                });

              $(".alert-success").fadeTo(2000, 500).slideUp(500, function(){
              $(".alert-success").slideUp(500);
                });
           </script>

            <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Direct Message</h3>
                </div>

                <div class="box-body">

                  <div class="row">
                <form action="{{url('directmessage')}}" method="post">
                    {{ csrf_field() }}
                    <div class="col-lg-6 col-lg-offset-1">
                        <div class="form-group">
                          <label>Mobileno</label>
                          <input type="text" name="mobileno" class="number form-control" placeholder="Enter Mobile No" maxlength="10">
                        </div>
                      </div>

                      <!-- <div class="col-lg-6">
                        <select name="messagestemplate" id="messagestemplatename"  class="form-control selectpicker"title="Select Member" data-live-search="true" data-selected-text-format="count"  data-actions-box="true" data-count-selected-text="{0} User Name Selected" data-header="Select Notification Template"><option selected disabled=""> Please choose an Template </option>
                          @foreach($messagetemp as $m)
                          <option value="{{ $m->messagesid }}">{{ ($m->subject) }}</option>
                          @endforeach
                          </select>
                          <input type="hidden" name="msgid" id="msgid">
                      </div> -->
                    </div>

                    <div class="mt-2 col-lg-12" style="padding: 10px;"></div>

                  <div class="row">
                    <div class="form-group">

                      <div class="col-lg-10 col-lg-offset-1">
                         <label>Message</label><br>
                        <span id="rchars">250</span> Character(s) Remaining
                        <textarea class="form-control" rows="5" name="textareasms" id="textareasms" maxlength="250" style="resize: none;" placeholder="Enter Your Message Here..!"></textarea>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="mt-2 col-lg-12" style="padding: 10px;"></div>

                <!-- <div class="row">
                  <div class="col-lg-6 col-lg-offset-1">
                        <div class="col-lg-3">
                          <div class="smstag pointer btn tagcolor"><b>[FirstName]</b></div>
                        </div>
                       <div class="col-lg-3">
                         <div class="smstag pointer btn tagcolor"><b>[LastName]</b></div>
                       </div>
                  </div>
                </div> -->

                <div class="row">
                  <div class="form-group">
                    <div class="mt-2 col-lg-12" style="padding: 10px;"></div>
                           <div class="row">
                            <center>
                                    <button class="btn bg-orange btn margin " id="sendsmsuser">Send</button>
                                 
                                  
                                    <a class="btn btn-danger btn margin" id="clear">Clear</a>
                                 </center>
                                </div>
                   <!--    <div class="row">
                        <div class="col-lg-8 col-lg-offset-3">
                          <div class="col-lg-3">
                            <button class="btn btn margin bg-orange" id="sendsmsuser">send</button>
                        
                          </div>
                          <div class="col-lg-3">
 
                            <a class="btn btn margin bg-red" id="clear">Clear</a>
                          </div>
                        </div>
                      </div> -->
                  </div>
                </div>
                </form>
              </div>
      </div>
    </div>
  </section>
</div>
@endsection
@push('script')
<script type="text/javascript">

   $('#sendsmsuser').prop('disabled', true);
   $('#msgclear').prop('disabled', true);
   // $('#msgclear').hide();

  $('#messagestemplatename').change(function(){ 

    // alert($('#messagestemplatename').val());
      $('#sendsmsuser').prop('disabled', false);
      $('#msgclear').prop('disabled', false);

    $.ajax({
        url : '{{url("getsmsdata")}}',
        typle: 'get',
        data : {_token:'{{ csrf_token() }}',msgid:$('#messagestemplatename').val()},
        success : function(data){
          // alert(data.message);

          $('#textareasms').html(data.message);
          $('#msgid').val(data.messagesid);
        },
         dataType:'json',
    });
  });

  var maxLength = 250;
        $('#textareasms').keyup(function() {
          var textlen = maxLength - $(this).val().length;
          $('#rchars').text(textlen);
          if ($('#textareasms').val().length > 0) {
             $('#sendsmsuser').prop('disabled', false);
          }else{
            $('#sendsmsuser').prop('disabled', true);
          }
        });

  $('#msgclear').click(function(){

        $('#textareasms').val(null);
        $('#sendsmsuser').prop('disabled', true);
    });

  $('#clear').click(function(){
    window.location.reload();
  });
</script>                   
@endpush