@extends('layouts.adminLayout.admin_design')
@section('content')
   <link rel="stylesheet" href="{{ asset('bower_components/Ionicons/css/ionicons.min.css') }}">
  <!-- DataTables -->
  <link rel="stylesheet" href="{{ asset('bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('dist/css/AdminLTE.min.css') }}">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="{{ asset('dist/css/skins/_all-skins.min.css') }}">

<script src="{{ asset('bower_components/datatables.net/js/jquery.js') }}"></script>

<style type="text/css">
  
</style>

  <div class="content-wrapper">
<section class="content-header"><h2>All Scheme</h2></section>
<div class="container-fluid"> 
  @if ($message = Session::get('message'))
<div class="alert alert-success alert-block">
  <button type="button" class="close" data-dismiss="alert">×</button> 
   <strong>{{ $message }}</strong>
</div>
@endif 

   <div class="table-wrapper">
    <div class="table-title">

   <div class="box-header">
       
    </div>
<section class="content">
      <div class="row">
        <div class="col-xs-12">
          

          <div class="box">
            <div class="box-header">
              <?php $permission = unserialize(session()->get('permission')); ?>
                @if(isset($permission["'add_scheme'"]))
                <a href="{{ url('addscheme') }}" class="btn add-new bg-navy"><i class="fa fa-plus"></i>Add New</a>
                @endif
               <h3 class="box-title">All Schemes</h3>
            </div>

            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" cellspacing="0" width="100%" class="table table-striped table-bordered dt-responsive">
                <thead>
                <tr>
                <th>RootScheme</th>
                <th>Scheme</th>
                <th>Number Of Days</th>
                <th>Base Price</th>
               
                <!-- <th>Tax</th> -->
                <th>Actual Price</th>
                 <th>Validity</th>
                <th>Status</th>
                <th>Actions</th>
                 
                </tr>
                </thead>
                <tbody>
                 @foreach($schemes as $scheme)
                <tr>
                <td> {{ $scheme->RootScheme->rootschemename }}</td>
                <td> {{ $scheme->schemename }}</td>
                <td> {{ $scheme->numberofdays }}</td>
                <td> {{ $scheme->baseprice }}</td>
                <!-- <td> {{ $scheme->Tax }}</td> -->
                <td> {{ $scheme->actualprice }}</td>
                @if($scheme->validity)
                <td><span class='hide'>{{$scheme->validity}}</span>{{date('d-m-Y', strtotime($scheme->validity))}}</td>
                @else
                <td></td>
                @endif
                <td>
                  {{ $scheme->status == '1' ? 'active' : 'Deactive' }} </td>
                  <td>
                    @if(isset($permission["'edit_scheme'"]))
                    <a href="{{ url('editscheme/'.$scheme->schemeid) }}"class="edit" title="Edit"><i class="fa fa-edit"></i></a>
                    @endif             
                </tr>
                 @endforeach
                </tbody>
            
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>

<!-- page script -->



</div>
</div>
</div>
</div>
@push('script')
<script data-require="datatables@*" data-semver="1.10.12" src="{{ asset('bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('bower_components/datatables.net/js/dataTables.bootstrap.min.js') }}"></script>
<script src="{{ asset('bower_components/datatables.net/js/dataTables.responsive.js') }}"></script>
<script type="text/javascript">
  $(document).ready(function(){
    $('#example1').DataTable();
  });
</script>
@endpush
@endsection