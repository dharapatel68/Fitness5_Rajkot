@extends('layouts.adminLayout.admin_design')
@section('content')
<style type="text/css">
	.content-wrapper{
		padding-right: 15px !important;
		padding-left: 15px !important;
	}
td{
	max-width: 20%;
}
.select2{
	width: 100% !important;
	
}
.select2-container--default .select2-selection--single{
	border-radius: 2px !important;
	max-height: 100% !important;
	    border-color: #d2d6de !important;
	        height: 32px;
	        max-width: 100%;
	        min-width: 100% !important;
}
</style>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
     	 <h1 style="text-decoration: none;">Payment Report</h1>
     </section>
      <section class="content">
      <!-- Info boxes -->
     	 <div class="row">
     	 	<div class="col-md-12">
     	 		<div class="row">
     	 			<div class="box box-info">
     	 				 <div class="box-header with-border">
			              <h3 class="box-title">Filters</h3>

			              <div class="box-tools pull-right">
			                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
			                </button>
			                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
			              </div>
			            </div>
			            <!-- /.box-header -->
			            <div class="box-body">
			            	<form action="{{url('paymentreport')}}" method="post">
			            		{{csrf_field()}}
							<div class="table-responsive">
							  <table class="table no-margin">
							  <thead>
							  <tr>
							    <th>From :</th>
							    <th>To :</th>
							    <th>Mode</th>
							    <th>Username</th>
							 	<th>Amount</th>
							    
							  </tr>
							</thead>
							<tbody>
					
							<tr>
							<td><input type="date" name="fdate" class="form-control" value="{{$query['fdate']}}"></td>
							<td><input type="date" name="tdate" class="form-control" value="{{$query['tdate']}}"></td>
							<td><select name="mode" class="form-control select2" id="mode" data-placeholder="Select a Mode" >
								<option value="" selected="" disabled="">Select a Mode</option>
								@foreach($modes as $mode)
								<option value="{{$mode->paymenttype}}" @if(isset($query['mode'])) {{$query['mode'] == $mode->paymenttype ? 'selected':''}} @endif>
									{{$mode->paymenttype}}
									 </option>
									@endforeach</select></td>




							<td><select name="username" class="form-control select2 span8" data-placeholder="Select a Username" >
								<option value="" selected="" disabled="">Select a Username</option>
								@foreach($users as $user)

								<option value="{{$user->userid}}"  @if(isset($query['username'])) {{$query['username'] == $user->userid ? 'selected':''}} @endif>
									
{{ $user->username }}              
							
									 </option>
									@endforeach</select></td>
									<td><input type="text" name="amount" class="form-control"value="{{$query['amount']}}"></td>
							
							
							</tr>
							<tr>
								
								<td><input type="text" name="keyword" placeholder="Search Keyword" class="form-control" value="{{$query['keyword']}}"></td>
								<td style="text-align: left" colspan="4"><button type="submit" name="search" class="btn bg-orange"><i class="fa fa-filter"></i>   Filters</button><a href="{{ url('paymentreport') }}" class="btn bg-red">Clear</a></td>
								
							</tr>
							

							</tbody>
							</table>

							</div>
						</form>
			            </div>	
     	 			</div>
     	 			<div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">All Payments</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="table-responsive">
                <table class="table no-margin">
                  <thead>
                  <tr>
                  	<th>Date</th>
                    <th>Invoice ID</th>
                    <th>Name</th>
                    <th>Mode</th>
                    <th>Amount</th>
                    <th>TakenBy</th>
                    <th>ReceiptNo</th>
                    <th>Company Name</th>
                  </tr>
                  </thead>
                  <tbody>
     					
                  	@if(count($paymentdata)>0)

                  	@foreach($paymentdata as $paymentreport)
                  	<tr>
                  		<td>{{date('d-m-Y', strtotime($paymentreport->date)) }}</td>
                  		<td>{{$paymentreport->invoiceno}}</td>
						<td>
							@if($paymentreport->firstname) {{ $paymentreport->firstname }} {{$paymentreport->lastname}}
@else {{ $paymentreport->rfirstname }} {{$paymentreport->rlastname}} @endif </td>
                  		<td>{{$paymentreport->mode}}</td>
                  		<td>{{$paymentreport->pamount}}</td>
                  		<td>{{$paymentreport->name}}</td>
                  		<td>{{$paymentreport->receiptno}}</td>
                  		<td>{{$paymentreport->companyname}}</td>
                  		
                  	</tr>
                  		@endforeach
                  		@else
                  		<tr><td colspan="8" style="text-align: center">{{ 'No Data Found'}}</td></tr>
                  		@endif
                  	
                  </tbody>
                </table>
                    <div class="datarender" style="text-align: center">
            {!! $paymentdata->render() !!}  </div>
              </div>
              <!-- /.table-responsive -->
            </div>
            <!-- /.box-body -->
        <!--     <div class="box-footer clearfix">
              <a href="javascript:void(0)" class="btn btn-sm btn-info btn-flat pull-left">Place New Order</a>
              <a href="javascript:void(0)" class="btn btn-sm btn-default btn-flat pull-right">View All Orders</a>
            </div> -->
            <!-- /.box-footer -->
          </div>
     	 		</div>
     	 	</div>

      	 </div>
 	  </section>
</div>
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
	$("#mode").select2({
    placeholder: "Select a Mode"
});
</script>
@endsection