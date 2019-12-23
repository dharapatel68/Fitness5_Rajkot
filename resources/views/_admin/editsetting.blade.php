@extends('layouts.adminLayout.admin_design')
@section('content')
 <div class="content-wrapper">
       
         <section class="content-header"></section>
          <!-- general form elements -->
           <section class="content">
               @if ($errors->any())
            <div class="alert alert-danger">
                 <button type="button" class="close" data-dismiss="alert">×</button> 
            <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
            </ul>
            </div>
            @endif
         
          <div class="box box-primary">

            <div class="box-header with-border">
              <h3 class="box-title">Edit Setting</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body"><div class="col-lg-3"></div><div class="col-lg-6">
              <form role="form" action="{{ url('editsetting/'.$setting->adminmasterid) }}"  method="post">
                 {{ csrf_field() }}
                <!-- text input -->
               <div class="form-group">
                  <label>Tax Title</label>
                  <input type="text" class="form-control" name="title" placeholder="Title" value="{{$setting->title}}" required="" readonly="">
  
                </div>
                <div class="form-group">
                  <label>Value</label>
                    <input type="number"  required="" min="0"  class="form-control" name="description" minlength="1" value="{{$setting->description}}">
                     <input type="hidden" name="oldtax"value="{{$setting->description}}">
               
                </div>
            
                <div class="form-group">
                  <div class="col-sm-offset-3">
                  <button type="submit" class="btn bg-orange margin">
                    Update</button>


         <a href="{{ url('settings') }}"class="btn bg-red margin">Cancel</a>
        </div>
     
              </form></div>
            </div>

          </div>
      
  </section>
</div>
</div>
</div>
@endsection