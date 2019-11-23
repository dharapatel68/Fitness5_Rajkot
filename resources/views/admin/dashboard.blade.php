@extends('layouts.adminLayout.admin_design')
@section('content')
<link rel="stylesheet" href="{{ asset('bower_components/Ionicons/css/ionicons.min.css') }}">
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
<!-- Theme style -->
<link rel="stylesheet" href="{{ asset('dist/css/AdminLTE.min.css') }}">

<link rel="stylesheet" href="{{ asset('dist/css/skins/_all-skins.min.css') }}">
<script src="{{ asset('bower_components/datatables.net/js/jquery.js') }}"></script>
<script data-require="datatables@*" data-semver="1.10.12" src="{{ asset('bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('bower_components/datatables.net/js/dataTables.bootstrap.min.js') }}"></script>
<script src="{{ asset('bower_components/datatables.net/js/dataTables.responsive.js') }}"></script>
<style type="text/css">
  .red{
    color: red;
  }
  .info-box-icon{
      height: 110px;
      width: 100px;
  }
  .info-box-text{
    margin-left: 5px;
    text-transform: none; */

  }
   .label{
      font-size: 85%;
    }
table, th, td {
  padding: 5px;
}
</style>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1 style="text-decoration: none">
      Dashboard
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li>Dashboard</li>
      </ol>
    </section>

<script type="text/javascript">
$(document).ready( function () {
    $('#contractdata').DataTable();
} );
</script>
    <!-- Main content -->
     
    <section class="content">
        
 
<div class="container-fluid"> 
  @if( session('role')== 'admin')
  <div class="row">
     @if( session('role') == 'admin' ||  session('role') == 'manager')
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
               <p>Today's Inquiry</p>
              <h3>{{$data['numberofinquirytoday']}}</h3>
               <div class="info-box-content"> 
              <label>Total</label>
                {{$data['numberofinquirytotal']}}
             </div>
          
            </div>
            <div class="icon">
              <i class="fa fa-shopping-cart"></i>
            </div>
            <a href="{{url('inquiry')}}" class="small-box-footer">
              More info <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
               <p>New Members</p>
              <h3>{{$data['numberofmembertoday']}}</h3>
                 <div class="info-box-content"> 
              <label>Total</label>
                {{$data['numberofmembertotal']}}
             </div>
             
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="{{url('members')}}" class="small-box-footer">
              More info <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <p>Today's payment</p>
              <h3>{{$data['paymenttoday']}}</h3>
                 <div class="info-box-content"> 
              <label>Total</label>
                {{$data['paymenttotal']}}
             </div>
              
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a  class="small-box-footer">
              More info <i class="fa fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">

          <div class="small-box bg-red">
            <div class="inner">
              <p>Member Count</p>
              <h3>{{$data['membercounttoday']}}</h3>
                 <div class="info-box-content"> 
              <label>Total</label>
                {{$data['membercounttotal']}}
             </div>
              
            </div>
            <div class="icon">
              <i class="ion ion-pie-graph"></i>
            </div>
            <a  class="small-box-footer" href="{{ route('todaymember') }}"> More info 
            <i class="fa fa-arrow-circle-right" ></i>
            </a>
          </div>

        </div>

        <!-- ./col -->
  </div>
  @endif


   
      <div class="row" style="display: block;">
        <div class="col-md-8">
          <div class="box">
                 <div class="box-header with-border">
                <h3 class="box-title">Renewal List</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
           
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            
               <div class="box-body">
                 <div class="table-responsive">
                 <table id="packageexpire" class="table table-bordered table-striped">
              <thead>
                <tr>
                  
                  <th>Member Name</th>
                  <th>Package</th>
                  <th>Expire on</th>
                  <th>Days</th>
                </tr>
              </thead>
             <tbody>
              
              @if($packageexpirenearly)

              @foreach($packageexpirenearly as $key => $packageexpire)
            
               <tr>
                  <td>{{$packageexpire->firstname}} {{$packageexpire->lastname}}</td>
                 <td>{{$packageexpire->schemename}}</td>
                 <td>{{date('j F, Y', strtotime($packageexpire->expiredate))}}</td>
                 <td @if($packageexpire->diff == "Expired") class='red'@endif>{{str_replace("+", "", $packageexpire->diff)}}</td>
                
               </tr>
               @endforeach
               @endif
             </tbody>
            </table>
                </div>

               
               </div>
          </div>
        </div>
      </div>
 
        <div class="row">
        <div class="col-md-8">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Due Payment</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
           
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <!-- /.box-header -->
          <div class="box-body">
            <div class="table-responsive">
            <table id="duepayment" class="table table-bordered table-striped table-responsive">
              <thead>
                <tr>
                  
                  <th>Member Name</th>
                  <th>Due Date</th>
                  <th>Amount</th>
                </tr>
              </thead>
             <tbody>

              @foreach($duepayment as $key => $payremain)
              @if($payremain['remainingamount'])
               <tr>
                <td>{{$payremain['firstname']}} {{$payremain['lastname']}}</td>
                 <td><span class='hide'>{{$payremain['duedate']}}</span>{{date('d-m-Y', strtotime($payremain['duedate']))}}</td>
                 <td> <a  class="btn bg-light-navy" href="{{url('remainingplaceorder/'.$payremain['invoiceno'])}}"> <span class="label label-warning">{{$payremain['remainingamount']}}  <span style="font-family: DejaVu Sans; sans-serif;"> &#8377;</span></a></span> 
                 </td>

               </tr>
                @endif
               @endforeach
             </tbody>
            </table>
            </div>
          </div>
            <!-- ./box-body -->
           
            <!-- /.box-footer -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      @endif
     </div>

    </section>
  </div>


<script type="text/javascript" src="//cdn.datatables.net/plug-ins/1.10.19/sorting/date-euro.js"></script>

      <script type="text/javascript">

  $(function () {
 

 $('#packageexpire').DataTable({
     'paging'      : true,
   "order": [[ 0, "Desc" ]], //or asc 
    columnDefs: [
       { type: 'date-euro', targets: 0 }
     ]
});
  /*$('#duepayment').DataTable({
     'paging'      : true,
     columnDefs: [
       { type: 'date-euro', targets: 3 }
     ]
//or asc 
    
});*/
$('#duepayment').DataTable({
  'paging'      : true,
  'order': [ 0, "Desc" ],
  columnDefs : [{ type: 'date-euro', targets: 0 }]
});
 

})

</script>

  
    
@endsection
