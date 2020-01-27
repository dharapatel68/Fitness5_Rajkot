@extends('layouts.adminLayout.admin_design')
<style>
   .highlight{
   border:1px solid black !important;
   }
   .row{
		padding-right: 15px !important;
		padding-left: 15px !important;
	}
    .content-wrapper {
    /* min-height: 100%;*/
    }

</style>
@section('title', 'Calculate Salary')
@section('content')
@php
$year = !empty($year) ? $year : '';
$month = !empty($month) ? $month : '';
$employeeid = !empty($employeeid) ? $employeeid : '';
$i = 0;
$confirmdate = '';
@endphp
@php
    // if(count($schemedetail) > 0){
    //     $persessionprice= round($schemedetail->baseprice/$schemedetail->pthours,2);
    //     $sessionprice=round($persessionprice*($trainerdetail['trainerpercentage']/100),2);
    //     $totalsessionprice=$sessionprice*$schemedetail['totalsession'];
    // }
    

@endphp
<div class="wrapper">
    <div class="content-wrapper">
       <section class="content-header">
          <div class="row">
             <div class="col-md-12">
                <ol class="breadcrumb">
                   <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                   <li><a href="{{ route('viewemployeeaccount') }}">Salary</a></li>
                   <li class="active">Calculate Salary</li>
                </ol>
             </div>
          </div>
       </section>
       <section>
        
            <form method="post" class="form"action="{{ route('storeempsalary') }}">
                <input type="hidden" name="employeeid" value="{{ $employeeid }}">
                <input type="hidden" name="year" value="{{ $year }}">
                <input type="hidden" name="month" value="{{ $month }}">
                <input type="hidden" name="month_display" value="{{ $month }}">
                <input type="hidden" name="Workindays" value="{{ $Workindays }}">
                <input type="hidden" name="holidays" value="{{ $holidays }}">
                <input type="hidden" name="totalworkinghour" value="{{ $totalworkinghour }}">
                <input type="hidden" name="empworkingminute" value="{{ $empworkingminute }}">
                <input type="hidden" name="monthlyworking_hour_display" value="{{ $totalworkinghour }}">
                <input type="hidden" name="totalworkinghour_display" id="totalworkinghour"  value="{{ $totalhour_dispaly_model }}">
                <input type="hidden" name="workingminute" id="workingminute" value="{{ $totalminute_dispaly }}">
                <input type="hidden" name="empsalary" value="{{ $empsalary }}">
                <input type="hidden" name="givenleave" value="{{ $givenleave }}">
                <input type="hidden" name="store" value="1">
                <input type="hidden" name="cal_month" value="{{ $cal_month }}">
                @csrf
             <div class="row">
                <div class="col-lg-12 col-md-8">
                   <div class="row">
                      <div class="box">
                         <div class="box-header">
                            <h3 class="box-title">Salary #<b>{{ ucfirst($empdata->first_name) }} {{ ucfirst($empdata->last_name) }}</b></h3>
                            <h3 class="box-title  pull-right"><b>{{ $month.'-'.$year }}</b></h3>
                         </div>
                         <!-- /.box-header -->
                         <div class="box-body">
                            <div class="row">
                               <div class="col-md-2 col-lg-2 col-xs-6">
                                  <div class="form-group">
                                     <label>Total Days</label>
                                     <input type="text" class="form-control" id="workingdays" value="{{ $Workindays+$holidays }}" name="workingdays_display" readonly>
                                  </div>
                               </div>
                               <div class="col-md-2 col-lg-2 col-xs-6 ">
                                  <div class="form-group">
                                     <label>Working Days</label>
                                     <input type="text" class="form-control" id="actualdays"  name="actualdays_display"  value="{{ $Workindays }}" readonly>
                                  </div>
                               </div>
                               <div class="col-md-2 col-lg-2 col-xs-6">
                                  <div class="form-group">
                                     <label>Non Working Days</label>
                                     <input type="text" class="form-control" id="holiday" value="{{ $holidays }}" name="holidays_display" readonly>
                                  </div>
                               </div>
                               <div class="col-md-2 col-lg-2 col-xs-6">
                                  <div class="form-group">
                                     <label>Present Days</label>
                                     <input type="text" class="form-control" id="attenddays" name="attenddays_display"  value="{{ $attenddays }}" oninput="caldays('pday', this.value)">
                                  </div>
                               </div>
                               <div class="col-md-2 col-lg-2 col-xs-6">
                                  <div class="form-group">
                                     <label>Absent Days</label>
                                     <input type="text" class="form-control" id="takenleave" name="takenleave_display" value="{{ $leavedays_cal }}" oninput="caldays('takenleave', this.value)"
                                        required="" autocomplete="off">
                                  </div>
                               </div>
                               <div class="col-md-2 col-lg-2 col-xs-6">
                                  {{-- <div class="form-group">
                                     <label>Monthly </label>
                                     <input type="text" class="form-control">
                                  </div> --}}
                               </div>
                            </div>
                         </div>
                      </div>
                   </div>
                   <div class="row">
                      <div class="box">
                         <div class="box-header with-border">
                            <h3 class="box-title">Duty Hours<b></b></h3>
                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                            </div>
                         </div>
                         <!-- /.box-header -->
                         <div class="box-body">
                            <div class="row">
                               <div class="">
                                  <div class="form-group">
                                     <label class="col-sm-1  col-lg-2 control-label">Detail</label>
                                     <div class="col-sm-4 col-lg-3">
                                        <label class="control-label"> Hours</label>
                                     </div>
                                     <div class="col-sm-4 col-lg-3">
                                        <label class="control-label"> Rs</label>
                                     </div>
                                     <div class="col-sm-4 col-lg-3">
                                        <label class="control-label"> Logs</label>                                            
                                     </div>
                                  </div>
                               </div>
                            </div>
                            @php
                            $totalfloorhour=$totalworkinghour-$trainersession;
                            $perdaysalary=round($empsalary/$Workindays, 2);
                            $perhoursalary=round($perdaysalary/$empworkinghour , 2);
                            @endphp
                            
                                <div class="row">
                                    <div class="">
                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-1  col-lg-2 control-label">Total Floor Hours</label>
                                            <div class="col-sm-4 col-lg-3">
                                                <input type="text" class="form-control" id="totalfloorhour" placeholder="Floor" value="{{ $totalfloorhour }}"readonly >
                                            </div>
                                            <div class="col-sm-4 col-lg-3">
                                                <input type="text" class="form-control" id="floorslary" placeholder="Floor" value="{{ $totalfloorhour*$perhoursalary }}"readonly >
                                            </div>
                                            <div class="col-sm-4 col-lg-3">
                                                <button type="button" class="btn btn-default" id="floorlogs" value="Floor Logs" data-toggle="modal" data-target="#exampleModalLong">Floor Logs</button>        
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @php
                                  $totalsessionprice=0;
                                       
                                 @endphp
                             
                                @if($trainerdetail)
                                    @if(count($trainerdetail['trainershemes']) > 0 )
                                        @php $totalsessionprice =0; @endphp
                                        @foreach($trainerdetail['trainershemes'] as $schemedetail)  
                                            @php
                                               
                                                $totalsessionprice +=$schemedetail->amount;
                                               
                                            @endphp
                                        @endforeach
                                    @endif
                                    @endif   
                                
                            <div class="row">
                               <div class="">
                                  <div class="form-group">
                                     <label for="inputEmail3" class="col-sm-1 col-lg-2 control-label">Total PT Hours</label>
                                     <div class="col-sm-4 col-lg-3">
                                        <input type="text" class="form-control" name="totalsession" id="totalsession" placeholder="PT" value="{{ $trainersession }}" readonly>
                                     </div>
                                     <div class="col-sm-4 col-lg-3">
                                        <input type="text" class="form-control" name="totalsessionprice" id="totalsessionprice" placeholder="price" value="{{ $totalsessionprice }}"readonly >
                                     </div>
                                     <div class="col-sm-4 col-lg-3">
                                        <button type="button" class="btn  btn-default"  data-toggle="modal" data-target="#ptlogs" id="ptlogs" value="PT Logs">PT Logs</button>
                                     </div>
                                  </div>
                               </div>
                            </div>
                            
                            <div class="row">
                               <div class="">
                                  <div class="form-group">
                                     <label for="inputEmail3" class="col-sm-1 col-lg-2 control-label">Total</label>
                                     <div class="col-sm-4 col-lg-3">
                                        <input type="text" class="form-control"  id="PT" placeholder="PT" value="{{ $totalfloorhour+$trainersession }}" readonly>
                                     </div>
                                     <div class="col-sm-4 col-lg-3">
                                        <input type="text" class="form-control" id="totaltrainersalary" placeholder="Floor" value="{{ round(($totalfloorhour*$perhoursalary)+$totalsessionprice,2)}}" readonly>
                                     </div>
                                  </div>
                               </div>
                            </div>
                         </div>
                      </div>
                   </div>
                   <div class="row">
                      <div class="box">
                         <div class="box-header with-border">
                            <h3 class="box-title">Leave Calculation<b></b></h3>
                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                            </div>
                         </div>
                         <!-- /.box-header -->
                         <div class="box-body">
                            <div class="row">
                               <div class="form-group">
                                  <label for="inputEmail3" class="col-sm-1  col-lg-2 control-label">Absent Days</label>
                                  <div class="col-sm-4 col-lg-3">
                                     <input type="text" class="form-control" id="absday" placeholder="Floor" value="{{ $leavedays_cal }}" readonly>
                                  </div>
                               </div>
                            </div>
                            <div class="row">
                               <br>
                               <div class="col-md-2 col-lg-2 col-xs-6">
                                 <div class="form-group hide">
                                    <label>Extra</label>
                                    <input type="text" class="form-control" id="attenddays23" value="0">
                                 </div>
                              </div>
                               <div class="col-md-2 col-lg-2 col-xs-6 ">
                                  <div class="form-group">
                                     <label>Casual leave</label>
                                     <input type="text" class="form-control" name="casualleave" id="casualleave" value="0">
                                  </div>
                               </div>
                               <div class="col-md-2 col-lg-2 col-xs-6 ">
                                  <div class="form-group">
                                     <label>Medical Leave</label>
                                     <input type="text" class="form-control" name="medicalleave" id="medicalleave" value="0">
                                  </div>
                               </div>
                               <div class="col-md-2 col-lg-2 col-xs-6">
                                  <div class="form-group">
                                     <label>Paid Leave</label>
                                     <input type="text" class="form-control" name="paidleave" id="paidleave" value="0">
                                  </div>
                               </div>
                               
                               <div class="col-md-2 col-lg-2 col-xs-6">
                                  <div class="form-group">
                                     <label>Total Leave</label>
                                     <input type="text" class="form-control" id="takenleave12" value="{{ $leavedays_cal  }}" readonly>
                                  </div>
                               </div>
                            </div>
                         </div>
                      </div>
                   </div>
                   <div class="row">
                      <div class="box">
                         <div class="box-header with-border">
                            <h3 class="box-title">Salary Calculation<b></b></h3>
                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                            </div>
                         </div>
                         <!-- /.box-header -->
                         <div class="box-body">
                            <?php $loanamount = !empty($emploanamount->amount) ? $emploanamount->amount : 0; ?>
                            <div class="row">
                               <div class="">
                                  <div class="form-group">
                                     <label for="inputEmail3" class="col-sm-1 col-lg-2 control-label">Monthly Salary</label>
                                     <div class="col-sm-4 col-lg-3">
                                        <input type="text" class="form-control" id="monthlysalary" placeholder="PT" value="{{  $empsalary }}" readonly>
                                     </div>
                                     <label for="inputEmail3" class="col-sm-1 col-lg-2 control-label">Sub Total</label>
                                     <div class="col-sm-4 col-lg-3">
                                        <input type="text" class="form-control"placeholder="PT"  id="subtotal"
                                        value="{{ $current_salary }}" readonly >
                                     </div>
                                  </div>
                               </div>
                            </div>
                            <div class="row">
                               <div class="">
                                  <div class="form-group">
                                     <label for="inputEmail3" class="col-sm-1 col-lg-2 control-label">Loan Amount</label>
                                     <input type="hidden" name="loan"  class="form-control" value="{{ $loanamount }}">
                                     <div class="col-sm-4 col-lg-3">
                                        <input type="text" class="form-control" id="loan" placeholder="PT" name="loan" value="{{ $loanamount }}" readonly="">
                                     </div>
                                     <label for="inputEmail3" class="col-sm-1 col-lg-2 control-label">EMI</label>
                                     {{-- <label for="inputEmail3" class="col-sm-1 col-lg-2 control-label"></label> --}}
                                     <div class="col-sm-4 col-lg-3">
                                        <input type="number" name="emi" class="form-control" max="{{ $loanamount }}" min="0" id="emi">
                                     </div>
                                  </div>
                               </div>
                            </div>
                            <div class="row">
                               <div class="">
                                  <div class="form-group">
                                     <label for="inputEmail3" class="col-sm-1 col-lg-2 control-label"></label>
                                     <div class="col-sm-4 col-lg-3">
                                        <input type="text" class="form-control hide"  placeholder="PT" value="{{ $trainersession }}">
                                     </div>
                                     <label for="inputEmail3" class="col-sm-1 col-lg-2 control-label">Other Deduction</label>
                                     {{-- <label for="inputEmail3" class="col-sm-1 col-lg-2 control-label"></label> --}}
                                     <div class="col-sm-4 col-lg-3">
                                        <input type="number" name="otheramount" class="form-control" min="0" id="otheramount">
                                     </div>
                                  </div>
                               </div>
                            </div>
                            <div class="row">
                               <div class="">
                                  <div class="form-group">
                                     <label for="inputEmail3" class="col-sm-1 col-lg-2 control-label"></label>
                                     <div class="col-sm-4 col-lg-3">
                                         
                                        <input type="text" class="form-control hide"  placeholder="PT" value="{{ $trainersession }}">
                                     </div>
                                     <label for="inputEmail3" class="col-sm-1 col-lg-2 control-label">Final Total</label>
                                     <div class="col-sm-4 col-lg-3">
                                        <input type="text" name="current_salary" style="border:1px solid;" class="form-control number" min="0" id="current_salary" autocomplete="off" value="{{ $current_salary }}" required="" readonly max="10">
                                     </div>
                                  </div>
                               </div>
                            </div>
                            <center>
                                <div class="form-row" style="margin-top: 35px; margin-left: 15px;">
                                    <button type="submit" class="btn btn-primary bg-orange" id="submit">Save Salary</button>
                                    <a href="{{ route('viewsalary') }}" class="btn btn-danger">cancel</a>
                                </div>
                            </center>
                         </div>
                      </div>
                        
                   </div>
                </div>
             </div>
            </form>
       </section>
    </div>
 </div>

