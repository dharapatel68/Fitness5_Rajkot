<?php 
 include('..///config/database.php');
 include('..///config/session.php');
?>

@extends('layouts.adminLayout.admin_design')
@section('content')
<!-- left column -->
<!-- <link rel="stylesheet" href="../../bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css"> -->
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
 <style type="text/css">
   .table-bordered {
    border: 1px solid #f4f4f4;
}
 </style>
 <script type="text/javascript" src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0/jquery.js"></script>
<script data-require="datatables@*" data-semver="1.10.12" src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.13/js/dataTables.bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.1.0/js/dataTables.responsive.js"></script> -->
  <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script> -->
  <style type="text/css">
    .customcheck {
    display: block;
    position: relative;
    padding-left: 35px;
    margin-bottom: 12px;
    cursor: pointer;
    font-size: 22px;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
}

/* Hide the browser's default checkbox */
.customcheck input {
    position: absolute;
    opacity: 0;
    cursor: pointer;
}

/* Create a custom checkbox */
.checkmark {
    position: absolute;
    top: 0;
    left: 0;
    height: 25px;
    width: 25px;
    background-color: #babbba;
    border-radius: 5px;
}

/* On mouse-over, add a grey background color */
.customcheck:hover input ~ .checkmark {
    background-color: #ccc;
}

/* When the checkbox is checked, add a blue background */
.customcheck input:checked ~ .checkmark {
    background-color: #00c0ef;
    border-radius: 5px;
}

/* Create the checkmark/indicator (hidden when not checked) */
.checkmark:after {
    content: "";
    position: absolute;
    display: none;
}

/* Show the checkmark when checked */
.customcheck input:checked ~ .checkmark:after {
    /*display: block;*/
    content: "";
    color: #20b904;
}

