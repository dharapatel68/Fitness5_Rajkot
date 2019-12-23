@extends('layouts.adminLayout.admin_design')
@section('content')
<style type="text/css">
	.content-wrapper{
		padding-right: 15px !important;
		padding-left: 15px !important;
	}
td{
	max-width: 10%;
}
table td{
  width: 10% !important;
  max-width: 10% !important;
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
     	 <h1 style="text-decoration: none;">Activity Report</h1>
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
			            	<form action="{{url('activityreport')}}" method="post">
			            		{{csrf_field()}}
							<div class="table-responsive">
							  <table class="table no-margin">
							  <thead>
						  <tr>
							    <th>From :</th>
							    <th>To :</th>
							  
							    <th>Username</th>
                  <th>Any Keyword</th>

							    
							  </tr>
							</thead>
							<tbody>
					
							<tr>
							<td><input type="date" name="fdate" class="form-control" value="{{$query['fdate']}}"></td>
							<td><input type="date" name="tdate" class="form-control" value="{{$query['tdate']}}"></td>
					
							<td><select name="username" class="form-control select2 span8" data-placeholder="Select a Username" >
								<option value="" selected="" disabled="">Select a Username</option>
								@foreach($users as $user)

								<option value="{{$user->userid}}"  @if(isset($query['username'])) {{$query['username'] == $user->userid ? 'selected':''}} @endif>
									
									{{ $user->first_name }} {{ $user->last_name }} 
              
							
									 </option>
									@endforeach</select></td>
                    <td><input type="text" name="keyword" placeholder="Search Keyword" class="form-control" value="{{$query['keyword']}}"></td>
								
							
							</tr>
							<tr>
							
								<td style="text-align: left" colspan="4"><button type="submit" name="search" class="btn bg-orange"><i class="fa fa-filter"></i>   Filters</button><a href="{{ url('activityreport') }}" class="btn bg-red">Clear</a></td>
								
							</tr>
							

							</tbody>
							</table>

							</div>
						</form>
			            </div>	
     	 			</div>
     	 			<div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title"></h3>

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
                    <th>User</th>
                    <th>Action</th>
                    

                  </tr>
                  </thead>
                  <tbody>
                    @foreach($data as $data1)  
                     <tr>

                      <td>{{date('d-m-Y', strtotime($data1->created_at))}}</td>
                       <td>{{ $data1->first_name }} {{ $data1->last_name }} </td>
                        <td>{{$data1->details}}</td>
                          
                     </tr>
     		           @endforeach

	
                  	
                  </tbody>
                </table>
                    <div class="datarender" style="text-align: center">
                         {{ $data->links() }}    
          </div>
              </div>
              <!-- /.table-responsive -->
            </div>
   
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