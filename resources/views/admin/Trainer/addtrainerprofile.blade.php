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
     	 <h1 style="text-decoration: none;">Trainer Profile</h1>
     </section>
      <section class="content">
       
            @if($errors->any())
          <div class="alert alert-danger alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button> 
             <strong>{{$errors->first()}}</strong>
          </div>
        @endif 
      <!-- Info boxes -->
      <div class="row">
        <div class="col-md-12">
          <div class="row">
            <div class="box box-info">
              <div class="box-header with-border">
                <h3 class="box-title">Trainer Profile</h3>

              <div class="box-tools pull-right">
              <!--   <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button> -->
              
              </div>
              </div>
              <div class="box-body">
                <div class="box-body">
              <form name="refreshForm">
                <input type="hidden" name="visited" value=""/>
              </form>
              <div class="col-lg-8">
                <form action="{{ url('addtrainerprofile')}}" role="form" method="post" class="form-horizontal" enctype="multipart/form-data">
                  {{csrf_field()}}

                
                  <div id="specific" >
                      <div class="form-group">
                        <label for="productid" class="col-sm-4 control-label">Select Trianer</label>
                        <div class="col-sm-8">
                          <select id="trainerid" class="form-control select2" data-placeorder="--Select Trainer--" name="trainerid">
                            @if(!empty($trainer))
                              <option value="" disabled="" selected="">--Select Trainer--</option>
                              @foreach($trainer as $tr )
                                <option value="{{ $tr->employeeid }}">{{ $tr->username }}</option>
                              @endforeach
                            @else
                              <option value="">--No Company Available--</option>
                            @endif
                          </select>
                          @if($errors->has('companyid'))
                            <span class="help-block">
                              <strong>{{ $errors->first('companyid') }}</strong>
                                </span>
                          @endif
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="city" class="col-sm-4 control-label">City</label>
                        <div class="col-sm-8">
                        <input type="text" name="city" class="form-control">
                       
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="level" class="col-sm-4 control-label">Level Of Trainer</label>
                        <div class="col-sm-8">
                        <input type="text" name="level" class="form-control">
                       
                        </div>
                      </div>
                     <div class="form-group">
                        <label for="Exp" class="col-sm-4 control-label">Exp.</label>
                        <div class="col-sm-8">
                        <input type="text" name="exp" class="form-control">
                       
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="Achievments" class="col-sm-4 control-label">Achievments</label>
                        <div class="col-sm-8">
                        <input type="text" name="achievments" class="form-control">
                       
                        </div>
                      </div>
                       <div class="form-group">
                        <label for="productgroupid" class="col-sm-4 control-label">Free Slots</label>
                        <div class="col-sm-8">
                        <input type="text" name="slots" class="form-control">
                        </div>
                      </div>
                      
                      <div class="form-group">
                        <label for="results" class="col-sm-4 control-label">Photo</label>
                        <div class="col-sm-8">
                      
                        <input type="file" name="photo" id="photo" class="form-control"  accept="image/jpg, image/jpeg, image/png">
                        <img src="" id="img" height="100px">
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="results" class="col-sm-4 control-label">Results</label>
                        <div class="col-sm-8">
                              <input id="file-input" type="file" multiple name="results[]" class="form-control">
                          <div id="preview"></div>
                             
                        </div>
                      </div>
                    <br>
                  <div class="form-group">
                    <div class="col-sm-offset-6 col-sm-6">
                      <button name="add" type="submit" id="add" class="btn btn-success"><span class="fa fa-plus"></span>
                        Add
                      </button>
                      <button name="deduct" type="submit" id="deduct" class="btn btn-danger" style="display: none;">
                        <span class="fa fa-minus"></span> Deduct
                      </button>
                      <a href="{{ url('viewstock') }}" type="button" class="btn btn-default">Cancel</a>
                    </div>
                  </div>
                </form>
              </div>
            </div>
              </div>	
            </div>
          </div>
        </div>
      </div>
 	  </section>
</div>
<script type="text/javascript">
              $('#photo').change(function(){

                   var input = this;
                   var url = $(this).val();
                   var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
                  if (input.files && input.files[0]&& (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg")) 
                   {
                     var reader = new FileReader();
   
                     reader.onload = function (e) {
                      $('#img').attr('src', e.target.result);
                    }
                    reader.readAsDataURL(input.files[0]);
                  }
                  else
                  {
                   $('#img').attr('src', '/assets/no_preview.png');
                 }
               });

              function previewImages() {

                var $preview = $('#preview').empty();
                if (this.files) $.each(this.files, readAndPreview);

                  function readAndPreview(i, file) {

                  if (!/\.(jpe?g|png|gif)$/i.test(file.name)){
                    return alert(file.name +" is not an image");
                } // else...

                var reader = new FileReader();

                 $(reader).on("load", function() {
                   $preview.append($("<img/>", {src:this.result, height:100}));
                });

                reader.readAsDataURL(file);

                }

              }

$('#file-input').on("change", previewImages);
   </script>
<script type="text/javascript">

  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()

    //Datemask dd/mm/yyyy
    $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' });
    //Datemask2 mm/dd/yyyy
    $('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' });
    //Money Euro
    $('[data-mask]').inputmask();

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