/* Style the checkmark/indicator */
.customcheck .checkmark:after {
    left: 9px;
    top: 5px;
    width: 5px;
    height: 10px;
    border: solid white;
    border-width: 0 3px 3px 0;
    -webkit-transform: rotate(45deg);
    -ms-transform: rotate(45deg);
    transform: rotate(45deg);
  </style>
  <div class="content-wrapper">
   
     
         <section class="content-header"><h2>Member Session</h2></section>
          <!-- general form elements -->
           <section class="content">
          
              @if ($errors->any())
            <div class="alert alert-danger">
            <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
            </ul>
            </div>
            @endif
            <div class="box box-primary">

            <div class="box-header with-border">
              <h3 class="box-title">Manage Member</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <form role="form" action="{{ URL::route('manageassignedmember') }}" method="post"  >
                 {{ csrf_field() }}
                <!-- text input -->
                <div class="col-md-3">
                <div class="form-group">
                  <label>Trainer</label>
                  <?php if(Session::get('role')=="admin"){ ?>
                  <select name="trainerid" class="form-control selectpicker" id="trainerid" title="Select Trainer" data-live-search="true" data-selected-text-format="count"  data-actions-box="true" data-count-selected-text="{0} Trainer Selected" data-header="Select Trainer" required>
                    @foreach ($employees as $employee)
                      <option value="{{$employee->employeeid}}" <?php if(isset($trainerid) && $trainerid==$employee->employeeid){ echo 'selected'; }?>>{{$employee->username}}</option>
                    @endforeach
                  </select>
                <?php }else{ ?>
                  <input type="text" name="trainername" class="form-control" value="{{$trainername}}" readonly>
                  <input type="hidden" name="trainerid" value="{{$trainerid}}">
                <?php } ?>
                </div>
              </div>

                <div class="col-md-3">
                <div class="form-group">
                  <label>Member</label>
                   <select name="memberid" class="form-control" id="memberid" title="Select Memeber"  >
                    <option value="">--Select Member--</option>
                    @foreach ($members as $member)
                      <option value="{{$member->memberid}}" <?php if(isset($memberid) && $memberid==$member->memberid){ echo 'selected'; }?>>{{$member->firstname .' '. $member->lastname}}</option>
                    @endforeach
                   
                    
                  </select>
                </div>
              </div>
              <div class="col-md-3">
                  <div class="form-group">
                  <label>Mobile No.</label>
                  <input type="text" class="form-control" placeholder="Mobile No." name="mobileno" id="mobileno" readonly>
                  <!-- </select> -->
                </div>
              </div>
                <script type="text/javascript">
                  $('#memberid').change(function(){
                       var member = $('#memberid').val();
                    // alert(member);
                 

                              $.ajax({
                                   url:"{{ URL::route('assignptmembermobileno') }}",
                                   method:"GET",
                                   data:{"_token": "{{ csrf_token() }}","memberid":member},
                                  success:function(data) {
                                    // alert(data);
                                      
                                      // $('#mobile_no').fadeIn().html(data);
                                     
                                     // $('#mobile_no').html('<option value="'+data+'">'+data+'</option>');
                                     // alert($('#mobileno').val());
                                     $('#mobileno').val(data);
                                  },

                              });
                          
                              // $('select[name="mobile_no"]').fadeIn();
                 });
                  $(document).ready(function(){
                    var member = $('#memberid').val();
                    // alert(member);
                              $.ajax({
                                   url:"{{ URL::route('assignptmembermobileno') }}",
                                   method:"GET",
                                   data:{"_token": "{{ csrf_token() }}","memberid":member},
                                  success:function(data) {
                                    // alert(data);
                                      
                                      // $('#mobile_no').fadeIn().html(data);
                                     
                                     // $('#mobile_no').html('<option value="'+data+'">'+data+'</option>');
                                     // alert($('#mobileno').val());
                                     $('#mobileno').val(data);
                                  },

                              });
                  });
                </script>
                <div class="col-md-3">
                <div class="form-group">
                  <label>Package</label>
                   <select name="packageid" class="form-control" id="packageid" title="Select Package" data-live-search="true" >
                    <option value="">--Select Member Package--</option>
                  </select>
                </div>
              </div>
                <script type="text/javascript">
                  $('#memberid').change(function(){
                      $('#pthour').val('');
                       $('#packageid').find('option:not(:first)').remove();
                       var member = $('#memberid').val();
                    // alert(member);
                 

                              $.ajax({
                                   url:"{{ URL::route('assignptmemberpackage') }}",
                                   method:"GET",
                                   data:{"_token": "{{ csrf_token() }}","memberid":member,'type':'package','schemeid':''},
                                   async:false,
                                  success:function(data) {
                                    // alert(data);
                                      $.each(data, function(i, item){
                                      
                                        $("#packageid").append($("<option></option>").attr("value", item.memberpackagesid).text(item.schemename));

                                      });
                                  },
                                  dataType:'json',

                              });
                          
                              // $('select[name="mobile_no"]').fadeIn();
                 });
                  $(document).ready(function(){
                    $('#pthour').val('');
                       $('#packageid').find('option:not(:first)').remove();
                       var member = $('#memberid').val();
                    // alert($('#memberid').val());
                 

                              $.ajax({
                                   url:"{{ URL::route('assignptmemberpackage') }}",
                                   method:"GET",
                                   data:{"_token": "{{ csrf_token() }}","memberid":member,'type':'package','schemeid':''},
                                   async:false,
                                  success:function(data) {
                                    // alert(data);
                                      $.each(data, function(i, item){

                                        html="<option"; 
                                          if(item.memberpackagesid=="<?php if(isset($packageid)){echo $packageid;} ?>")
                                          {
                                            html+=" selected";
                                          }
                                        html+="></option>";
                                      
                                        $("#packageid").append($(html).attr("value", item.memberpackagesid).text(item.schemename));

                                      });
                                  },
                                  dataType:'json',

                              });
                  });
                </script>
                 <div class="col-md-3">
                <div class="form-group">
                  <label>Training Hours</label>
                  <input type="text" class="form-control" placeholder="Trainer Hours" name="pthour" id="pthour" readonly>
                </div>
              </div>
                <!-- <div class="form-group">
                  <label>From Date</label>
                  <input type="date" onkeypress="return false" class="form-control" name="date" value="<?php echo date('Y-m-d');?>" id="date">
                </div> -->
                 <script type="text/javascript">
                  $('#packageid').change(function(){

                       var member = $('#memberid').val();
                    // alert(member);
                 
                              $.ajax({
                                   url:"{{ URL::route('assignptmemberpackage') }}",
                                   method:"GET",
                                   data:{"_token": "{{ csrf_token() }}","memberid":'','type':'pthour','schemeid':$('#packageid').val()},
                                  success:function(data) {
                                    // swal(data,"Successfully",'success');
                                    $('#pthour').val(data);

                                  },

                              });
                          
                              // $('select[name="mobile_no"]').fadeIn();
                 });
                $(document).ready(function(){
                  var member = $('#memberid').val();
                    // alert(member);
                 

                              $.ajax({
                                   url:"{{ URL::route('assignptmemberpackage') }}",
                                   method:"GET",
                                   data:{"_token": "{{ csrf_token() }}","memberid":'','type':'pthour','schemeid':$('#packageid').val()},
                                  success:function(data) {
                                    // swal(data,"Successfully",'success');
                                    $('#pthour').val(data);

                                  },

                              });
                });
                </script>
               <div class="form-group">
                    <button name="view" type="submit" id="view" class="btn bg-green margin" style="margin-top: 25px">View</button>   <a href="{{ URL::route('manageassignedmember') }}"class="btn btn-danger margin" style="margin-top: 25px">Cancel</a>
                
                </div>
                <!-- Select multiple-->
        

              </form></div>
          <div style="overflow: auto;">
             <table id="example1" class="table table-bordered table-striped dataTable dt-responsive"  width="100%">
               <thead>
                <tr>
                  <th colspan="2"><center>Schedule</center></th>
                  <!-- <th></th> -->
                  <th colspan="2"><center>Actual</center></th>
                  <th colspan="2"></th>
                </tr>
                <tr>
                  <th style="display: none;"></th>
                  <th>Schedule Date</th>
                  <th>Schedule Time</th>
                 <!--  <th>Day</th> -->
                  <th>Actual Date</th>
                  <th>Actual Time</th>
                  <th>Trainee</th>
                  <th>Status</th>
               </tr>
               </thead>
               <tbody>
                @foreach($grid as $i => $data)
                @if($data->hoursfrom!='')
                    <tr>
                      <td style="display: none;"></td>
                      @if($data->status=='Conducted')
                      <?php 
                        $claimptsession=DB::table('claimptsession')->where(['trainerid'=>$data->trainerid,'memberid'=>$data->memberid,'scheduledate'=>$data->date])->get();
                      ?>
                       <td>{{date('d-m-Y',strtotime($data->date))}}</td>
                      <td id="2td{{$i}}"> {{$data->hoursfrom}} </td>
                      
                      <!-- <td>{{$data->day}}</td> -->
                      <td>{{$claimptsession[0]->actualdate}}</td>
                      <td>{{$claimptsession[0]->actualtime}}</td>
                      <td id="3td{{$i}}"> {{$data->username}}</td>
                      <td>
                        <input type="hidden" name="mid{{$i}}" id="mid{{$i}}" value="{{$data->ptmemberid}}">
                        <form role="form" id="myform" action="{{ URL::route('claimptsession') }}" method="post"  >
                         {{ csrf_field() }}
                         <input type="hidden" name="ptmemberid" value="{{$data->ptmemberid}}">
                          <label style="color: green">Claimed</label>
                        </form>
                      </td>
                      @endif
                      @if($data->status=='Pending')
                        <?php 
                        $claimptsession=DB::table('claimptsession')->where(['trainerid'=>$data->trainerid,'memberid'=>$data->memberid,'scheduledate'=>$data->date])->get();
                      ?>
                      <td>{{date('d-m-Y',strtotime($data->date))}}</td>
                      <td id="2td{{$i}}"> {{$data->hoursfrom}} </td>
                      <!-- <td>{{$data->day}}</td> -->
                      <td>{{$claimptsession[0]->actualdate}}</td>
                      <td>{{$claimptsession[0]->actualtime}}</td>
                      <td id="3td{{$i}}"> {{$data->username}}</td>
                      <td>
                        <input type="hidden" name="mid{{$i}}" id="mid{{$i}}" value="{{$data->ptmemberid}}">
                        <form role="form" id="myform" action="{{ URL::route('claimptsession') }}" method="post"  >
                         {{ csrf_field() }}
                         <input type="hidden" name="ptmemberid{{$i}}" id="ptmemberid{{$i}}" value="{{$data->ptmemberid}}">
                        <a data-toggle="modal" data-target="#pinmodal" id="pin{{$i}}" data-placement="top" onclick="getrow({{$i}})" title="PIN"> <label style="color: red"> Enter PIN</label></a>
                        </form>
                      </td>
                      @endif
                      @if($data->status=='Active')
                      <td>{{date('d-m-Y',strtotime($data->date))}}</td>
                      <td id="2td{{$i}}">
                        {{$data->hoursfrom}}
                        <!-- <select name="time{{$i}}" class="form-control" id="time{{$i}}" disabled="">
                          
                          <option value="06:00" @if($data->hoursfrom=='06:00'){{'selected'}}@endif>06:00</option>
                          <option value="07:00" @if($data->hoursfrom=='07:00'){{'selected'}}@endif>07:00</option>
                          <option value="08:00" @if($data->hoursfrom=='08:00'){{'selected'}}@endif>08:00</option>
                          <option value="09:00" @if($data->hoursfrom=='09:00'){{'selected'}}@endif>09:00</option>
                          <option value="10:00" @if($data->hoursfrom=='10:00'){{'selected'}}@endif>10:00</option>
                          <option value="11:00" @if($data->hoursfrom=='11:00'){{'selected'}}@endif>11:00</option>
                          <option value="12:00" @if($data->hoursfrom=='12:00'){{'selected'}}@endif>12:00</option>
                          <option value="13:00" @if($data->hoursfrom=='13:00'){{'selected'}}@endif>13:00</option>
                          <option value="14:00" @if($data->hoursfrom=='14:00'){{'selected'}}@endif>14:00</option>
                          <option value="15:00" @if($data->hoursfrom=='15:00'){{'selected'}}@endif>15:00</option>
                          <option value="16:00" @if($data->hoursfrom=='16:00'){{'selected'}}@endif>16:00</option>
                          <option value="17:00" @if($data->hoursfrom=='17:00'){{'selected'}}@endif>17:00</option>
                          <option value="18:00" @if($data->hoursfrom=='18:00'){{'selected'}}@endif>18:00</option>
                          <option value="19:00" @if($data->hoursfrom=='19:00'){{'selected'}}@endif>19:00</option>
                          <option value="20:00" @if($data->hoursfrom=='20:00'){{'selected'}}@endif>20:00</option>
                          <option value="21:00" @if($data->hoursfrom=='21:00'){{'selected'}}@endif>21:00</option>
                          <option value="22:00" @if($data->hoursfrom=='22:00'){{'selected'}}@endif>22:00</option>
                          <option value="23:00" @if($data->hoursfrom=='23:00'){{'selected'}}@endif>23:00</option>
                        </select> --></td>
                      <!-- <td>{{$data->day}}</td> -->
                      <td></td>
                      <td></td>
                      <td id="3td{{$i}}"> 
                        {{$data->username}}
                      </td>
                      <td>
                        <input type="hidden" name="mid{{$i}}" id="mid{{$i}}" value="{{$data->ptmemberid}}">
                        <form role="form" id="myform" action="{{ URL::route('claimptsession') }}" method="post"  >
                         {{ csrf_field() }}
                         <input type="hidden" name="ptmemberid" value="{{$data->ptmemberid}}">
                        <!--  <a data-toggle="tooltip" onclick="listenForDoubleClickedit({{$i}}) " id="edit{{$i}}" data-placement="top" title="Edit" class="btn-bx edit"><i class=" glyphicon glyphicon-edit"></i></a> -->
                         <a data-toggle="tooltip" onclick="listenForDoubleClickok({{$i}}) " id="ok{{$i}}" data-placement="top" title="Submit" class="btn-bx" style="display: none;"><i class=" glyphicon glyphicon-ok"></i></a>
                         <!--  <a data-toggle="tooltip" id="a{{$i}}" value="{{$i}}" onclick="hidea(this)" style="color:green" data-placement="top" title="Claim" onclick="document.getElementById('myform').submit()" class=""><i class=" glyphicon glyphicon-list"></i></a> -->
                        </form>
                      </td>

                      @endif

                    </tr>
                    @endif
                @endforeach
                 
               </tbody>
             </table>
           </div>

            </div>
            <!-- /.box-body -->
          </div>
                 
  </section>
  <script type="text/javascript">
    function getrow(i) {
      // alert(element);
     var ptmemberid= $('#ptmemberid'+i).val();
     $('#ptid').val(ptmemberid);
      // $('#2td16').contentEditable = true;
    }
  </script>
  <div class="modal fade" id="pinmodal" tabindex="-1" role="dialog" aria-labelledby="titleymodalLabel" aria-hidden="true">'
      <div class="modal-dialog modal-md">

        <div class="modal-content">
            
            <div class="modal-header">
                
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                
                <h4 class="modal-title" id="Label">PTP For Session <l id="ld"></l> <l id="lt" ></l></h4>
            
            </div>
            
            <div class="modal-body" style="display:none; text-align:center" id="bagtypemodalprogress">
                
                <img src="./img/progress.gif" alt="Loading..." />
            
            </div>

            <div id="modalalert" class="alert alert-danger alert-dismissable" style="display:none">
                    
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    
                    Incorrect PIN.
                
                </div>
            
            <div class="modal-body" id="trainermodalcontent"> 
              <div class="row">
              <div class="col-sm-8">
              <div class="col-sm-offset-3">
                <label>Enter PIN</label>
                <input type="hidden" name="ptid" id="ptid" class="form-control" value="">
                <input type="text" name="ptp" id="ptp" class="form-control" value="">
              </div>
            </div> 
            </div>
            
            </div>
            
            
            <div class="modal-footer">

                <button type="button" id="close" class="btn btn-danger" data-dismiss="modal">Close</button>
                
                <button name="checkptp" id="checkptp" type="button" class="btn btn-success">Save</button>
            
            </div>
</div>
    
    </div>
    

</div>
<script type="text/javascript">
  $('#checkptp').click(function(){
    $.ajax({
          url:"{{ URL::route('claimptsession') }}",
          method:"GET",
           data:{"_token": "{{ csrf_token() }}","ptid":$('#ptid').val(),"memberid":$('#memberid').val(),"ptp":$('#ptp').val()},
          success:function(data) {
            // alert(data);
            if(data!="error")
            {
              $('#view').trigger('click');
            }
            else
            {
              $('#modalalert').show();
              $('#ptp').val('');

            }
          },
          dataType:'json',

          });
  });
</script>

<script type="text/javascript">
  $('#trainerid').on('change',function(){


  var trainerid=$('#trainerid').val();
  $.ajax({
          url:"{{ url('gettrainermember') }}",
          method:"GET",
           data:{"_token": "{{ csrf_token() }}","trainerid":trainerid},
          success:function(data) {

            if(data)
            {
              $('#memberid').find('option:not(:first)').remove();
             $.each(data, function(i, item){
                $("#memberid").append($("<option></option>").attr("value", item.memberid).text(item.firstname+' '+item.lastname));
              });
            }
            else
            {
              

            }
          },
          dataType:'json',

          });
   });
</script>
  <!-- <script type="text/javascript">
    function listenForDoubleClickedit(i) {
      // alert(element);
      $('#time'+i).removeAttr('disabled');
      $('#tid'+i).removeAttr('disabled');
      $('#ok'+i).show();
      $('#edit'+i).hide();
      // $('#2td16').contentEditable = true;
    }
     function listenForDoubleClickok(i) {
      // alert(element);
      $('#time'+i).attr('disabled',true);
      $('#tid'+i).attr('disabled',true);
      $('#ok'+i).hide();
      $('#edit'+i).show();
      // alert($('#mid'+i).val());
      $.ajax({
                url:"{{ URL::route('edittimeofmember') }}",
                method:"GET",
                data:{"_token": "{{ csrf_token() }}","ptmemberid":$('#mid'+i).val(),"trainerid":$('#tid'+i).val(),"time":$('#time'+i).val()},
                success:function(data) {
                  // alert(data);
                 // swal(data,"Successfully",'success');

                },

              });
      // $('#2td16').contentEditable = true;
    }
  </script> -->
<script type="text/javascript">
  $(document).ready( function (){
  $('#example1').DataTable({
    "lengthMenu": [[7, 10, 15, -1], [7, 10, 15, "All"]]
  });
});
</script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
@endsection