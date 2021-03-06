@extends('layouts.adminLayout.admin_design')
@section('content')
<link rel="stylesheet" href="{{ asset('bower_components/Ionicons/css/ionicons.min.css') }}">
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
<!-- Theme style -->
<link rel="stylesheet" href="{{ asset('dist/css/AdminLTE.min.css') }}">

<link rel="stylesheet" href="{{ asset('dist/css/skins/_all-skins.min.css') }}">
<script src="{{ asset('bower_components/datatables.net/js/jquery.js') }}"></script>
<script  src="{{ asset('bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('bower_components/datatables.net/js/dataTables.bootstrap.min.js') }}"></script>
<script src="{{ asset('bower_components/datatables.net/js/dataTables.responsive.js') }}"></script>

<style type="text/css">
.content-wrapper{
    padding-right: 15px !important;
    padding-left: 15px !important;
}
</style>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1 style="text-decoration: none;">Session Report</h1>
     </section>
      <section class="content">
        <div class="row">
        <div class="col-lg-12">
        <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Member Session</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>

                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
            </div>
            </div>
            <div class="box-body">
            <div class="table-responsive">
                <table id="membersession" class="table table-bordered table-striped">
            <thead>
                <tr>
         
                <th>Member Name</th>
                <th>Scheme Name</th>
                <th>Active/Pending Session</th>
                <th>Deducted Session</th>
                </tr>
            </thead>
            <tbody>
            @if(count($trainersession2)>0)
            <tr>

                @foreach($trainersession2 as $trainersession1)
                <td>{{$trainersession1->firstname}}  {{$trainersession1->lastname}}</td>
                <td>{{$trainersession1->schemenameprint}}</td>
                <td>{{$trainersession1->activecount}}</td>  
                <td>{{$trainersession1->deductedcount}}</td>
            </tr>
            @endforeach
            @endif
            </tbody>
            </table>
            <div class="datarender" style="text-align: center">
            </div>
        
            </div>
            </div>
        </div>
        </div>
  </div>
      </section>
</div>
@endsection
@push('script')
<script type="text/javascript">
$('#membersession').DataTable({
    'paging'      : true,
    'lengthChange': false,
    'searching'   : true,
    'ordering'    : true,
    'info'        : false,
    'autoWidth'   : false
  });
</script>
@endpush