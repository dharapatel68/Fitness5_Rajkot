@extends('layouts.adminLayout.admin_design') 

@section('title', 'View Employee Leave')

@section('content')


        @php

            $employeeid = !empty($employeeid) ? $employeeid : '';

        @endphp
<div class="wrapper">
    <div class="content-wrapper">
        <section class="content-header">
           <div class="row">
                <div class="col-md-12">
                <ol class="breadcrumb">
                    <li><a href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                    <li><a href="{{ route('viewemployeeleave') }}">Employee Leave</a></li>
                    <li class="active">Edit Employee Leave</li>
                </ol>
                </div>
            </div>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-xs-12">

                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Employee Leave Detail</h3>
                            <div class="" style="float: right;"><a href="{{ route('employeeleave') }}" class="btn btn-primary bg-orange" title="Add Working days">Add Employee Leave</a></div>
                        </div>

                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="row" style="margin-left: 0px !important; ">
                                
                                    <form method="post" class="form-inline" action="{{ route('searchemployeeleave') }}">
                                    @csrf
                                    <div class="form-group">
                                        {{-- <label>Employee<span style="color: red;">*</span></label> --}}
                                        <select  class="form-control span11 select2"title="Select Employee" data-live-search="true" data-selected-text-format="count"  data-actions-box="true"  data-header="Select Employee" required="" placeholder="Please Select Employee" name="employeeid" id="employeeid" data-sear>
                                        @if(!empty($employee))
                                        <option value="">--Please Select Employee--</option>
                                        @foreach($employee as $emp)
                                        <option value="{{ $emp->employeeid }}" @if($employeeid == $emp->employeeid) selected="" @endif>{{ ucfirst($emp->first_name) }} {{ ucfirst($emp->last_name) }}</option>
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
                                    {{--  <label>Mobile No<span style="color: red;">*</span></label> --}}
                                    <select  class="form-control" disabled="" id="mobileno">
                                        @if(!empty($employee))
                                        <option value="">--Select Employee--</option>
                                        @foreach($employee as $emp)
                                        <option value="{{ $emp->employeeid }}"  @if($employeeid == $emp->employeeid) selected="" @endif>{{ $emp->mobileno }}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                    <span id="leave_error" style="color: red;display: none;">Please add employee leave</span>
                                    </div>
                                    <div class="form-group">
                                    <button type="submit" class="btn btn-primary bg-orange">Submit</button>
                                </div>
                                </form>
                                
                            </div>
                            <br/>
                                <div class="box-body table-responsive no-padding">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Date</th>
                                        <th>Reason</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(!empty($employeeleave))
                                        @foreach($employeeleave as $key => $employee)
                                            <tr>
                                                <td>{{ ++$key }}</td>
                                                @php

                                                    $fname = !empty($employee->empname->first_name) ? $employee->empname->first_name : '';
                                                    $lname = !empty($employee->empname->last_name) ? $employee->empname->last_name : '';

                                                @endphp
                                                <td>{{ $fname }} {{ $lname }}</td>
                                                <td>{{ date('d-m-Y', strtotime($employee->date)) }}</td>
                                                <td>{{ $employee->reason }}</td>
                                                <td>
                                                    <a href="{{ route('editemployeeleave', $employee->employeeleaveid) }}" title="edit"><i class="fa fa-edit"></i></a>
                                                    <a href="{{ route('deleteemployeeleave', $employee->employeeleaveid) }}" title="edit"><i class="fa fa-trash"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="5">No Data Found</td>
                                        </tr>
                                    @endif
                                </tbody>

                            </table>
                           
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
<script type="text/javascript">
    

    $(document).ready(function(){
       
        $('#employeeid').change(function(){

            let empid = $(this).val();
            if(empid){
               $('#mobileno option[value='+empid+']').prop('selected', true);
            }
        });

    });
</script>
@endpush