@endsection

  
  <!-- Modal -->
  <div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Employee Logs</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <th>Date</th>
                        <th>Check In</th>
                        <th>Check Out</th>
                        <th></th>
                    </thead>
                    <tbody>
                        @foreach($employeelog as $emplog)
                            <tr>
                                <td>{{date('d-m-Y',strtotime($emplog->punchdate))}}</td>
                                <td>{{$emplog->checkin}}</td>
                                <td>{{$emplog->checkout}}</td>
                                
                            </tr>
                            @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="ptlogs" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Employee PT Logs</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="table-responsive">
                <table class="table">
                    <thead class="thead-inverse">
                        <th>Date</th>
                        <th>Member</th>
                        <th>Scheme</th>
                        <th>Session Time</th>
                        <th>Session Amount</th>
                    </thead>
                    <tbody>
                 
                        @if(!empty($trainerdetail['trainershemes']))
                            @if(count($trainerdetail['trainershemes']) > 0)
                                @foreach($trainerdetail['trainershemes'] as $tsession)
                                <tr>
                                    
                                    <td>{{date('d-m-Y',strtotime($tsession->actualdate))}}</td>
                                    <td>{{$tsession->firstname}} {{$tsession->lastname}}</td>
                                    <td>{{$tsession->schemename}}</td>
                                    <td>{{$tsession->actualtime}}</td>
                                    <td>{{$tsession->amount}}</td>
                                    
                                </tr>
                                @endforeach
                            @endif
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
@push('script')
<script type="text/javascript">
   // $(document).ready(function(){
   
   //     var leavetakencount = {{ $leavedays_cal }};
   
   
   //     if(leavetakencount > 0){
   //         $('#submit').attr('disabled', 'true');
   //     }
   
   //     $('#employeeid').change(function(){
   
   //         let empid = $(this).val();
   //         if(empid){
   //            $('#mobileno option[value='+empid+']').prop('selected', true);
   //        }
   //    });
   
   // });
   
   
   $('#casualleave').on('input', function(){
       //calculatesalary();
       calsal();
   });
   
   $('#medicalleave').on('input', function(){
       //calculatesalary();
       calsal();
   });
   
   $('#paidleave').on('input', function(){
       //calculatesalary();
       calsal();
   });
   
   $('#emi').on('input', function(){
     
       //calculatesalary();
       calsal();
   });
   
   $('#otheramount').on('input', function(){
       //calculatesalary();
       calsal();
   });
   
   $('#takenleave').change(function(){
       $('#casualleave').val(0);
       $('#medicalleave').val(0);
       $('#paidleave').val(0);
   });
   
   
   function caldays(type,val)
   {
   
   let actualdays = $('#actualdays').val();
   let current_salary_disp = {{ $current_salary }};
   let attenddays_disp = {{ $attenddays }};
   let takenleave_disp = {{ $leavedays_cal }};
   let salary = $('#salary').val();
   let workingdays = $('#workingdays').val();
   let current_salary = $('#current_salary').val();
   let perdaysalary = monthlysalary/workingdays;
   let casualleave = $('#casualleave').val();
   let medicalleave = $('#medicalleave').val();
   let paidleave = $('#paidleave').val();
   let emi = $('#emi').val();
   let otheramount = $('#otheramount').val();
   let loanamount = $('#loan').val();
   let totalleave= 0;
   
   let leftdays = Number(actualdays) - Number(val);
   
   let totaldays = Number(leftdays) + Number(val);
   $('#casualleave').val('');
   $('#medicalleave').val('');
   $('#paidleave').val('');
   $('#emi').val('');
   $('#otheramount').val('');
   
   
   if(leftdays < 0){
       alert('Pease Enter valid days');
       $('#attenddays').val(attenddays_disp);
       $('#takenleave').val(takenleave_disp);
       $('#current_salary').val(current_salary_disp);
       $('#subtotal').val(current_salary_disp);
   
       $('#casualleave').val('');
       $('#medicalleave').val('');
       $('#paidleave').val('');
   
   }else{
   
       if(type=='takenleave')
       {
   
           $('#attenddays').val(leftdays);
           $('#absday').val(leftdays);
           $('#takenleave12').val(leftdays);
           calsal();
       }
       else
       {
           $('#takenleave').val(leftdays);
           $('#absday').val(leftdays);
           $('#takenleave12').val(leftdays);
           calsal();
       }
   }
   }
   
   function calsal(){
   
        let salary = $('#salary').val();
        let workingdays = $('#workingdays').val();
        let current_salary = $('#current_salary').val();
        let current_salary_disp = {{ $current_salary }};
        let attenddays_disp = {{ $attenddays }};
        let takenleave_disp = {{ $takenleave }};
        let empworkinghour = {{ $empworkinghour }};
        let monthlysalary = $('#monthlysalary').val();
        let attenddays = $('#attenddays').val();
        let totalworkinghour = $('#totalworkinghour').val();
        let takenleave = $('#takenleave').val();
        let casualleave = $('#casualleave').val();
        let medicalleave = $('#medicalleave').val();
        let paidleave = $('#paidleave').val();
        let actualdays = $('#actualdays').val();
        let leavedays_cal  = Number(actualdays) - Number(attenddays); 
        let perdaysalary = monthlysalary/workingdays;
        let perhoursalary = perdaysalary/empworkinghour;
        var holidays = Number($('#holiday').val());
        let emi = $('#emi').val();
        let otheramount = $('#otheramount').val();
        let loanamount = $('#loan').val();
        let totalsession= $('#totalsession').val();
        let totalsessionprice = $('#totalsessionprice').val();
            
        if(!otheramount){
            otheramount = 0;
        }
        
        if(!emi){
            emi = 0;
        }
        
        console.log('perdaysalary'+perdaysalary);
        
        let totalleave = Number(casualleave) + Number(medicalleave) + Number(paidleave);
        let commsalary = (Number(workingdays)) * Number(perdaysalary);
        commsalary =  commsalary - (Number(takenleave)) * Number(perdaysalary);
        
        calleave();
        console.log('commsalary '+commsalary);

        if(Number(workingdays) == 0){

            $('#current_salary').val(0);
            $('#subtotal').val(0);
            $('#emi').val(0);
            $('#otheramount').val(0);
        
        }else{
            

            let attendhour = Number(workingdays) * Number(empworkinghour);
            $('#totalworkinghour').val(attendhour);
        
            let attendminute = Number(workingdays) * Number(empworkinghour) * 60;
            $('#workingminute').val(attendminute);
        
            if(Number(casualleave) > 0 ){
                
                let totalsalary = Number(casualleave) * Number(perdaysalary);
                commsalary = Number(commsalary) + Number(totalsalary);
        
            }
            if(Number(medicalleave) > 0){
        
                let totalsalary = Number(medicalleave) * Number(perdaysalary);
                commsalary = Number(commsalary) + Number(totalsalary);
        
            }
            commsalary=commsalary.toFixed(2);
            $('#subtotal').val(Number(commsalary));
            
            if(totalsession > 0 )
            {

                let deductsession=perhoursalary*totalsession;
                
                commsalary = commsalary - Number(deductsession);
                commsalary = commsalary + Number(totalsessionprice);
                commsalary=commsalary.toFixed(2);
                $('#subtotal').val(Number(commsalary));
                
            }
            if(Number(emi) > Number(loanamount) || Number(emi) > Number(commsalary))
            {
                alert('Please enter valid EMI');
                $('#emi').val('');
                
        
            }else{
            
                    commsalary = commsalary - Number(emi);
                    commsalary=commsalary.toFixed(2);
                $('#current_salary').val(Number(commsalary));
                
            }
                if(Number(otheramount) > Number(commsalary)){
                    alert('Please enter valid deduction amount');
                    $('#otheramount').val('');
                }else{
                    commsalary = commsalary - Number(otheramount);
                }
            
        
            commsalary=commsalary.toFixed(2);
            
                $('#current_salary').val(Number(commsalary)); 
        
        
                if(Number(totalleave) == Number(takenleave)){
                        $('#submit').removeAttr('disabled');
                }else{
                        $('#submit').attr('disabled', 'true');
                }
        }
     
   }
   function calleave()
   {
        let takenleave = $('#takenleave').val();
        let casualleave = $('#casualleave').val();
        let medicalleave = $('#medicalleave').val();
        let paidleave = $('#paidleave').val();
        let totalleave = Number(casualleave) + Number(medicalleave) + Number(paidleave);
        
        if(takenleave < totalleave)
        {
            alert('Please enter valid leave');
            $('#casualleave').val('');
            $('#medicalleave').val('');
            $('#paidleave').val('');
        }
        else{
            
        }
   }
   
</script>
@endpush