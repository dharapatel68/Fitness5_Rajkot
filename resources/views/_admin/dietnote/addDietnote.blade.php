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
    
     
         <section class="content-header"><h2>Add Diet Note</h2></section>
          <!-- general form elements -->
           <section class="content">

          <div class="box box-primary">

            <div class="box-header with-border">
              <h3 class="box-title">Add Diet Note</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body"> <div class="col-lg-4"></div><div class="col-lg-4">


              <form role="form" action="{{ url('addDietnote') }}" method="post" id="dietnoteform" >
                 {{ csrf_field() }}
                <!-- text input -->
                <div class="form-group">
                 <label>Diet Note<span style="color: red">*</span></label>

                  <input type="text"  class="form-control" value="{{ old('dietnote') }}" maxlength="255" name="dietnote"  placeholder="Note">
                  @if($errors->has('dietnote'))
                    <span class="help-block">
                      <strong>{{ $errors->first('dietnote') }}</strong>
                    </span>
                  @endif

  
                </div>
               
              

                      <div class="form-group">
               
                  <div class="col-sm-6">
         <button type="submit" class="btn bg-orange btn-block">
         Save</button></div>   <div class="col-sm-6"> <a href="{{ url('viewDietnote') }}"class="btn btn-danger btn-block">Cancel</a></div>
     
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
    $('#dietnoteform').validate({
    
    });
  });
</script>
@endpush