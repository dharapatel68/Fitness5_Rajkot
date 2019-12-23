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
  @php
  if(isset($_POST['trainerid'])){
     $tid=$_POST['trainerid'];
     $employee=\App\Employee::where('employeeid',$tid)->where('status',1)->get()->first();
     $employeename=$employee->username;
  }
  else{
    $tid=0;
  }
  if(isset($_POST['memberid'])){

    $mid=$_POST['memberid'];
    $membername=\App\Member::where(['memberid' => $mid])->get(['firstname','lastname'])->first();
    $membername=$membername->firstname.' '.$membername->lastname;

  }
  else{
    $mid=0;
  }
  if(isset($_POST['packageid'])){
    $pid=$_POST['packageid'];
    $package=\App\MemberPackages::where('memberpackagesid',$pid)->where('status',1)->get()->first();
    $schemeid=$package->schemeid;
    $scheme= \App\Scheme::where('schemeid',$schemeid)->where('status',1)->get()->first();
    $schemename=$scheme->schemename;
  }
  else{
    $pid=0;
  }
@endphp

  <div class="content-wrapper">
   
     
         <section class="content-header"><h2>Member Session Report</h2></section>
          <!-- general form elements -->
           <div class="content">
          
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
              <h3 class="box-title">Session Report</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <form role="form" action="{{ url('sessionreport')}}" method="post" >
                 {{ csrf_field() }}
                <!-- text input -->
                <div class="col-md-3">
                <div class="form-group">
                  <label>Trainer</label>
                  <select name="trainerid" class="form-control selectpicker" id="trainerid" title="Select Trainer" data-live-search="true" data-selected-text-format="count"  data-actions-box="true" data-count-selected-text="{0} Trainer Selected" data-header="Select Trainer" required>
                    @foreach ($employees as $employee)
                      <option value="{{$employee->employeeid}}" {{ $tid == $employee->employeeid ? 'selected':''}}>{{$employee->username}}</option>
                    @endforeach
                  </select>

                </div>
              </div>

                <div class="col-md-3">
                <div class="form-group">
                  <label>Member</label>
                   <select name="memberid" class="form-control" id="memberid" required>
                    <option value="">--Select Member--</option>
                 
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
               
              <div class="col-md-3">
                <div class="form-group">
                  <label>Package</label>
                  <select name="packageid" class="form-control" id="packageid" title="Select Package"  required>
               <option value="">--Select Package--</option>
   
                  </select>

                </div>
              </div>
               <div class="form-group">
                    <button name="view" type="submit" id="view" class="btn bg-green margin" style="margin-top: 25px">View</button>   <a href="{{ URL::route('sessionreport') }}"class="btn btn-danger margin" style="margin-top: 25px">Cancel</a>
                
                </div>
                <!-- Select multiple-->
               </form>
            </div>
          </div>


                <div class="box box-primary" style="display: block;" id="sessionreport">
  <div class="box-header with-border"></div>
    <div class="box-body" > 
      <button id="getexcel"  class="btn bg-orange" style="float: right; margin-right: 15px;"><i class="fa fa-file-excel-o"></i>   getexcel </button>
     <div class="col-lg-12" style="overflow: auto;">
     <table id="measurement" class="table table-bordered table-striped" width="100%" >
                <thead>
                <tr>
                <th>Trainer</th>
                <th>Member</th>
                <th>Day</th>
                <th>Date</th>
               
                <th>Hoursfrom</th>
                <th>Hoursto</th>
                <th>Actualdate</th>
                 <th>Actualtime</th>
                <th>Status</th>
                <th>Packageid</th>
                <th>Schemeid</th>
                <th>Commision</th>
                <th>Persessioncommision</th>
                <th>Persessionamount</th>
                <th>Paymentstatus</th>
                
                 <th>Action</th>
                </tr>
                </thead>
                <tbody>
               @foreach($grid as $key=>$g)
                <tr>
    
                <td>{{$employeename !== '' ?$employeename: $g->ptrainerid}}</td>
                <td>{{ucwords($membername !== '' ? $membername : $g->pmemberid)}} </td>
                <td>{{$g->day}} </td>
                <td>{{date('d-m-Y',strtotime($g->date))}}</td>
                <td>{{$g->hoursfrom}} </td>
                <td>{{$g->hoursto}} </td>
                <td>{{date('d-m-Y',strtotime($g->actualdate))}}</td>
               <td>{{$g->actualtime}}</td>


                <td>{{$g->ptmemberstatus}} </td>
                <td>{{$g->ppackageid}}</td>
                <td>{{$schemename != '' ? $schemename : $g->schemeid}}</td>
                <!-- <td>{{'finaltrainerid'}}</td> -->
                
                
                <td>{{$g->commision}} </td>
                <td>{{$g->persessioncommision}}</td>
                <td> {{$g->persessionamount}}</td>
                <td>{{$g->paymentstatus}} </td>
              
                <td><a href="{{ url('editMeasurement/') }}"class="edit" title="Edit"><i class="fa fa-edit"></i></a>  </td>           
                </tr>
                 @endforeach
                </tbody>
            
              </table>
              @php 
              $grid1 = json_decode(json_encode($grid), true);
                          
              @endphp
              <input type="hidden" name="griddata" id="griddata" value="">


