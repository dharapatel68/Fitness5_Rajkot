<?php 
 include('..///config/database.php');
 include('..///config/session.php');
?>

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
<script src="{{ asset('bower_components/bootstrap/js/cdnjs-extra/jquery.easing.min.js') }}"></script>


<style type="text/css">

   .table-bordered {
    border: 1px solid #f4f4f4;
}
 </style>

<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0/jquery.js"></script>
<script data-require="datatables@*" data-semver="1.10.12" src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.13/js/dataTables.bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.1.0/js/dataTables.responsive.js"></script> -->
  <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script> -->
  <style type="text/css">
    .customcheck {
    display: block;
    position: relative;
    padding-left: 35px;
    margin-bottom: 12px;
    cursor: pointer;
    font-size: 22px;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
}

/* Hide the browser's default checkbox */
.customcheck input {
    position: absolute;
    opacity: 0;
    cursor: pointer;
}

/* Create a custom checkbox */
.checkmark {
    position: absolute;
    top: 0;
    left: 0;
    height: 25px;
    width: 25px;
    background-color: #babbba;
    border-radius: 5px;
}

/* On mouse-over, add a grey background color */
.customcheck:hover input ~ .checkmark {
    background-color: #ccc;
}

/* When the checkbox is checked, add a blue background */
.customcheck input:checked ~ .checkmark {
    background-color: #00c0ef;
    border-radius: 5px;
}

/* Create the checkmark/indicator (hidden when not checked) */
.checkmark:after {
    content: "";
    position: absolute;
    display: none;
}

/* Show the checkmark when checked */
.customcheck input:checked ~ .checkmark:after {
    /*display: block;*/
    content: "";
    color: #20b904;
}

/* Style the checkmark/indicator */
.customcheck .checkmark:after {
    left: 9px;
    top: 5px;
    width: 5px;
    height: 10px;
    border: solid white;
    border-width: 0 3px 3px 0;
    -webkit-transform: rotate(45deg);
    -ms-transform: rotate(45deg);
    transform: rotate(45deg);
  </style>


  <div class="content-wrapper">
   
     
         <section class="content-header"><h2>GST Report</h2></section>
          <!-- general form elements -->
           <div class="content">
          
              @if ($errors->any())
            <div class="alert alert-danger">
            <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
            </ul>
            </div>
            @endif
            <div class="box box-primary">
 <form role="form" action="{{ url('gstreport')}}" method="post" >
            <div class="box-header with-border">
               <button id="getexcel" type="submit"  class="btn bg-orange" style="float: right; margin-right: 15px;"><i class="fa fa-file-excel-o"></i>   getexcel </button>
              <h3 class="box-title">GST Report</h3>
            </div>

            <!-- /.box-header -->
            <div class="box-body">
             

                @foreach($gstall as $g)

                 <input type="hidden" name="gstreport[]" value="{{$g}}">
                 @endforeach
                
                 {{ csrf_field() }}
               
                 <div class="table-responsive">

                <table id="gstreport"class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
                  <thead>@if($gst)
                  
                    <th>InvoiceID</th>
                    <th>Member</th>
                    <th>Payment Date</th>
                    <th>Amount</th>
                    <th>Type</th>
                    <th>GST</th>
                    <th>GST amount</th>
                    <th>GST No</th>
                    <th>Company Name</th>
                  </thead>
                  <tbody>

                      @foreach($gst as $g)
                    <tr>
                    <td>{{$g->receiptno}}</td>
                    <td>{{$g->firstname}}{{$g->lastname}}</td>
                    <td>{{date('d-m-Y', strtotime( $g->paymentdate))  }}</td>
                    <td>{{$g->pamount}}</td>
                    <td>@if($g->mode != 'no mode') {{$g->mode}} @else{{'No mode'}}@endif</td>
                    <td>{{$g->ptax}}</td>
                    <td>{{$g->taxamount}}</td>
                    
                    @php 
                    $companyname='';
                    $gstno='';
                    if($g->companyid != ''){
                       $companyname1=\App\Company::where('companyid',$g->companyid)->where('status',1)->get()->first();
                    $companyname=$companyname1->companyname;
                    $gstno=$companyname1->gstno;
                  }
                 
                    @endphp
                    <td>{{$gstno}}</td>
                    <td>{{$companyname}}</td>
                  </tr>
                  @endforeach
                  </tbody>
                  @endif
                  
                </table>
                  <div class="datarender" style="text-align: center">
                         {{ $gst->links() }}    
          </div>
                </div>

               </form>
            </div>
          </div>

</div>
</div>

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script  src="{{ asset('bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('bower_components/datatables.net/js/dataTables.bootstrap.min.js') }}"></script>
<script src="{{ asset('bower_components/datatables.net/js/dataTables.responsive.js') }}"></script>
      <script>
        $(function () {

  })
// 
 
  $('#gstreport1').DataTable({
       stateSave: false,
       Sortable: true,
       paging:  true,
       "lengthMenu": [[10, 15, -1], [10, 15, "All"]]
   });
</script>
@endsection

