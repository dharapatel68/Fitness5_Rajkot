@extends('layouts.adminLayout.admin_design')

@section('title', 'Add Employee Leave')

@section('content')
        @php

            $year = !empty($year) ? $year : '';
            $month = !empty($month) ? $month : '';
            $employeeid = !empty($employeeid) ? $employeeid : '';
            $i = 0;
            $confirmdate = '';


        @endphp
<div class="wrapper">
    <div class="content-wrapper">
        <section class="content-header">
            <div class="row">
                <div class="col-md-12">
                <ol class="breadcrumb">
                    <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                    <li><a href="{{ route('viewemployeeleave') }}">Employee Leave</a></li>
                    <li class="active">Add Employee Leave</li>
                </ol>
                </div>
            </div>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Add Employee Leave</h3>
                        </div>

                        <!-- /.box-header -->
                        <div class="box-body">
                                <div class="row">
                                    <div class="col-md-3"></div>
                                    <div class="col-md-6">
                                        <form action="{{ route('employeeleave') }}" method="post" id="workingdays">
                                            {{ csrf_field() }}
                                            <div class="form-group">
                                                <label>Employee<span style="color: red;">*</span></label>
                                                <select  class="form-control span11 select2"title="Select Employee" data-live-search="true" data-selected-text-format="count"  data-actions-box="true"  data-header="Select Employee" required="" name="employeeid" id="employeeid" data-sear>
                                                    @if(!empty($employee))
                                                    <option value="">--Please select Employee--</option>
                                                    @foreach($employee as $emp)
                                                    <option value="{{ $emp->employeeid }}" @if(old('employeeid') == $emp->employeeid) selected="" @endif>{{ ucfirst($emp->first_name) }} {{ ucfirst($emp->last_name) }}</option>
                                                    @endforeach
                                                    @endif
                                                </select>
                                                @if($errors->has('employeeid'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('employeeid') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                            <div class="form-group">
                                                <label>Mobile No<span style="color: red;">*</span></label>
                                                <select  class="form-control" disabled="" id="mobileno">
                                                    @if(!empty($employee))
                                                    <option value="">--Select Employee--</option>
                                                    @foreach($employee as $emp)
                                                    <option value="{{ $emp->employeeid }}"@if(old('employeeid') == $emp->employeeid) selected="" @endif>{{ $emp->mobileno }}</option>
                                                    @endforeach
                                                    @endif
                                                </select>
                                                <span id="leave_error" style="color: red;display: none;">Please add employee leave</span>
                                            </div>

                                            <div class="form-group">
                                                <label>Date<span style="color: red;">*</span></label>
                                                <input type="date" name="leavedate" id="leavedate" class="form-control" required="" value="{{ old('leavedate') }}">
                                                @if($errors->has('leavedate')) 
                                                <span class="help-block">
                                                <strong>{{ $errors->first('leavedate') }}</strong>
                                                </span>
                                                @endif
                                            </div>

                                        <div class="form-group">
                                                <label>Type<span style="color: red;">*</span></label>
                                                <select class="form-control" placeholder="Select Leave Type" name="leavetype" required="">
                                                <option value="">--Select Leave Type--</option>
                                                <option value="Cl" @if(old('leavetype') == 'Cl') selected="" @endif>Casual Leave</option>
                                                <option value="Ml" @if(old('leavetype') == 'Ml') selected="" @endif>Medical Leave</option>
                                                <option value="Pl" @if(old('leavetype') == 'Pl') selected="" @endif>Paid Leave</option>
                                                </select>
                                                @if($errors->has('leavedate')) 
                                                <span class="help-block">
                                                <strong>{{ $errors->first('leavedate') }}</strong>
                                                </span>
                                                @endif
                                        </div>

                                            <div class="form-group">
                                                <label>Reason</label>
                                                <textarea name="reason" class="form-control">{{ old('reason') }}</textarea>
                                                @if($errors->has('reason'))
                                                <span class="help-block">
                                                <strong>{{ $errors->first('reason') }}</strong>
                                                </span>
                                                @endif
                                            </div>

                                            <button type="submit" class="btn btn-primary bg-orange" id="submit">Submit</button>
                                            <a href="{{ route('viewworkingdays') }}" class="btn btn-danger">Cancel</a>
                                        </form> 
                                    </div>
                                    <div class="col-md-3"></div>
                                </div>                                   
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </section>
    </div>
</div>        
@endsection
@push('script')
<script type="text/javascript">
    function unfreeze(id){
        $('#unfreeze #unfreezeid').val(id);
        //$('#unfreeze #unfreezeid').text(id);
    }

    $(document).ready(function(){

         $('#employeeid').change(function(){

            let empid = $(this).val();
            if(empid){
               $('#mobileno option[value='+empid+']').prop('selected', true);
            }

            $.ajax({
                type : 'POST',
                url : '{{ route('empexpirydate') }}',
                data : {empid:empid, _token : '{{ csrf_token() }}'},
                success : function(data){
               

                    if(data != 'leavenotfound' ){


                        $('#leavedate').attr('max', data);
                        $('#leave_error').css('display', 'none');
                        $('#submit').removeAttr('disabled');

                    }else{

                        $('#submit').attr('disabled', 'true');
                        $('#leave_error').css('display', 'block');

                    }

                }
            });
       });

    });
</script>
<script type="text/javascript">

    $(function () {
      //Initialize Select2 Elements
      $('.select2').select2()
  
      //Datemask dd/mm/yyyy
      $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
      //Datemask2 mm/dd/yyyy
      $('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' })
      //Money Euro
      $('[data-mask]').inputmask()
  
      //Date range picker
      $('#reservation').daterangepicker()
      //Date range picker with time picker
      $('#reservationtime').daterangepicker({ timePicker: true, timePickerIncrement: 30, format: 'MM/DD/YYYY h:mm A' })
      //Date range as a button
      $('#daterange-btn').daterangepicker(
        {
          ranges   : {
            'Today'       : [moment(), moment()],
            'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month'  : [moment().startOf('month'), moment().endOf('month')],
            'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
          },
          startDate: moment().subtract(29, 'days'),
          endDate  : moment()
        },
        function (start, end) {
          $('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
        }
      )
  
      //Date picker
      $('#datepicker').datepicker({
        autoclose: true
      })
  
      //iCheck for checkbox and radio inputs
      $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
        checkboxClass: 'icheckbox_minimal-blue',
        radioClass   : 'iradio_minimal-blue'
      })
      //Red color scheme for iCheck
      $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
        checkboxClass: 'icheckbox_minimal-red',
        radioClass   : 'iradio_minimal-red'
      })
      //Flat red color scheme for iCheck
      $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
        checkboxClass: 'icheckbox_flat-green',
        radioClass   : 'iradio_flat-green'
      })
  
      //Colorpicker
      $('.my-colorpicker1').colorpicker()
      //color picker with addon
      $('.my-colorpicker2').colorpicker()
  
      //Timepicker
      $('.timepicker').timepicker({
        showInputs: false
      })
    })
  </script>
@endpush