<script type="text/javascript">
 

</script>
    

              <!-- <a href="{{url('generatexcel')}}">gen Excel</a> -->
      </div>
    </div>

</div>
</div>
</div>
<script type="text/javascript">
 $( document ).ready(function() {
     var trainerid=<?php echo $tid;?>;
      var memberid=<?php echo $mid;?>;
      var packageid=<?php echo $pid;?>;
    if(trainerid == 0 && memberid == 0 && packageid ==0){
   $('#sessionreport').css('display','none');
  }
      if(trainerid !== 0){
        
      }
      if(memberid !== 0){
       
      }
     
     
});
 $('#view').on('click',function(){
 
 })
 </script>
   <script type="text/javascript">
    

    $('#getexcel').on('click',function(){
           var trainerid=<?php echo $tid;?>;
      var memberid=<?php echo $mid;?>;
      var packageid=<?php echo $pid;?>;
      if (trainerid!=0 || memberid!=0 || packageid!=0) {
        console.log(trainerid);
console.log(memberid);
console.log(packageid);
             
                      $.ajax({
                            url:"{{ url('getqueryresultforexcel') }}",
                            method:"GET",
                            data:{"_token": "{{ csrf_token() }}","memberid":memberid,"trainerid":trainerid,"packageid":packageid},
                            success:function(grid) {
                            // alert(grid);

                             // var grid= JSON.stringify(grid);
                             // alert(grid);
                                   grid=JSON.parse("[" + grid + "]");;
                                   // alert(grid);
                                        $.ajax({
                                        url:"{{ url('getexcel') }}",
                                        method:"POST",
                                        data:{"_token": "{{ csrf_token() }}","memberid":memberid,"trainerid":trainerid,"packageid":packageid},
                                      success: function (response, textStatus, request) {
                                      var a = document.createElement("a");
                                      a.href = response.file; 
                                      a.download = response.name;
                                      document.body.appendChild(a);
                                      a.click();
                                      a.remove();
                                      },
                        
                                        dataType:'json',

                                        });
                                  },
                                   // dataType:'json',

                              });

         }  
        
    });

                  $('#trainerid').change(function(){
                       var trainerid = $('#trainerid').val();
                    // alert(trainerid);
               // $('#sessionreport').css('display','none');
                         $('#memberid').find('option:not(:first)').remove();
                              $.ajax({
                                   url:"{{ url('gettrainermember') }}",
                                   method:"GET",
                                   data:{"_token": "{{ csrf_token() }}","trainerid":trainerid},
                                  success:function(data) {
                                    // alert(data);
                                      
                                    if(data){

                                      $.each(data, function(i, item){
                                      
                                       $("#memberid").append($("<option></option>").attr("value", item.memberid).text(item.firstname+' '+item.lastname));

                                      });
                                       
                                    }
                                    $("#memberid option[value="+memberid+"]").attr("selected", "selected");
                                       $("#packageid option[value="+packageid+"]").attr("selected", "selected");

                                    
                                        // $("#memberid").append($("<option></option>").attr("value", item.memberid).text(item.username));
                                  },
                                   dataType:'json',

                              });
                          
                              // $('select[name="mobile_no"]').fadeIn();
                 });
            
                </script>
    
                <script type="text/javascript">
                  $('#memberid').change(function(){
             
                       
                       var member = $('#memberid').val();
                    // alert(member);
                 

                              $.ajax({
                                   url:"{{ URL::route('getpackage') }}",
                                   method:"GET",
                                   data:{"_token": "{{ csrf_token() }}","memberid":member},
                                   async:false,
                                  success:function(data) {
                                    // alert(data);
                                    if(data){

                                      $('#packageid').find('option:not(:first)').remove();
                                       $.each(data, function(i, item){
                                      $('#mobileno').val(item.mobileno);
                                        $("#packageid").append($("<option></option>").attr("value", item.memberpackagesid).text(item.schemename));

                                      });
                                    }
                                   

                                     
                                  },
                                  dataType:'json',

                              });
                          
                              // $('select[name="mobile_no"]').fadeIn();
                 });
       </script>
              
               
 
<script type="text/javascript">
  $(document).ready( function (){
  $('#measurement').DataTable({
    "lengthMenu": [[7, 10, 15, -1], [7, 10, 15, "All"]]
  });
});
</script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

@endsection