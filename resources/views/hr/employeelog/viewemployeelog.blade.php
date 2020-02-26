@extends('layouts.adminLayout.admin_design')

@section('title', 'View Employee Log')
<link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
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
                <li><a href="{{ route('employeelog') }}">Employee Log</a></li>
                <li class="active">View Employee Log</li>
              </ol>
            </div>
            </div>
        </section>
      
        <section class="content">
                    <div class="row">
                        <div class="col-xs-12">

                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">Employee Log Detail</h3>
                                </div>

                                <!-- /.box-header -->
                                <div class="box-body">
                                    <div class="row mb-5">
                                        <div class="col-md-12">
                                            <div class="form-inline">
                                                @csrf
                                                <div class="form-group">
                                                        <select class="form-control span11 select2"title="Select Employee" data-live-search="true" data-selected-text-format="count"  data-actions-box="true"  data-header="Select Employee" required="" name="employeeid" id="employeeid" data-sear>
                                                           @if(!empty($employee))
                                                           <option value="">--Please Select Employee--</option>
                                                           @foreach($employee as $emp)
                                                                <option value="{{ $emp->employeeid }}" @if($emp->employeeid == $employeeid) selected="" @endif>{{ ucfirst($emp->first_name) }} {{ ucfirst($emp->last_name) }}</option>
                                                           @endforeach
                                                           @endif
                                                        </select>
                                                </div>
                                                <div class="form-group">
                                                   
                                                        <select  class="form-control" name="mobile" id="mobileno" placeholder="Mobileno" disabled="" style="width: 240px !important;">
                                                            <option value="">--Select Mobileno--</option>
                                                           @if(!empty($employee))
                                                           @foreach($employee as $emp)
                                                                <option value="{{ $emp->employeeid }}" @if($emp->employeeid == $employeeid) selected="" @endif>{{ $emp->mobileno }}</option>
                                                           @endforeach
                                                           @endif
                                                        </select>
                                                  
                                                </div>
                                                <div class="form-group">
                                                    
                                                        <select  class="form-control span11 select2"title="Select Month" data-live-search="true" data-selected-text-format="count"  data-actions-box="true"  data-header="Select Month" required="" name="month" id="month" placeholder="Month">
                                                            <option value="">--Select Month--</option>
                                                            <option value='Janaury' @if($month == 'Janaury') selected="" @endif>Janaury</option>
                                                            <option value='February' @if($month == 'February') selected="" @endif>February</option>
                                                            <option value='March' @if($month == 'March') selected="" @endif>March</option>
                                                            <option value='April' @if($month == 'April') selected="" @endif>April</option>
                                                            <option value='May' @if($month == 'May') selected="" @endif>May</option>
                                                            <option value='June' @if($month == 'June') selected="" @endif>June</option>
                                                            <option value='July' @if($month == 'July') selected="" @endif>July</option>
                                                            <option value='August' @if($month == 'August') selected="" @endif>August</option>
                                                            <option value='September' @if($month == 'September') selected="" @endif>September</option>
                                                            <option value='October' @if($month == 'October') selected="" @endif>October</option>
                                                            <option value='November' @if($month == 'November') selected="" @endif>November</option>
                                                            <option value='December' @if($month == 'December') selected="" @endif>December</option>
                                                        </select>
                                                    
                                                </div>
                                                <div class="form-group">
                                                    
                                                        <select  class="form-control span11 select2"title="Select Year" data-live-search="true" data-selected-text-format="count"  data-actions-box="true"  data-header="Select Year" required="" name="year" data-sear value="{{ $year }}" id="year">
                                                            <option value="">--Select year--</option>
                                                            @for($i = 2019; $i<=2030; $i++)
                                                                <option value="{{ $i }}" @if($i == $year) selected="" @endif>{{ $i }}</option>
                                                            @endfor
                                                        </select>
                                                        @if($errors->has('year'))
                                                        <span class="help-block">
                                                          <strong>{{ $errors->first('year') }}</strong>
                                                      </span>
                                                      @endif
                                                 
                                                </div>
                                                <div class="form-group">
                                                    <a id="submit" class="btn btn-primary bg-orange">Submit</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-5"><br/>
                                     
                                    <div class="col-md-12 ">
                                         <div class="box-body table-responsive no-padding">
                                            <table id="emplog" class="table table-bordered table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>Date</th>
                                                        <th>Check In</th>
                                                        <th>Check Out</th>
                                                        <th>Check In</th>
                                                        <th>Check Out</th>
                                                        <th>Check In</th>
                                                        <th>Check Out</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    {{-- @if(!empty($employeelog))
                                                        @foreach($employeelog as $log)
                                                            <tr>
                                                                <td>{{ date('d-m-Y', strtotime($log->punchdate)) }}</td>
                                                                <td>{{ $log->checkin }}</td>
                                                                @if(!empty($log->checkout))
                                                                    <td>{{ $log->checkout }}</td>
                                                                @else
                                                                    <td><a href="{{ route('addpunch', $log->emplogid) }}" class="btn btn-danger">Miss</a></td>
                                                                @endif
                                                            </tr>
                                                        @endforeach   
                                                    @else
                                                        <tr>
                                                            <td colspan="5">No Data Found</td>
                                                        </tr>
                                                    @endif --}}
                                                </tbody>
                                            </table>
                                        </div>
                                             @if(!empty($employeelog))
                                            <center>{!!  $employeelog->render() !!} </center>
                                            @endif
                                        </div> 
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
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>	
<script type="text/javascript">
    $(document).ready(function(){

        $('#employeeid').change(function(){

            let empid = $(this).val();
            if(empid){
               $('#mobileno option[value='+empid+']').prop('selected', true);
           }
       });
        $('#submit').click(function(){
            $('#emplog').DataTable({
                processing : true,
                serverSide : true,
                destroy : true,
                ajax : {
                    url : '{{ route('searchemployeelog') }}', 
                    data : function(d){
                        d.employeeid = $('#employeeid').val(),
                        d.year = $('#year').val(),
                        d.month = $('#month').val()
                    }
                },
                columns: [
                {data: 'dateid', name: 'dateid'},
                {data: 'timein1', name: 'timein1'},
                {data: 'timeout1', name: 'timeout1'},
                {data: 'timein2', name: 'timein2'},
                {data: 'timeout2', name: 'timeout2'},
                {data: 'timein3', name: 'timein3'},
                {data: 'timeout3', name: 'timeout3'},
      
                ]
            });
        });
    });
</script>
@endpush