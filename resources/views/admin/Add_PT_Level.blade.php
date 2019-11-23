@extends('layouts.adminLayout.admin_design')
@section('content')
<link rel="stylesheet" href="{{ asset('bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('bower_components/font-awesome/css/font-awesome.min.css') }}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="{{ asset('bower_components/Ionicons/css/ionicons.min.css') }}">
  <!-- DataTables -->
  <link rel="stylesheet" href="{{ asset('bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('dist/css/AdminLTE.min.css') }}">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="{{ asset('dist/css/skins/_all-skins.min.css') }}">


  <div class="content-wrapper">
   
     
         <section class="content-header"><h2>Add PT Level</h2></section>
          <!-- general form elements -->
           <section class="content">
          
            @if ($errors->any())
            <div class="alert alert-danger">
            <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
            </ul>
            </div>
            @endif

             @if ($message = Session::get('message'))
              <div class="alert alert-success alert-block">
                <button type="button" class="close" data-dismiss="alert">×</button> 
                      <strong>{{ $message }}</strong>
              </div>
              @endif 

               @if (Session::get('add_pt-level'))
              <div class="alert alert-success alert-block">
                <button type="button" class="close" data-dismiss="alert">×</button> 
                      <strong>{{ Session::get('add_pt-level') }}</strong>
                      <?php Session::forget('add_pt-level') ?>
              </div>
              @endif 

         <div class="row">
        <div class="col-xs-12 ">
          <div>           
            <div class="box-body">
            <?php $permission = unserialize(session()->get('permission')); ?>
            @if(isset($permission["'add_pt_level'"]))
              <button type="button" class="btn add-new bg-orange" data-toggle="modal" data-target="#modal-default" style="width: 150px;padding: 10px;">
                Add PT Level
              </button>
            @endif
            </div>
          </div>
        </div>
      </div>

        <div class="modal fade" id="modal-default">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"> Add PT Level</h4>
              </div>

              <div class="modal-body">
    
                <div class="box-body"> <div class="col-lg-3"></div><div class="col-lg-6">
                 <form method="POST" role="form" action="{{route('addptleveldatacreate')}}"  id="pt_form">
                   {{ csrf_field() }}
               
                    <div class="form-group">
                   <label> Level</label>
                   <input type="number" id="level" max="1000" class="form-control" name="level" required placeholder="Enter Level">
                    </div>

                    <div class="form-group">
                    <label>percentage</label>
                     <input type="number" id="percentage" max="100" class="form-control" name="percentage" required placeholder="Enter percentage">
                    </div>

                      <div class="form-group col-lg-6">
                        <button type="submit" class="btn bg-green btn-block">Save</button> 
                         </div>

                      <div class="form-group col-lg-6">
                           <a href="" class="btn btn-danger btn-block" data-dismiss="modal">Cancel</a>
                         </div>

                   </form>
            </div>
                  <div class="col-lg-3"></div>
                  </div>
              </div>

            </div>
      
          </div>
  
        </div>

        <div class="">

  <!-- Content Wrapper. Contains page content -->

    <!-- Content Header (Page header) -->

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          

          <div class="box">
            <div class="box-header">
              <h3 class="box-title"></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>ID</th>
                  <th>PT LEVEL</th>
                  <th>PERCENTAGE</th>
                  <th>Edit</th>
                  <!-- <th>Delete</th> -->
                </tr>
                </thead>
                <tbody>
                  @foreach($addptlevel as $ptlevel)     
                <tr>
                  <td>{{$ptlevel->id}}</td>
                  <td>{{$ptlevel->level}}</td>
                  <td>{{$ptlevel->percentage}}</td>
                  <!-- <td><a href="{{url('editptlevel/'.$ptlevel->id)}}" class="btn add-new"  data-toggle="modal" data-target="#modal-default1"><i class="fa fa-edit"></i></a></td> -->
                  <td>
                    @if(isset($permission["'edit_pt_level'"]))
                    <a href="{{url('editptlevel/'.$ptlevel->id)}}" class="btn add-new edit"  data-toggle="modal" data-target="#modal-edit" id="edit_pt_level_values" onclick="edit_pt_level_values('<?php echo $ptlevel->id; ?>','<?php echo $ptlevel->level; ?>','<?php echo $ptlevel->percentage; ?>')" ><i class="fa fa-edit"></i></a></td>
                    @endif
                 <!--  <td><a href="#"><i class="fa fa-trash"></i></a></td> -->
                </tr>
                 <div class="modal fade" id="modal-edit">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"> Edit PT Level</h4>
              </div>

              <div class="modal-body">
    
                <div class="box-body"> <div class="col-lg-3"></div><div class="col-lg-6">

                 <form method="POST" role="form" action="{{url('personaltrainer/editptlevel/'.$ptlevel->id)}}" id="pt_form" >
                   {{ csrf_field() }}
             
                    <div class="form-group">
                   <label> Level</label>

                   <input type="hidden" name="id" id="id">
                  
                   <input type="number" class="form-control" id="level"   name="level" required placeholder="Enter Level">

                               
                    </div>

                    <div class="form-group">
                    <label>Percentage</label>
                     <input type="number" class="form-control" id="percentage" name="percentage" required placeholder="Enter percentage">
                    </div>

                      <div class="form-group col-lg-6">
                        <button type="submit" class="btn btn-success btn-block">Save</button> 
                         </div>

                      <div class="form-group col-lg-6">
                           <a href="" class="btn btn-danger btn-block" data-dismiss="modal">Cancel</a>
                         </div>

                   </form>
        
                   
            </div>
                  <div class="col-lg-3"></div>
                  </div>
              </div>

            </div>
      
          </div>
    </div>

                  <script type="text/javascript">
                   function edit_pt_level_values(x,y,z){

                   $('#modal-edit #id').val(x); 
                   $('#modal-edit #level').val(y);
                   $('#modal-edit #percentage').val(z);
                  
                    
                   }
  
             </script>
                @endforeach
              


                </tbody>
                <tfoot>
                <tr>
                  <th>ID</th>
                  <th>PT LEVEL</th>
                  <th>PERCENTAGE</th>
                  <th>Edit</th>
                  <!-- <th>CSS grade</th> -->
                </tr>
                </tfoot>
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
    <!-- /.content -->
                
 
   <!-- <div class="modal fade" id="modal-edit">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"> Edit PT Level</h4>
              </div>

              <div class="modal-body">
    
                <div class="box-body"> <div class="col-lg-3"></div><div class="col-lg-6">

                 <form method="POST" role="form" action="{{url('personaltrainer/editptlevel/')}}"  >
                   {{ csrf_field() }}
             
                    <div class="form-group">
                   <label> Level</label>

                   <input type="hidden" name="id" id="id">
                  
                   <input type="number" class="form-control" id="level"   name="level" required placeholder="Enter Level">

                               
                    </div>

                    <div class="form-group">
                    <label>percentage</label>
                     <input type="number" class="form-control" id="percentage" name="percentage" required placeholder="Enter percentage">
                    </div>

                      <div class="form-group col-lg-6">
                        <button type="submit" class="btn btn-info btn-block">Save</button> 
                         </div>

                      <div class="form-group col-lg-6">
                           <a href="" class="btn btn-danger btn-block" data-dismiss="modal">Cancel</a>
                         </div>

                   </form>
        
                   
            </div>
                  <div class="col-lg-3"></div>
                  </div>
              </div>

            </div>
      
          </div>
    </div> -->

 
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- jQuery 3 -->
<script src="{{ asset('bower_components/jquery/dist/jquery.min.js') }}"></script>
<!-- Bootstrap 3.3.7 -->
<!-- <script src="../../bower_components/bootstrap/dist/js/bootstrap.min.js"></script> -->
<!-- DataTables -->
<script src="{{ asset('bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
<!-- SlimScroll -->
<script src="{{ asset('bower_components/jquery-slimscroll/jquery.slimscroll.min.js') }}"></script>
<!-- FastClick -->
<script src="{{ asset('bower_components/fastclick/lib/fastclick.js') }}"></script>

<!-- AdminLTE for demo purposes -->
<script src="{{ asset('dist/js/demo.js') }}"></script>
<!-- page script -->
<script>
  $(function () {
    $('#example1').DataTable()
    $('#example2').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
    })
  })
</script>

<script type="text/javascript">
  $('#example1').DataTable({
       stateSave: false,
       paging:  true,
       "lengthMenu": [[5, 10, 15, -1], [5, 10, 15, "All"]]
   });
</script>

             

      
  </section>
</div>
</div>
</div>
          
@endsection
@push('script')
<script type="text/javascript">
  $(document).ready(function(){
    $('#pt_form').validate({
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


