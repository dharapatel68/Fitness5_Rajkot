@extends('layouts.adminLayout.admin_design')
@push('css')
<style type="text/css">
  strong{
    color: red;
  }
</style>
@endpush
@section('content')
<!-- left column -->

  <div class="content-wrapper">
   
     
         <section class="content-header"><h2>Add Workout</h2></section>
          <!-- general form elements -->
           <section class="content">

  
           <!-- @if ($errors->any())

            <div class="alert alert-danger">
                 <button type="button" class="close" data-dismiss="alert">×</button> 
            <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
            </ul>
            </div>
            @endif -->

          <div class="box box-primary">

            <div class="box-header with-border">
              <h3 class="box-title">Add Workout</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body"> <div class="col-lg-4"></div><div class="col-lg-4">

              <form role="form" action="{{ url('addExercise') }}" method="post" id="exercise_form">

                 {{ csrf_field() }}
                <!-- text input -->
                <div class="form-group">
                  <label>Exercise<span style="color: red">*</span></label>
                  <input type="text" class="form-control" maxlength="255" value="{{ old('exercisename') }}" name="exercisename" required placeholder="Exercise Name">
                  @if($errors->has('exercisename'))
                    <span class="help-block">
                      <strong>{{ $errors->first('exercisename') }}</strong>
                    </span>
                  @endif

              <!--<form role="form" action="{{ url('addExercise') }}" method="post"id="exercise_form" >
                 {{ csrf_field() }}
                <!-- text input -->
             <!--    <div class="form-group">
                   <label>Exercise<span style="color: red">*</span></label>
                  <input type="text" class="form-control" maxlength="255" value="{{ old('exercisename') }}" name="exercisename" required placeholder="Exercise Name">
                  @if($errors->has('exercisename'))
                    <span class="help-block">
                      <strong>{{ $errors->first('exercisename') }}</strong>
                    </span>
                  @endif  --> 

                </div>
                <div class="form-group">
                  <label>Video Link</label>
                   
                <input type="text" name="file" class="form-control" id="profileimage" class="span11" placeholder="http://example.com/videolink" />
               
                </div>
              

                      <div class="form-group">
               
                  <div class="col-sm-6">
         <button type="submit" class="btn bg-orange btn-block">
         Save</button></div>   <div class="col-sm-6"> <a href="{{ url('viewExercise') }}"class="btn btn-danger btn-block">Cancel</a></div>
     
      </div>
                <!-- Select multiple-->
        

              </form></div><div class="col-lg-3"></div>
            </div>
            <!-- /.box-body -->
          </div>
      
  </section>
</div>
</div>
</div>
@endsection
@push('script')
<script type="text/javascript">
  $(document).ready(function(){
    $('#exercise_form').validate({
      /*rules: {
        username : {
          required : true,
          maxlength : 255
        },
        email : {
          required : true,
          maxlength : 255
        }
      }*/
    });
  });
</script>
@endpush