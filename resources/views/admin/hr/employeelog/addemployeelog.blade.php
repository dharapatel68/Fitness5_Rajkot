@extends('layouts.adminLayout.admin_design') 
@section('content')

<div class="content-wrapper">
    <section class="content-header">
        <h2>Add Punch Log</h2></section>
    <div class="container-fluid">
        @if ($message = Session::get('message'))
        <div class="alert alert-success alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>{{ $message }}</strong>
        </div>
        @endif

         @if ($message = Session::get('error'))
        <div class="alert alert-danger alert-block">
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
                                    <h3 class="box-title">Add Punch Log</h3>
                                </div>

                                <!-- /.box-header -->
                                <div class="box-body">
                                        <div class="row">
                                            <div class="col-md-3"></div>
                                            <div class="col-md-6">
                                                <form action="{{ route('addpunch', $log->emplogid) }}" method="post" id="workingdays">
                                                    {{ csrf_field() }}
                                                    <div class="form-group">
                                                        <label>Employee<span style="color: red;">*</span></label>
                                                        <select  class="form-control" name="employeeid" disabled="">
                                                           @if(!empty($employee))
                                                           @foreach($employee as $emp)
                                                           <option value="{{ $emp->employeeid }}" @if($log->userid == $emp->employeeid) selected="" @endif>{{ ucfirst($emp->first_name) }} {{ ucfirst($emp->last_name) }}</option>
                                                           @endforeach
                                                           @endif
                                                        </select>
                                                        @if($errors->has('employeeid'))
                                                        <span class="help-block">
                                                          <strong>{{ $errors->first('employeeid') }}</strong>
                                                      </span>
                                                      @endif
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Mobile No<span style="color: red;">*</span></label>
                                                        <select  class="form-control" disabled="">
                                                           @if(!empty($employee))
                                                           @foreach($employee as $emp)
                                                           <option value="{{ $emp->employeeid }}" @if($log->userid == $emp->employeeid) selected="" @endif>{{ $emp->mobileno }}</option>
                                                           @endforeach
                                                           @endif
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Punch Time<span style="color: red;">*</span></label>
                                                        <input type="time" name="punchtime" class="form-control" min="{{ date('H:i', strtotime($log->checkin)) }}" max="24:00:00" />
                                                        @if($errors->has('punchtime'))
                                                        <span class="help-block">
                                                          <strong>{{ $errors->first('punchtime') }}</strong>
                                                      </span>
                                                      @endif
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <p style="color: red;">Punchin time is {{ $log->checkin }}.</p>
                                                        </div>
                                                    </div>

                                                    <button type="submit" class="btn btn-primary bg-orange">Submit</button>
                                                    <a href="{{ route('viewworkingdays') }}" class="btn btn-danger">Cancel</a>
                                                </form> 
                                            </div>
                                            <div class="col-md-3"></div>
                                        </div>                                   
                                </div>
                                <!-- /.box-body -->
                            </div>
                            <!-- /.box -->
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </section>
            </div>
        </div>

                <!-- page script -->
                <script>
                    $(function() {
                        $('#example1').DataTable()
                        $('#example2').DataTable({
                            'paging': true,
                            'lengthChange': false,
                            'searching': false,
                            'ordering': true,
                            'info': true,
                            'autoWidth': false
                        })
                    })
                </script>

            </div>
        </div>
    </div>
</div>
@endsection
@push('script')
<script type="text/javascript">
    function unfreeze(id){
        $('#unfreeze #unfreezeid').val(id);
        //$('#unfreeze #unfreezeid').text(id);
    }

    $(document).ready(function(){
        $('#unfreeze_btn').click(function(){
            $('#processing').show();
            $('#unfreeze_btn').hide();

            let freezeid = $('#unfreezeid').val();

            $.ajax({

                type: 'POST',
                url : '{{ route('unfreezemembership') }}',
                data : {freezeid:freezeid, _token:"{{csrf_token()}}" },
                success : function(data){
                    
                    if(data == 0){
                        alert("membership is unfreezed");
                        window.location.href = '';
                    }else{

                        alert('There is some problem occure in device');  
                        window.location.href = '';

                       /* $('#processing').hide();
                        $('#notset').show();*/
                    }
                }




            });
        });
    });
</script>
@endpush