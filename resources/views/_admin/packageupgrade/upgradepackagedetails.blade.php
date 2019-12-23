@extends('layouts.adminLayout.admin_design') @section('content')

<div class="content-wrapper">
    <section class="content-header">
        <h2>Upgradepackage Detail</h2></section>
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
                                    <h3 class="box-title">Upgradepackage Detail</h3>
                                </div>

                                <!-- /.box-header -->
                                <div class="box-body" style="overflow: scroll;">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Member Name</th>
                                                <th>Old Package</th>
                                                <th>Upgraded Package</th>
                                                <th>Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(!empty($upgradepackage_data))
                                            @foreach($upgradepackage_data as $upgradepackage)
                                            <tr>
                                                <td> {{ !empty($upgradepackage->member->firstname) ? ucfirst($upgradepackage->member->firstname) : '' }} {{ !empty($upgradepackage->member->lastname) ? ucfirst($upgradepackage->member->lastname) : '' }}</td>
                                                <td> {{ !empty($upgradepackage->oldscheme->schemename) ? ucfirst($upgradepackage->oldscheme->schemename) : '' }}</td>
                                                <td> {{ !empty($upgradepackage->newscheme->schemename) ? ucfirst($upgradepackage->newscheme->schemename) : '' }}</td>
                                                <td> {{ !empty($upgradepackage->upgradepackagedate) ? date('d-m-Y', strtotime($upgradepackage->upgradepackagedate)) : '' }}</td>

                                            </tr>
                                            @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="4"><center>No Package Found</center></td>
                                                </tr>
                                            @endif
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