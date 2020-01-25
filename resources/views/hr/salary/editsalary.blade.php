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
        
           
               <form method="post" class="form" action="{{ route('editsalary', $salary->salaryid) }}">
                  <input type="hidden" name="employeeid" value="{{ $salary->employeeid }}">
                  <input type="hidden" name="year" value="{{ $salary->year }}">
                  <input type="hidden" name="Workindays" value="{{ $salary->Workindays }}">
                  <input type="hidden" name="holidays" value="{{ $salary->holidays }}">
                  <input type="hidden" name="totalworkinghour" value="{{ $salary->totalworkinghour }}">
                  <input type="hidden" name="empworkingminute" value="{{ $salary->empworkingminute }}">
                  <input type="hidden" name="empsalary" value="{{ $salary->empsalary }}">
                  <input type="hidden" name="givenleave" value="{{ $salary->givenleave }}">
                  <input type="hidden" name="store" value="1">
                @csrf
             <div class="row">
                <div class="col-lg-12 col-md-8">
                   <div class="row">
                      <div class="box">
                         <div class="box-header">
                            <h3 class="box-title">Salary #<b>{{ucfirst($salary->employee->first_name) }} {{ ucfirst($salary->employee->last_name)}}</b></h3>
                            <h3 class="box-title  pull-right"><b>{{  $salary->month.'-'.$salary->year }}</b></h3>
                         </div>
                         <!-- /.box-header -->
                         <div class="box-body">
                            <div class="row">
                               <div class="col-md-2 col-lg-2 col-xs-6">
                                  <div class="form-group">
                                     <label>Total Days</label>
                                     <input type="text" class="form-control" id="workingdays" value="{{ $salary->workingdays + $salary->holidays}}" name="workingdays_display" readonly>
                                  </div>
                               </div>
                               <div class="col-md-2 col-lg-2 col-xs-6 ">
                                  <div class="form-group">
                                     <label>Working Days</label>
                                     <input type="text" class="form-control" id="actualdays"  name="actualdays_display"  value="{{ $salary->actualdays }}" readonly>
                                  </div>
                               </div>
                               <div class="col-md-2 col-lg-2 col-xs-6">
                                  <div class="form-group">
                                     <label>Non Working Days</label>
                                     <input type="text" class="form-control" id="holiday" value="{{ $salary->holidays }}" name="holidays_display" readonly>
                                  </div>
                               </div>
                               <div class="col-md-2 col-lg-2 col-xs-6">
                                  <div class="form-group">
                                     <label>Present Days</label>
                                     <input type="text" class="form-control" id="attenddays" name="attenddays_display"  value="{{ $salary->attenddays }}" oninput="caldays('pday', this.value)">
                                  </div>
                               </div>
                               <div class="col-md-2 col-lg-2 col-xs-6">
                                  <div class="form-group">
                                     <label>Absent Days</label>
                                     <input type="text" class="form-control" id="takenleave" name="takenleave_display" value="{{$salary->takenleave }}" oninput="caldays('takenleave', this.value)"
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
                            
                                $counttotalsession=0;
                                $totalfloorhour=0;
                                if($salary->ptsessionid != null){
                                 $totalptsession=explode(",", $salary->ptsessionid);
                                 $counttotalsession=count($totalptsession);
                                }
                       
                              $totalfloorhour=$salary->empworkinghour-$counttotalsession;
                              $currentsalary =$salary->currentsalary + $salary->salaryemi;
                              $totalfloorsalry = $currentsalary - $salary->ptsessionsalary;
                              $currentsalary=$totalfloorsalry + $salary->ptsessionsalary
                            @endphp
                            
                                <div class="row">
                                    <div class="">
                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-1  col-lg-2 control-label">Total Floor Hours</label>
                                            <div class="col-sm-4 col-lg-3">
                                                <input type="text" class="form-control" id="totalfloorhour" placeholder="Floor" value="{{ $totalfloorhour }}"readonly >
                                            </div>
                                            <div class="col-sm-4 col-lg-3">
                                                <input type="text" class="form-control" id="floorslary" placeholder="Floor" value="{{  $totalfloorsalry }}"readonly >
                                            </div>
                                            <div class="col-sm-4 col-lg-3">
                                                <button type="button" class="btn btn-default" id="floorlogs" value="Floor Logs" data-toggle="modal" data-target="#exampleModalLong">Floor Logs</button>        
                                            </div>
                                        </div>
                                    </div>
                                </div>
                             
                             
                            
                                
                            <div class="row">
                               <div class="">
                                  <div class="form-group">
                                     <label for="inputEmail3" class="col-sm-1 col-lg-2 control-label">Total PT Hours</label>
                                     <div class="col-sm-4 col-lg-3">
                                        <input type="text" class="form-control" name="totalsession" id="totalsession" placeholder="PT" value="{{ $counttotalsession }}" readonly>
                                     </div>
                                     <div class="col-sm-4 col-lg-3">
                                        <input type="text" class="form-control" name="totalsessionprice" id="totalsessionprice" placeholder="price" value="{{ $salary->ptsessionsalary }}"readonly >
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
                                        <input type="text" class="form-control" id="PT" placeholder="PT" value="{{ $salary->empworkinghour }}" readonly>
                                     </div>
                                     <div class="col-sm-4 col-lg-3">
                                        <input type="text" class="form-control" id="totaltrainersalary" placeholder="Floor" value="{{ $currentsalary }}" readonly>
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
                                     <input type="text" class="form-control" id="absday" placeholder="Floor" value="{{ $salary->takenleave }}" readonly>
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
                                     <input type="text" class="form-control" autocomplete="off" name="casualleave" id="casualleave" value="{{ $salary->casualleave}}">
                                  </div>
                               </div>
                               <div class="col-md-2 col-lg-2 col-xs-6 ">
                                  <div class="form-group">
                                     <label>Medical Leave</label>
                                     <input type="text" class="form-control" autocomplete="off"  name="medicalleave" id="medicalleave" value="{{ $salary->medicalleave}}">
                                  </div>
                               </div>
                               <div class="col-md-2 col-lg-2 col-xs-6">
                                  <div class="form-group">
                                     <label>Paid Leave</label>
                                     <input type="text" class="form-control" autocomplete="off" name="paidleave" id="paidleave" value="{{ $salary->paidleave}}">
                                  </div>
                               </div>
                               
                               <div class="col-md-2 col-lg-2 col-xs-6">
                                  <div class="form-group">
                                     <label>Total Leave</label>
                                     <input type="text" class="form-control" autocomplete="off" id="takenleave12" value="{{ $salary->takenleave  }}" readonly>
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
                                        <input type="text" class="form-control" id="monthlysalary" placeholder="PT" value="{{   $salary->empsalary  }}" readonly>
                                     </div>
                                     <label for="inputEmail3" class="col-sm-1 col-lg-2 control-label">Sub Total</label>
                                     <div class="col-sm-4 col-lg-3">
                                        <input type="text" class="form-control"placeholder="PT"  id="subtotal"
                                        value="{{ $currentsalary }}" >
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
                                        <input type="text" class="form-control" id="loan" placeholder="PT" name="loan" value="{{ $salary->salaryemi }}" readonly="">
                                     </div>
                                     <label for="inputEmail3" class="col-sm-1 col-lg-2 control-label">EMI</label>
                                     {{-- <label for="inputEmail3" class="col-sm-1 col-lg-2 control-label"></label> --}}
                                     <div class="col-sm-4 col-lg-3">
                                        <input type="number" name="emi" class="form-control" value="{{ $salary->salaryemi > 0 ? $salary->salaryemi : 0 }}" min="0" id="emi">
                                     </div>
                                  </div>
                               </div>
                            </div>
                            <div class="row">
                               <div class="">
                                  <div class="form-group">
                                     <label for="inputEmail3" class="col-sm-1 col-lg-2 control-label"></label>
                                     <div class="col-sm-4 col-lg-3">
                                        <input type="text" class="form-control hide"  placeholder="PT" value="">
                                     </div>
                                     <label for="inputEmail3" class="col-sm-1 col-lg-2 control-label">Other Deduction</label>
                                     {{-- <label for="inputEmail3" class="col-sm-1 col-lg-2 control-label"></label> --}}
                                     <div class="col-sm-4 col-lg-3">
                                        <input type="number" name="otheramount" class="form-control" min="0" id="otheramount" value="{{ $salary->salaryothercharges > 0 ? $salary->salaryothercharges : 0 }}">
                                     </div>
                                  </div>
                               </div>
                            </div>
                            <div class="row">
                               <div class="">
                                  <div class="form-group">
                                     <label for="inputEmail3" class="col-sm-1 col-lg-2 control-label"></label>
                                     <div class="col-sm-4 col-lg-3">
                                         
                                        <input type="text" class="form-control hide"  placeholder="PT" value="">
                                     </div>
                                     <label for="inputEmail3" class="col-sm-1 col-lg-2 control-label">Final Total</label>
                                     <div class="col-sm-4 col-lg-3">
                                        <input type="text" name="current_salary" style="border:1px solid;" class="form-control number" min="0" id="current_salary" autocomplete="off" value="{{ $salary->currentsalary }}" required="" readonly max="10">
                                     </div>
                                  </div>
                               </div>
                            </div>
                            <center>
                                <div class="form-row" style="margin-top: 35px; margin-left: 15px;">
                                    <button type="submit" class="btn btn-primary bg-orange" id="submit">Lock Salary</button>
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
                    </thead>
                    <tbody>
                        {{-- {{dd($trainersessiondetail)}} --}}
                        @if(!empty($trainersessiondetail))
                            @if(count($trainersessiondetail) > 0)
                                @foreach($trainersessiondetail as $tsession)
                                <tr>
                                    
                                    <td>{{date('d-m-Y',strtotime($tsession->actualdate))}}</td>
                                    <td>{{$tsession->firstname}} {{$tsession->lastname}}</td>
                                    <td>{{$tsession->schemename}}</td>
                                    <td>{{$tsession->actualtime}}</td>
                                    
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
   
   //     var leavetakencount = {{ $salary->takenleave }};
   
   
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

   let attenddays_disp = {{ $salary->attenddays }};
   let takenleave_disp = {{ $salary->takenleave }};
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
   console.log('leftdays:::'+leftdays);
   let totaldays = Number(leftdays) + Number(val);
   if(!otheramount){
        otheramount = 0;
    }

    if(!emi){
        emi = 0;
    }

   
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

        let workingdays = $('#workingdays').val();
        let current_salary = {{  $salary->currentsalary - $salary->ptsessionsalary }};
        let current_salary_disp = {{   $salary->currentsalary - $salary->ptsessionsalary }};

  
        let empworkinghour = {{ $salary->employee->workinghour }};
        let monthlysalary = $('#monthlysalary').val();
        let attenddays = $('#attenddays').val();
        let totalworkinghour = $('#totalworkinghour').val();
        let takenleave = $('#takenleave').val();
        let casualleave = $('#casualleave').val();
        let medicalleave = $('#medicalleave').val();
        let paidleave = $('#paidleave').val();
        let actualdays = $('#actualdays').val();

        let perdaysalary = monthlysalary/workingdays;
        let perhoursalary=perdaysalary/empworkinghour;
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
      
         let totalleave = Number(casualleave) + Number(medicalleave) + Number(paidleave);
         let commsalary = (Number(workingdays)) * Number(perdaysalary);
        
         commsalary =  commsalary - ((Number(takenleave)) * Number(perdaysalary));
        
       
         calleave();
      
      
        

        if(Number(attenddays) == 0){

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
                   // commsalary=commsalary.toFixed(2);
                  //   console.log(commsalary);
                $('#current_salary').val(Number(commsalary));
                
            }
                if(Number(otheramount) > Number(commsalary)){
                    alert('Please enter valid deduction amount');
                    $('#otheramount').val('');
                }else{
                    commsalary = commsalary - Number(otheramount);
                }
            
        
               // commsalary=commsalary.toFixed(2);
           
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