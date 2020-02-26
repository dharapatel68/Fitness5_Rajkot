@extends('layouts.adminLayout.admin_design')
@section('content')
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
        <div class="col-lg-8">
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
                <th style="display: none"></th>
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
