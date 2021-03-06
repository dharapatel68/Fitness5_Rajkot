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
 <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<style type="text/css">
  .red{
    color: red;
  }
  a {
    color: #131313;
}
  .green{
    color:green;
  }
  .info-box-icon{
      height: 110px;
      width: 100px;
  }
  .info-box-text{
    margin-left: 5px;
    text-transform: none; */

  }
  .call{
  color: #7758EE;
}
   .label{
      font-size: 85%;
    }
table, th, td {
  padding: 5px;
}
.ui-state-active,
.ui-widget-content .ui-state-active,
.ui-widget-header .ui-state-active,
a.ui-button:active,
.ui-button:active,
.ui-button.ui-state-active:hover {
  border: 1px solid #003eff;
  background: #97a0b3;
  font-weight: normal;
  color: #000;
  border-color: #97a0b3;
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
  @if( session('role')== 'admin' ||  session('role') == 'manager' || session('role') == 'Manager')
  <div class="row">
     @if( session('role'))
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
            <a href="{{url('addinquiry')}}" class="small-box-footer">
            Add  <i class="fa fa-plus"></i>
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
            <a href="{{url('addMember')}}" class="small-box-footer">
              Add  <i class="fa fa-plus"></i>
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
              <i class="fa fa-inr"></i>
            </div>
            <a   href="{{url('paymentreport')}}" class="small-box-footer">
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
              <i class="fa fa-paw"></i>
            </div>
            <a  class="small-box-footer"> More info 
            <i class="fa fa-arrow-circle-right" ></i>
            </a>
          </div>

        </div>

        <!-- ./col -->
  </div>
  @endif
  <div class="row">

          <div class="col-lg-6 col-xs-12">
              <div class="box">
                 <div class="small-box" style="margin-top:-5px;">
                        <div class="icon">
                          <i class="fa fa-user"></i>
                        </div>  
                      </div> 
                <div class="box-header with-border">
                    
                  <div class="box-body">
                 
                  <div class="col-lg-10 col-sm-10">
                    <div class="input-group">
                      <input type="text" class="form-control" id="project" autofocus=""  placeholder="Enter Username" >
                      <span class="input-group-addon"><i class="fa fa-search"></i></span>
                    </div>
                    <input type="hidden" id="project-id"> 
                    <p id="project-description" class="small-text"></p>
                    <div class="form-group open">
                    </div>
                  </div>
                    <div class="col-lg-4 col-sm-2">
                      <button type="button" class="btn btn-primary" style="margin-top: 0px; display: none" data-toggle="modal" data-target="#exampleModalLong" id="checkuser" >Check</button>
                    </div>
                    </div>
                </div>
              </div>
          </div>
             <div class="col-lg-6 col-xs-12">
              <div class="box" style="height:109px;">
                <div class="box-header with-border">
                  <div class="box-body">
                    <a href="{{url('addinquiry')}}" class="btn btn-social">
                       <i class="fa fa-pencil"></i> Inquiry
                        </a>
                     <a  href="{{url('addMeasurement')}}" class="btn  btn-social"> <i class="fa fa-user-plus "></i>Measurement</a>
                     <a  href="{{url('directmessage')}}" class="btn  btn-social"> <i class="fa fa-envelope"></i>SMS</a>
                    </div>
                </div>
              </div>
          </div>
      </div>


   <div class="row">

  <div class="col-lg-6">
    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Collection</h3>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
          </div>
      </div>
      <div class="box-body">
                      
        <div class="table-responsive">
          <table id="collection" class="table  table-striped" style="width:100%">
            <thead>
              <tr>
               
                  <th style="display: none;">id</th>
                <th>Root Scheme</th>
                
                <th>Today</th>
                <th>This Month</th>
               
                <th>Total</th>
              
           
               
              </tr>
            </thead>
                 <tbody>
            @if($collection)

              @foreach($collection as $key => $collec)
              <tr>
                      
                <td style="display: none">{{$collec->rootschemeid}}</td>
                <td>{{$collec->rootschemename}}</td>
                <td>{{$collec->daywisetotal  ? $collec->daywisetotal : 0  }}</td>
                <td>{{$collec->monthwisetotal ? $collec->monthwisetotal : 0  }}</td>
                <td>{{$collec->yearwisetotal ? $collec->yearwisetotal : 0  }}</td>
              </tr>
              @endforeach
            @endif
          </tbody>
          </table>
        </div>
        <div class="datarender" style="text-align: center">
             
        </div>
                       
      </div>
    </div>
  </div> 
     <div class="col-lg-6">
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
                     
                <table id="duepayment" class="table table-striped">
                  <thead>
                    <tr>

                      <th>Member Name</th>
                      <th>Due Date</th>
                      <th>Amount</th>
                    </tr>
                  </thead>
                  <tbody>

                    @foreach($duepayment as $key => $payremain)
                    
                    <tr>
                      <td>{{$payremain['firstname']}} {{$payremain['lastname']}}</td>
                      <td>{{date('d-m-Y', strtotime($payremain['duedate']))}}</td>
                     <td> <a  class="btn bg-light-navy" href="{{url('remainingplaceorder/'.$payremain['invoiceno'])}}"> <span class="label label-danger">{{$payremain['remainingamount']}}  <span style="font-family: DejaVu Sans; sans-serif;"> &#8377;</span></a></span> 
                 </td>

                    </tr>
                  
                    @endforeach
                  </tbody>
                </table>
           
            </div>
              <!-- ./box-body -->

              <!-- /.box-footer -->
            </div>
          </div>
      </div>
       
  
</div>
      <div class="row" style="display: block;">
        <div class="col-lg-6">
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
                   <td>{{date('d-m-Y', strtotime($packageexpire->expiredate))}}</td>
                   <td @if($packageexpire->diff == "Expired") class='red'@endif><a href="{{url('assignPackageOrRenewalPackage/'.$packageexpire->userid)}}"><span class="label label-success">{{str_replace("+", "", $packageexpire->diff)}}</span> </a> </td>
               </tr>
               @endforeach
               @endif
             </tbody>
            </table>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-6">
          <div class="box">
              <div class="box-header with-border">
                <h3 class="box-title">Today's Followup</h3>
                <div class="box-tools pull-right">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                  </button>

                  <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
              </div>
              <div class="box-body table-responsive">
               
              <table id="package" class="table">
                <thead>
                  <tr>
                    <th>Name</th>
                    <th>MobileNo</th>
                    <th>FollowupTime</th>
                    <th>Rating</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  @if($followup)
                    <?php $i=0; ?> 
                    @foreach($followup as $key => $flup)
                      <tr>
                        <td style="display: none;">{{$flup->inquiriesid}}</td>
                        <td>{{$flup->firstname}}   {{$flup->lastname}} </td>
                        <td>{{$flup->mobileno}}</td>
                        <td>{{ $flup->followuptime != null ? $flup->followuptime : '' }}</td>
                        <td class="{{ $flup->callrating == 'cold' || $flup->callrating == 'notinterested' ? 'red' : 'green'}}">{{ ucfirst($flup->callrating)}}</td>
                         <td><a href="{{url('viewfollowupprofile/'.$flup->inquiriesid)}}"class="Add" title="View Inquiry Profile" id="viewfollowupprofile{{$i}}"><i class="fa fa-eye"></i></a>
                            <a href="{{ url('viewfollowup/'.$flup->inquiriesid) }}"class="call" id="addfollowup{{$i}}" title="Add Followup" onclick="call()"><i class="fa fa-phone"></i></a>
                      </tr>
                    @endforeach
                  @endif
                </tbody>
              </table>
             </div>
          </div>
         </div>
      </div>
      <div class="row" style="display: block;">
         <div class="col-lg-6">
          <div class="box">
              <div class="box-header with-border">
                <h3 class="box-title">Today's Birthday</h3>
                <div class="box-tools pull-right">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
              </div>
              <div class="box-body table-responsive">
              <table id="package" class="table">
                <thead>
                  <tr>
                    <th>Name</th>
                    <th>MobileNo</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                    <?php $i=0; ?> 
                    @foreach($data['todaybday'] as $key => $tbday)
                      <tr>
                        <td>{{$tbday->firstname}}   {{$tbday->lastname}} </td>
                        <td>{{$tbday->mobileno}}</td>
                        <td><a href="{{ url('memberProfile/'.$tbday->memberid) }}"<i class="fa fa-eye"></i></td>
                      </tr>
                    @endforeach
                </tbody>
              </table>
             </div>
          </div>
         </div>
         <div class="col-lg-6">
          <div class="box">
              <div class="box-header with-border">
                <h3 class="box-title">Today's  Anniversary</h3>
                <div class="box-tools pull-right">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
              </div>
              <div class="box-body table-responsive">
              <table id="package" class="table">
                <thead>
                  <tr>
                    <th>Name</th>
                    <th>MobileNo</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                    <?php $i=0; ?> 
                    @foreach($data['todayanniv'] as $key => $tanniv)
                      <tr>
                        <td>{{$tanniv->firstname}}   {{$tanniv->lastname}} </td>
                        <td>{{$tanniv->mobileno}}</td>
                        <td><a href="{{ url('memberProfile/'.$tanniv->memberid) }}"<i class="fa fa-eye"></i></td>
                      </tr>
                    @endforeach
                </tbody>
              </table>
             </div>
          </div>
         </div>
      </div>
   
      @endif
  

      @if( session('role')== 'trainer' || session('role') == 'Trainer')

 <div class="row">
      <div class="col-lg-6">
        <div class="box">
          <div class="box-header with-border">
            <h3 class="box-title">Client's Renewal</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>

                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <div class="box-body">
              <div class="table-responsive">
               <table id="clientsrenewal" class="table table-bordered table-striped">
              <thead>
                <tr>
                  
                  <th>Member Name</th>
                  <th>Package</th>
                  <th>Expire on</th>
                  <th>Days</th>
                </tr>
              </thead>
             <tbody>
             
              @if(count($packexpiretrainer)>0)

              @foreach($packexpiretrainer as $key => $packexpiretrainer1)
            
               <tr>
                  <td>{{$packexpiretrainer1->firstname}} {{$packexpiretrainer1->lastname}}</td>
                 <td>{{$packexpiretrainer1->schemename}}</td>
                 <td>{{date('d-m-Y', strtotime($packexpiretrainer1->expiredate))}}</td>
                 <td @if($packexpiretrainer1->diff == "Expired") class='red'@endif><span>{{str_replace("+", "", $packexpiretrainer1->diff)}}</span>  </td>
               </tr>
               @endforeach
               @endif
             </tbody>
            </table>
              </div>
            
           </div>
         </div>
       </div>
       <div class="col-lg-6">
        <div class="box">
          <div class="box-header with-border">
            <h3 class="box-title">Measurement Remaining</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>

                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <div class="box-body">
              <div class="table-responsive">
               <table id="measurementpending" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>Member Name</th>
                  <th>Add</th>
                </tr>
              </thead>
             <tbody>
             
              @if(count($measurements)>0)
                @foreach($measurements as $key => $measurement)
                  <tr>
                    <td>{{$measurement->firstname}} {{$measurement->lastname}}</td>
                    <td><a href="{{ url('addMeasurement/'.$measurement->memberid) }}"class="btn-xs edit"><i class="fa fa-plus"></i>  </a></td>
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
              @if(count($trainersession)>0)
              <tr>

                @foreach($trainersession as $trainersession1)
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
      @endif
       <div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                <div class="modal-dialog" role="document" style="overflow-y: scroll; max-height:80%;  margin-top: 50px; margin-bottom:50px;" >
                  <div class="modal-content" id="modalContent">
                    <div class="modal-header" id="headermodal">
                     
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body" id="modalbody">
                     
                      <form>
                        <div class="top dropdown" id="search-bar">
                       <!--    <div class="form-group open">
                          <label class="control-label">Username</label>
                          <input class="form-control dropdown-toggle"  placeholder="Enter Username" data-toggle="dropdown" aria-expanded="true" autocomplete="off" onkeyup="userload();" id="typehead" autofocus="">

                          <ul class="dropdown-menu stock-dropdown" id="useroptions" >
                          </ul>
               
                        </div> -->
                        <div id="menus"><br></div>
                      </form>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                  </div>
                </div>
              </div> 
     </div>

    </section>
  </div>


<script type="text/javascript" src="//cdn.datatables.net/plug-ins/1.10.19/sorting/date-euro.js"></script>
 <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
 <script type="text/javascript">
    function emailafterpacsdck(invoiceid,userid){
    var invoiceid=invoiceid;
    var userid=userid;

    $.ajax({
        url : "emailafterpack",
        type: "POST",
        data : {_token:"{{csrf_token()}}",invoiceid:invoiceid,userid:userid},
        success : function(data){
         if(data == true){
          alert('SMS SuccessFully Send');
         }
        },
    });
  }
    $( "#project" ).autocomplete({
      minLength: 0,
      source: function( request, response )
        {        
        var typehead=$('#project').val();
         var _token = $('input[name="_token"]').val();     
              $.ajax({
                url:"{{ url('loaduserbytype') }}",
                method:"GET",
                data:{typehead:typehead, _token:_token},
                dataType: "json",
                // a jQuery ajax POST transmits in querystring format in utf-8
                     //return data in json format
                  success: function( data )
                    {
                        response( $.map( data, function( item)
                        {
                              var userstatus='';
                              if(item.status==1){ userstatus='Active';}
                              else{ userstatus='Deactive'; }
                          // console.log(item.userid);
                              return{
                                    label: item.username,
                                    value: item.userid,
                                     desc:userstatus,
                                      icon: "jquery_32x32.png"

                                   }
                        }));
                    }
                });  
          },
      focus: function( event, ui ) {
        $( "#project" ).val( ui.item.label );
        return false;
      },
      select: function( event, ui ) {
        $( "#project" ).val( ui.item.label );
        $( "#project-id" ).val( ui.item.value );
        var userstatus='';
        if(ui.item.status==1){
          userstatus='Active';
        }else{
          userstatus='Deactive';
        }
        // $( "#project-description" ).html( userstatus );
        // $( "#project-icon" ).attr( "src", "images/" + ui.item.userid );
 
        return false;
      }
    }).autocomplete( "instance" )._renderItem = function( ul, item ) {
      return $( "<li>" )
        .append( "<div style='overflow-y:auto;'>" + item.label + "<br>" + item.desc + "</div>" )
        .appendTo( ul );
    };

 $(document).ready(function () {
   $('#project').keyup(function(e){
    if(e.keyCode == 13)
    {
       userid=$( "#project-id" ).val();
       username=$( "#project" ).val();
        opendiv(userid,username);
    }
});
});
function userload(){
  var typehead=$('#typehead').val();
  var _token = $('input[name="_token"]').val();
  if(typehead.length > 1){
         
           
   $.ajax({
      url:"{{ url('loaduserbytype') }}",
      method:"GET",
      data:{typehead:typehead, _token:_token},
      success:function(result)
      {
        var ap='';
        data=result;
        if(data){
          $('#useroptions').empty();
        
         $.each(data,function(item,i){
          ap+='<li class="li" style="border:1px solid; border-color:white; margin:5px;"><a id="'+i.userid+'" onclick="opendiv(' +i.userid+  ',\'' + i.username + '\')"><div class="item"><i class="fa fa-user margin" aria-hidden="true"></i> ' +i.username+  ' <span lass="pull-right"></span><div class="details d-inline pull-right margin ';
          if(i.status == 1) {
            ap+=' activeColor">';
          }
          else{
             ap+= 'deactiveColor">';
          }
         
          if (i.status == 1) {
            ap+=' Active';
          }
          else{
             ap+=' Deactive';
          }
          ap+='</div></div></a></li>';
         }) 
          
         $('#useroptions').append(ap);
         $('#useroptions').show();

         // $('#useroptions').FadeIn();
        
        
        }
       
      }
     });
    }
  }
  // var keycode = (window.event) ? event.keyCode : e.keyCode;
  //          if (keycode == 9)
  //          alert('tab key pressed');

function opendiv(userid,username){

  
    var _token = $('input[name="_token"]').val();
   $.ajax({
      url:"{{ url('loaduserprofile') }}",
      method:"GET",
      data:{userid:userid, _token:_token},
      success:function(result)
      {

          var userview=result;
          var userprofile='<div class="userprofile"><center><img';
          if (userview.photo != null) {
            userprofile+=' src="/images/'+userview.photo+'"';
          }else{
            userprofile+=' src="/images/default.png"';
          }
          userprofile+=' name="aboutme" id="profile" width="140" height="140" border="0" class="img-circle"><h3 class="media-heading">'+userview.firstname[0].toUpperCase()+userview.firstname.slice(1)+' '+userview.lastname[0].toUpperCase()+userview.lastname.slice(1)+'';
           if (userview.city != null) {
            userprofile+='(' +userview.city+ ')';
          }
          if (userview.professional != null) {
            userprofile+='<br>Professional:' +userview.professional;
          }  userprofile+='<br><small>'; if (userview.status == 0) {
            userprofile+='Deactive';
          }if (userview.status == 1) {
            userprofile+='Active';
          }
          if (userview.status == 2) {
            userprofile+='Freeze';
          }
        
         

          userprofile+='</small></div><div class="nav-tabs-custom"><ul class="nav nav-tabs nav-justified"><li  class="active"><a href="#day" data-toggle="tab" id="inq">Packages</a></li><li><a href="#month" data-toggle="tab" id="reg">Fetch Logs</a></li><li><a href="#year" data-toggle="tab" id="ftstep"></a></li></ul><div class="tab-content"><div class="tab-pane active" id="day">';

          userprofile+='</h3><span></span></center><ul style=" margin-left:12px;">';
          userprofile+='<table class="table"><thead><th>Package</th><th>Joindate</th><th>Expiredate</th><th>Print</th><thead><tbody>';
          if(userview.packages){
              $.each(userview.packages,function(item,i){ 
              let current_datetime = new Date(i.joindate)
              let formatted_date = current_datetime.getDate() + "-" + (current_datetime.getMonth() + 1) + "-" + current_datetime.getFullYear();
              let current = new Date(i.expiredate)
              let formatted = current.getDate() + "-" + (current.getMonth() + 1) + "-" + current.getFullYear();
              userprofile+='<tr><td>'+i.schemename+'</td><td>'+formatted_date+'</td><td>'+formatted+'</td><td><a href="transactionpaymentreceipt/'+i.memberpackagesid+'/'+userview.mobileno+'")}}"><i class="fa fa-print margin"></i></a><a id="emailafterpack"    onclick="return emailafterpacsdck('+i.memberpackagesid+','+userid+');" class="red"><i class="fa fa-envelope-o" aria-hidden="true"></i></a></td></tr>';

            });
            userprofile+='</tbody></table></ul></div>';
          }
          userprofile+='<div class="tab-pane" id="month"><table class="table">'+
                                 '<thead>'+
                                    '<tr>'+
                                      '<th>#</th>'+
                                      '<th>PunchDate</th>'+
                                      '<th >PunchTime</th>'+
                                    '</tr>'+
                                 '</thead>'+
                                 '<tbody id="fetchlogtbody">';
          if(userview.logs){
            $.each(userview.logs,function(item,i){ 
              let current_datetime = new Date(i.PunchDateTime)
              let formatted_date = current_datetime.getDate() + "-" + (current_datetime.getMonth() + 1) + "-" + current_datetime.getFullYear();
              let current = new Date(i.PunchDateTime);
              var hours = current.getHours();
              var minutes = current.getMinutes();
              var seconds = current.getSeconds();
                   
              userprofile+='<tr><td>'+userid+'</td><td>'+formatted_date+'</td><td>'+hours+':'+minutes+':'+seconds+'</td></tr>';

            });

          }
         
          userprofile+='</tbody></table></div><div class="tab-pane" id="year"></div></div>';

          $('.userprofile').empty(); 
          $('#headermodal').empty();
          $('#search-bar').empty();
          $('#search-bar').append(userprofile);
          $('#menus').empty(); 
          if(userview.status!=1){
             $('.userprofile').after('<form action="Printconsentform" class="form-inline"><a href="assignPackageOrRenewalPackage/'+userid+'"class="btn bg-orange margin"><i class="fa fa-users"></i>  Assign Package</a><a href="addMeasurement/'+userid+'"class="btn bg-orange margin disabled"><i class="fa fa-plus"></i>  Add Measurment</a><a href="assigndiettomember/'+userview.memberid+'"class="btn bg-orange margin disabled"><i class="fa fa-cutlery"></i>   Assign Diet</a><a href="assignExercise/'+userview.memberid+'"class="btn bg-orange margin disabled"><i class="fa fa-cutlery"></i>   Assign Workout</a><input type="hidden" name="firstname" value="'+userview.firstname+'" ><input type="hidden" name="lastname" value="'+userview.lastname+'" ><input type="hidden" name="memberid" value="'+userview.memberid+'" ><input type="hidden" name="phone" value="'+userview.mobileno+'" ><input type="hidden" name="email" value="'+userview.email+'" ><button type="submit" disabled class="btn bg-orange margin"><i class="fa fa-print"></i> Print consentform</button></form>');
           }else{
             $('.userprofile').after('<form action="Printconsentform" class="form-inline"><a href="assignPackageOrRenewalPackage/'+userid+'"class="btn bg-orange margin"><i class="fa fa-users"></i>  Assign Package</a><a href="addMeasurement/'+userid+'"class="btn bg-orange margin"><i class="fa fa-plus"></i>  Add Measurment</a><a href="assigndiettomember/'+userview.memberid+'"class="btn bg-orange margin"><i class="fa fa-cutlery"></i>   Assign Diet</a><a href="assignExercise/'+userview.memberid+'"class="btn bg-orange margin"><i class="fa fa-cutlery"></i>  Assign Workout</a><input type="hidden" name="firstname" value="'+userview.firstname+'" ><input type="hidden" name="lastname" value="'+userview.lastname+'" ><input type="hidden" name="memberid" value="'+userview.memberid+'" ><input type="hidden" name="phone" value="'+userview.mobileno+'" ><input type="hidden" name="email" value="'+userview.email+'" ><button type="submit" class="btn bg-orange margin"><i class="fa fa-print"></i> Print consentform</button></form>');
           }
         

          $('#headermodal').append('<h4>'+userview.firstname[0].toUpperCase()+userview.firstname.slice(1)+'  '+userview.lastname[0].toUpperCase()+userview.lastname.slice(1)+'</h4>');
      }
     });
   
    $('#useroptions').hide();
    $('#typehead').val(username);
    if(username){
      // alert(username);
       $('#checkuser').trigger('click');
    }
   };
</script>
      <script type="text/javascript">
  $(function () {
    $('#package').DataTable({
      'paging'      : false,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : true,
      'info'        : false,
      'autoWidth'   : false
    });
    $('#duepayment').DataTable({
      'paging'      : false,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : true,
      'info'        : false,
      'autoWidth'   : false
    });
    $('#collection').DataTable({
      'paging'      : false,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : true,
      'info'        : false,
      'autoWidth'   : false

    });
    $('#packageexpire').DataTable({
      'paging'      : false,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : true,
      'info'        : false,
      'autoWidth'   : false

    });
    $('#clientsrenewal').DataTable({
      'paging'      : false,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : true,
      'info'        : false,
      'autoWidth'   : false

    });
    $('#measurementpending').DataTable({
      'paging'      : false,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : true,
      'info'        : false,
      'autoWidth'   : false

    });
    $('#membersession').DataTable({
      'paging'      : false,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : true,
      'info'        : false,
      'autoWidth'   : false

    });
    
  })


</script>
@endsection
