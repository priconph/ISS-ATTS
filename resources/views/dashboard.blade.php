@if(!isset($_SESSION))
@php
    session_start();
@endphp
@endif


@php
    $layout = 'layouts.super_user_layout';
    $isLogin = false;
    if(isset($_SESSION['rapidx_user_id'])){
        $isLogin = true;
    }
    // else{
    //     echo "<script type='text/javascript'>
    //         window.location = '../RapidX/';
    //     </script>";
    // }
@endphp
@if ($isLogin)


    @extends($layout)
    @section('title', 'Main Dashboard')

    @section('content_page')

    {{-- <style>
        .bgfp{
            box-shadow: rgb(85, 91, 255) 0px 0px 0px 3px, rgb(31, 193, 27) 0px 0px 0px 6px, rgb(255, 217, 19) 0px 0px 0px 9px, rgb(255, 156, 85) 0px 0px 0px 12px, rgb(255, 85, 85) 0px 0px 0px 15px;
        }
    </style> --}}
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>ISS Asset Tag Traceability System</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">ISS ATTS</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary bgfp" style="margin-bottom: 80px; ">
                            <!-- <div class="card-header">
                                <h3 class="card-title">Main Dashboard</h3>
                            </div> -->

                            <div class="card-body">
                                <ul class="nav nav-tabs" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active tabSection bgfp" id="tabletTab" data-toggle="tab" href="#tablet" role="tab" aria-selected="true">Tablet</a>
                                    </li>
                                    {{-- <li class="nav-item">
                                        <a class="nav-link tabSection" id="cameraTab" data-toggle="tab" href="#camera" role="tab" aria-selected="false">Camera</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link tabSection" id="laptopTab" data-toggle="tab" href="#laptop" role="tab" aria-selected="false">Laptop</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link tabSection" id="mobileScannersTab" data-toggle="tab" href="#mobileScanners" role="tab" aria-selected="false">Mobile Scanners</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link tabSection" id="raspberryPiTab" data-toggle="tab" href="#raspberryPi" role="tab" aria-selected="false">Raspberry Pi</a>
                                    </li> --}}
                                </ul>

                                <div class="tab-content" id="myTabContent">
                                    <div class="tab-pane fade show active" id="tablet">
                                        {{-- @if(isset($_SESSION['rapidx_user_level_id']))
                                            @if ($_SESSION['rapidx_user_level_id'] == 1 || $_SESSION['rapidx_user_level_id'] == 2)
                                                <div class="text-right mt-4">
                                                    <button class="btn btn-primary" data-toggle="modal" data-target="#modalAddTablet" id="btnShowAddTableModal"><i class="fa fa-plus fa-md"></i> New Project</button>
                                                </div><br>
                                            @endif
                                        @else
                                            <script type="text/javascript">
                                                window.location = '../RapidX/';
                                            </script>
                                        @endif --}}
                                        {{-- <img src="{{ asset('/public/images/qwe.jpg') }}" class="position-absolute" style="width: 400px;"> --}}
                                        {{-- <img src="{{ asset('/public/images/qwe1.png') }}" class="position-absolute" style="width: 600px; margin-left: 1000px; margin-top: 10px;"> --}}



                                        <div class="text-right mt-4">
                                            <input type="hidden" name="month_today" id="monthTodayId">
                                            <input type="hidden" name="year_today" id="yearTodayId">
                                            <button class="btn btn-secondary bgfp" id="btnShowQRCheckModal" data-toggle="modal" data-target="#modalQRChecking"><i class="fas fa-qrcode"></i> QR Checking</button>

                                            <button class="btn btn-info bgfp" id="modalExportTablet" data-toggle="modal" data-target=""><i class="fas fa-file-download"></i> Export Excel</button>

                                            <button class="btn btn-info bgfp" id="modalImportTablet" data-toggle="modal" data-target="#modalImportTabletExcel"><i class="fas fa-file-upload"></i> Import Excel</button>

                                            <button class="btn btn-primary bgfp" data-toggle="modal" data-target="#modalAddTablet" id="btnShowAddTableModal"><i class="fa fa-plus fa-md"></i> Add New</button>
                                        </div><br>
                                        <table id="tableTablet" class="table table-responsive table-sm table-bordered table-hover nowrap" style="width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>Action</th>
                                                    <th>Tablet Status</th>
                                                    <th>Approval Status</th>
                                                    <th>Asset Tag</th>
                                                    <th>Serial Number</th>
                                                    <th>Brand</th>
                                                    <th>Model</th>
                                                    <th>Capacity(in GB)</th>
                                                    <th>Department</th>
                                                    <th>Section</th>
                                                    <th>Assigned to</th>
                                                    <th>Disposition</th>
                                                    <th>Date of Disposal</th>
                                                    <th>Date of Purchase</th>
                                                    <th style="min-width: 350px; width: 350px !important;">Remarks 1</th>
                                                    <th style="min-width: 350px; width: 350px !important;">Remarks 2</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                    <div class="tab-pane fade" id="camera">
                                        <table id="tableCamera" class="table table-sm table-bordered table-hover nowrap" style="width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>Action</th>
                                                    <th>Project Status</th>
                                                    <th>File</th>
                                                    <th>Control Number</th>
                                                    <th>Project Name</th>
                                                    <th>Timeline Start Date</th>
                                                    <th>Timeline Due date</th>
                                                    <th>Testing Start Date</th>
                                                    <th>Testing End Date</th>
                                                    <th>Requestor</th>
                                                    <th>Sect/Dept.</th>
                                                    <th>Programmer</th>
                                                    <th>Remarks</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                    <div class="tab-pane fade" id="laptop">
                                        <table id="tableLaptop" class="table table-sm table-bordered table-hover nowrap" style="width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>Action</th>
                                                    <th>Project Status</th>
                                                    <th>File</th>
                                                    <th>Control Number</th>
                                                    <th>Project Name</th>
                                                    <th>Timeline Start Date</th>
                                                    <th>Timeline Due date</th>
                                                    <th>Testing Start Date</th>
                                                    <th>Testing End Date</th>
                                                    <th>Requestor</th>
                                                    <th>Sect/Dept.</th>
                                                    <th>Programmer</th>
                                                    <th>Remarks</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                    <div class="tab-pane fade" id="mobileScanners">
                                        <table id="tableMobileScanners" class="table table-sm table-bordered table-hover nowrap" style="width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>Action</th>
                                                    <th>Project Status</th>
                                                    <th>File</th>
                                                    <th>Control Number</th>
                                                    <th>Project Name</th>
                                                    <th>Timeline Start Date</th>
                                                    <th>Timeline Due date</th>
                                                    <th>Testing Start Date</th>
                                                    <th>Testing End Date</th>
                                                    <th>Requestor</th>
                                                    <th>Sect/Dept.</th>
                                                    <th>Programmer</th>
                                                    <th>Remarks</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                    <div class="tab-pane fade" id="raspberryPi">
                                        <table id="tableRaspberryPi" class="table table-sm table-bordered table-hover nowrap" style="width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>Action</th>
                                                    <th>Project Status</th>
                                                    <th>File</th>
                                                    <th>Control Number</th>
                                                    <th>Project Name</th>
                                                    <th>Timeline Start Date</th>
                                                    <th>Timeline Due date</th>
                                                    <th>Testing Start Date</th>
                                                    <th>Testing End Date</th>
                                                    <th>Requestor</th>
                                                    <th>Sect/Dept.</th>
                                                    <th>Programmer</th>
                                                    <th>Remarks</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <div class="modal fade" id="modalAddTablet" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><i class="fas fa-info-circle"></i>&nbsp;Details</h4>
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" id="formAddTablet" autocomplete="off" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card-body">
                                    <!-- For Edit -->
                                    <input type="text" class="form-control" style="display: none" name="id_for_edit" id="idForEdit" aria-label="Default" aria-describedby="inputGroup-sizing-default">
                                    <div class="form-group">
                                        <label class="col-form-label">Asset Tag</label>
                                        <input type="text" class="form-control" name="asset_tag" id="textAddAssetTag" placeholder="Asset Tag">
                                    </div>
                                    <div class="form-group">
                                        <label class="col-form-label">Serial Number</label>
                                        <input type="text" class="form-control" name="serial_number" id="textAddSerialNumber" placeholder="Serial Number">
                                    </div>
                                    <div class="form-group">
                                        <label class="col-form-label">Brand</label>
                                        <input type="text" class="form-control" name="brand" id="textAddBrand" placeholder="Brand">
                                    </div>
                                    <div class="form-group">
                                        <label class="col-form-label">Model</label>
                                        <input type="text" class="form-control" name="model" id="textAddModel" placeholder="Model">
                                    </div>
                                    <div class="form-group">
                                        <label class="col-form-label">Capacity(in GB)</label>
                                        <input type="text" class="form-control" name="capacity" id="textAddCapacity" placeholder="Capacity">
                                    </div>

                                    <div class="form-group">
                                        <label class="col-form-label">Department</label>
                                        <select class="form-control select2bs4 selectDepartment" name="department" id="selectDepartment" aria-label="Default" aria-describedby="inputGroup-sizing-default">
                                            <option value="0" disabled selected>Select One</option>
                                            <option value="Administration">Administration</option>
                                            <option value="Production">Production</option>
                                            <option value="QAD">QAD</option>
                                            <option value="CN">CN</option>
                                            <option value="TS">TS</option>
                                            <option value="PPS">PPS</option>
                                            <option value="YF">YF</option>
                                            <option value="PPC">PPC</option>
                                            <option value="Logistics">Logistics</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-form-label">Section</label>
                                        <select class="form-control select2bs4 selectSection" name="section" id="selectSection" aria-label="Default" aria-describedby="inputGroup-sizing-default">
                                            <!-- Auto Generated -->
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-form-label">Assigned User</label>
                                        <select class="form-control select2bs4 selectAddAssignedUser" name="assigned_user" id="selectAddAssignedUser">
                                            <!-- Auto Generated -->
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-form-label">Disposition</label>
                                        <select class="form-control select2bs4 selectAddDisposition" name="disposition" id="selectAddDisposition">
                                            <option value="0" disabled selected>Select One</option>
                                            <option value="1">Deployed</option>
                                            <option value="2">Disposed</option>
                                            <option value="3">For Disposal</option>
                                            <option value="4">Decomissioned</option>
                                            <option value="5">Missing</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-form-label">Date of Disposal</label>
                                        <input type="date" class="form-control" id="dateDateOfDisposal" name="date_of_disposal" placeholder="Date of Disposal">
                                    </div>
                                    <div class="form-group">
                                        <label class="col-form-label">Date of Purchase</label>
                                        <input type="date" class="form-control" id="dateDateOfPurchase" name="date_of_purchase" placeholder="Date of Purchase">
                                    </div>
                                    <div class="form-group">
                                        <label class="col-form-label">Remarks 1</label>
                                        <textarea type="date" class="form-control" id="textRemarks1" name="remarks_1" placeholder="Remarks 1"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-form-label">Remarks 2</label>
                                        <textarea type="date" class="form-control" id="textRemarks2" name="remarks_2" placeholder="Remarks 2"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" id="btnAddTablet" class="btn btn-primary"><i id="iBtnAddTabletIcon" class="fa fa-check"></i> Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- MODAL IMPORT --}}
    <div class="modal fade" id="modalImportTabletExcel">
        <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-dark">
            <h4 class="modal-title"><i class="fas fa-file-import"></i> Import Tablet Assets</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true" style="color: white">&times;</span>
            </button>
            </div>
            <form method="post" id="formImportTablet" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
                <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                    <label>File</label>
                        <input type="file" class="form-control" name="import_tablet_file" id="fileImportTablet" required>
                        {{-- <a href="download_file">Download Sample</a> --}}
                    </div>
                </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" id="btnImportTablet" class="btn btn-success"><i id="iconImportTablet" class="fa fa-check"></i> Import</button>
            </div>
            </form>
        </div>
        <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

     {{-- MODAL QR SCANNING --}}
     <div class="modal fade" id="modalQRChecking">+
        <div class="modal-dialog modal-sm">
        <div class="modal-content">
            {{-- <div class="modal-header">
            <h4 class="modal-title"><i class="fas fa-file-import"></i> Import Tablet Assets</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true" style="color: white">&times;</span>
            </button>
            </div> --}}
            {{-- <img src="{{ asset('/public/images/asd.png') }}" class="position-absolute" style="height:184px;"> --}}
            <div class="modal-body">
                <div class="text-center">
                    <input type="text" id="txtQRScanning">
                    <h1>
                        <i class="fa fa-qrcode fa-2x"></i>
                    </h1>
                    <h4>Please Scan QR Code</h4>
                </div>
            </div>
            {{-- <form method="post" id="formImportTablet" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
                <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                    <label>File</label>
                        <input type="file" class="form-control" name="import_tablet_file" id="fileImportTablet" required>

                    </div>
                </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" id="btnImportTablet" class="btn btn-success"><i id="iconImportTablet" class="fa fa-check"></i> Import</button>
            </div>
            </form> --}}
        </div>
        <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

    <!-- START APPROVER MODAL -->
    <div class="modal fade" id="modalTabletSelectApprover">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-dark">
                    <h4 class="modal-title"><i class="fas fa-thumbs-up"></i> SELECT APPROVER</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" style="color: white">&times;</span>
                    </button>
                </div>
                <form method="post" id="formTabletSelectApprover" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <input type="hidden" class="form-control" name="id_for_edit" id="idForEdit" aria-label="Default" aria-describedby="inputGroup-sizing-default">
                            <div class="form-group col-sm-12 flex-column d-flex">
                                <div class="form-group">
                                    <label class="col-form-label">Approver</label>
                                    <select class="form-control select2bs4 selectAddAssignedUser" name="tablet_select_approver" id="selTabletSelectApprover">
                                        <!-- Auto Generated -->
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">Supervisor</label>
                                    <select class="form-control select2bs4 selectAddAssignedUser" name="tablet_select_supervisor" id="selTabletSelectSupervisor">
                                        <!-- Auto Generated -->
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
                        <button type="submit" id="btnTabletSelectApprover" class="btn btn-dark"><i id="iconTabletSelectApprover" class="fa fa-check"></i> Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- END APPROVER MODAL -->

    <!-- APPROVED DISAPPROVED START -->
    <div class="modal fade" id="modalTabletApprovedDisapproved">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-dark">
                    <h4 class="modal-title" id="h4ChangeApprovalStat"><i class=""></i> System Confirmation </h4>
                    <button type="button" style="color: #fff" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" id="formApprovedDisapproved">
                    @csrf
                    <div class="modal-body">
                        <label class="col-form-label">Remark:</label>
                        <textarea type="text" class="form-control" id="txtApprovedDisapprovedRemarks" name="approved_remarks" placeholder="Remark"></textarea>
                        <label id="lblChangeApprovalStatLabel"></label>
                        <input type="hidden" name="id_for_edit" id="txtApprovalId">
                        <input type="hidden" name="status" id="txtApprovalStat">
                        <br>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-dark" data-dismiss="modal">No</button>
                        <button type="submit" id="btnChangePmiItClcAssessmentStat" class="btn btn-dark"><i id="iBtnApprovedDisapprovedIcon" class="fa fa-check"></i> Yes</button>
                    </div>
                </form>
            </div>
        </div>
    </div> <!-- APPROVED DISAPPROVED END -->
@endsection

    @section('js_content')
        <script type="text/javascript">
            $(document).ready(function () {
                bsCustomFileInput.init();

                // Initialize Select2 Elements
                $('.select2').select2();

                // Initialize Select2 Elements
                $('.select2bs4').select2({
                    theme: 'bootstrap4'
                });

                // Initialize Select2 Elements
                $('#select2bs4').select2({
                    theme: 'bootstrap4'
                });

                // Onclick <tr> to add active class ver 14.14 Distrib 5.7.37
                    $(document).on('click','#tblEmailRecipient tbody tr',function(e){
                    $(this).closest('tbody').find('tr').removeClass('table-active');
                    $(this).closest('tr').addClass('table-active');
                });

                GetSection('#selectSection');
                GetRapidXUser('#selectAddAssignedUser');
                GetRapidXUser('#selTabletSelectApprover');
                GetRapidXUser('#selTabletSelectSupervisor');

                dataTablesTablet = $("#tableTablet").DataTable({
                    "processing" : false,
                    "serverSide" : true,
                    "responsive": true,
                    // "order": [[ 0, "desc" ],[ 4, "desc" ]],
                    "language": {
                        "info": "Showing _START_ to _END_ of _TOTAL_ system records",
                        "lengthMenu": "Show _MENU_ system records",
                    },
                    "ajax" : {
                        url: "view_tablet",
                    },
                    "columns":[
                        { "data" : "action", orderable:false, searchable:false},
                        { "data" : "tablet_status"},
                        { "data" : "approval_status"},
                        { "data" : "asset_tag"},
                        { "data" : "serial_number"},
                        { "data" : "brand"},
                        { "data" : "model"},
                        { "data" : "capacity"},
                        { "data" : "department"},
                        { "data" : "section"},
                        { "data" : "assigned_user"},
                        { "data" : "disposition"},
                        { "data" : "date_of_disposal"},
                        { "data" : "date_of_purchase"},
                        { "data" : "remarks_1"},
                        { "data" : "remarks_2"},
                    ],
                    "createdRow": function(row, data, index) {
                        $('td', row).eq(14).css('white-space', 'normal')
                        $('td', row).eq(15).css('white-space', 'normal')
                    },
                    "rowCallback": function(row,data,index ){
                        if(data['is_checked'] == 1){
                            $(row).addClass('table-success');
                        }
		            },
                });

                const resetFormValues = () => {
                    // Reset values
                    $("#formAddTablet")[0].reset();
                    $("#formTabletSelectApprover")[0].reset();

                    // Remove invalid & title validation
                    $('div').find('input').removeClass('is-invalid');
                    $("div").find('input').attr('title', '');
                    $('div').find('select').removeClass('is-invalid');
                    $("div").find('select').attr('title', '');
                    $('div').find('textarea').removeClass('is-invalid');
                    $("div").find('textarea').attr('title', '');
                    console.log("resetFormValues() called");
                }

                const AddTablet = () => {
                    toastr.options = {
                        "closeButton": false,
                        "debug": false,
                        "newestOnTop": true,
                        "progressBar": true,
                        "positionClass": "toast-top-right",
                        "preventDuplicates": false,
                        "onclick": null,
                        "showDuration": "300",
                        "hideDuration": "3000",
                        "timeOut": "3000",
                        "extendedTimeOut": "3000",
                        "showEasing": "swing",
                        "hideEasing": "linear",
                        "showMethod": "fadeIn",
                        "hideMethod": "fadeOut",
                    };

                    let formData = new FormData($('#formAddTablet')[0]);
                    $.ajax({
                        url: "add_tablet",
                        method: "post",
                        processData: false,
                        contentType: false,
                        data: formData,
                        dataType: "json",
                        beforeSend: function(){
                        },
                        success: function(response){
                            if(response['validationHasError'] == '1'){
                                toastr.error('Saving Failed!');
                                if(response['error']['asset_tag'] === undefined){
                                    $("#textAddAssetTag").removeClass('is-invalid');
                                    $("#textAddAssetTag").attr('title', '');
                                }
                                else{
                                    $("#textAddAssetTag").addClass('is-invalid');
                                    $("#textAddAssetTag").attr('title', response['error']['asset_tag']);
                                }

                                if(response['error']['serial_number'] === undefined){
                                    $("#textAddSerialNumber").removeClass('is-invalid');
                                    $("#textAddSerialNumber").attr('title', '');
                                }
                                else{
                                    $("#textAddSerialNumber").addClass('is-invalid');
                                    $("#textAddSerialNumber").attr('title', response['error']['serial_number']);
                                }

                                if(response['error']['brand'] === undefined){
                                    $("#textAddBrand").removeClass('is-invalid');
                                    $("#textAddBrand").attr('title', '');
                                }
                                else{
                                    $("#textAddBrand").addClass('is-invalid');
                                    $("#textAddBrand").attr('title', response['error']['brand']);
                                }

                                if(response['error']['model'] === undefined){
                                    $("#textAddModel").removeClass('is-invalid');
                                    $("#textAddModel").attr('title', '');
                                }
                                else{
                                    $("#textAddModel").addClass('is-invalid');
                                    $("#textAddModel").attr('title', response['error']['model']);
                                }

                                if(response['error']['capacity'] === undefined){
                                    $("#textAddCapacity").removeClass('is-invalid');
                                    $("#textAddCapacity").attr('title', '');
                                }
                                else{
                                    $("#textAddCapacity").addClass('is-invalid');
                                    $("#textAddCapacity").attr('title', response['error']['capacity']);
                                }

                                if(response['error']['department'] === undefined){
                                    $("#selectDepartment").removeClass('is-invalid');
                                    $("#selectDepartment").attr('title', '');
                                }
                                else{
                                    $("#selectDepartment").addClass('is-invalid');
                                    $("#selectDepartment").attr('title', response['error']['department']);
                                }

                                if(response['error']['section'] === undefined){
                                    $("#selectSection").removeClass('is-invalid');
                                    $("#selectSection").attr('title', '');
                                }
                                else{
                                    $("#selectSection").addClass('is-invalid');
                                    $("#selectSection").attr('title', response['error']['section']);
                                }

                                if(response['error']['assigned_user'] === undefined){
                                    $("#selectAddAssignedUser").removeClass('is-invalid');
                                    $("#selectAddAssignedUser").attr('title', '');
                                }
                                else{
                                    $("#selectAddAssignedUser").addClass('is-invalid');
                                    $("#selectAddAssignedUser").attr('title', response['error']['assigned_user']);
                                }

                                if(response['error']['disposition'] === undefined){
                                    $("#selectAddDisposition").removeClass('is-invalid');
                                    $("#selectAddDisposition").attr('title', '');
                                }
                                else{
                                    $("#selectAddDisposition").addClass('is-invalid');
                                    $("#selectAddDisposition").attr('title', response['error']['disposition']);
                                }

                                if(response['error']['date_of_disposal'] === undefined){
                                    $("#dateDateOfDisposal").removeClass('is-invalid');
                                    $("#dateDateOfDisposal").attr('title', '');
                                }
                                else{
                                    $("#dateDateOfDisposal").addClass('is-invalid');
                                    $("#dateDateOfDisposal").attr('title', response['error']['date_of_disposal']);
                                }

                                if(response['error']['date_of_purchase'] === undefined){
                                    $("#dateDateOfPurchase").removeClass('is-invalid');
                                    $("#dateDateOfPurchase").attr('title', '');
                                }
                                else{
                                    $("#dateDateOfPurchase").addClass('is-invalid');
                                    $("#dateDateOfPurchase").attr('title', response['error']['date_of_purchase']);
                                }

                            }else{
                                toastr.success('Success!');
                                $('#modalAddTablet').modal('hide');
                                resetFormValues();
                            }
                            dataTablesTablet.draw();
                        },
                        error: function(data, xhr, status){
                            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
                        }
                    });
                }

                $("#formAddTablet").submit(function(event){
                    event.preventDefault(); // to stop the form submission
                    AddTablet();
                });

                $("#tableTablet").on('click', '.actionEditTablet', function(){
                    let id = $(this).attr('id');
                    console.log('id', id);
                    $("#idForEdit", $("#formAddTablet")).val(id);
                    GetTabletById(id);
                });

                function GetTabletById(id){
                    toastr.options = {
                        "closeButton": false,
                        "debug": false,
                        "newestOnTop": true,
                        "progressBar": true,
                        "positionClass": "toast-top-right",
                        "preventDuplicates": false,
                        "onclick": null,
                        "showDuration": "300",
                        "hideDuration": "3000",
                        "timeOut": "3000",
                        "extendedTimeOut": "3000",
                        "showEasing": "swing",
                        "hideEasing": "linear",
                        "showMethod": "fadeIn",
                        "hideMethod": "fadeOut",
                    };

                    $.ajax({
                        url: "get_tablet_by_id",
                        method: "get",
                        data: {
                            id: id
                        },
                        dataType: "json",
                        beforeSend: function(){

                        },
                        success: function(response){
                            let formAddTablet = $('#formAddTablet');
                            let tabletDetails = response['tabletDetails'];
                            if(tabletDetails.length > 0){
                                // console.table(tabletDetails);
                                $("#idForEdit", formAddTablet).val(tabletDetails[0].id);
                                $("#textAddAssetTag", formAddTablet).val(tabletDetails[0].asset_tag);
                                $("#textAddSerialNumber", formAddTablet).val(tabletDetails[0].serial_number);
                                $("#textAddBrand", formAddTablet).val(tabletDetails[0].brand);
                                $("#textAddModel", formAddTablet).val(tabletDetails[0].model);
                                $("#textAddCapacity", formAddTablet).val(tabletDetails[0].capacity);
                                $("#selectDepartment", formAddTablet).val(tabletDetails[0].department).trigger('change');
                                $("#selectSection", formAddTablet).val(tabletDetails[0].section).trigger('change');
                                $("#selectAddAssignedUser", formAddTablet).val(tabletDetails[0].assigned_user).trigger('change');
                                $("#selectAddDisposition", formAddTablet).val(tabletDetails[0].disposition).trigger('change');
                                $("#dateDateOfPurchase", formAddTablet).val(tabletDetails[0].date_of_purchase);
                                $("#dateDateOfDisposal", formAddTablet).val(tabletDetails[0].date_of_disposal);
                                $("#textRemarks1", formAddTablet).val(tabletDetails[0].remarks_1);
                                $("#textRemarks2", formAddTablet).val(tabletDetails[0].remarks_2);
                            }
                            else{
                                toastr.warning('No Claim records found!');
                            }
                        },
                        error: function(data, xhr, status){
                            toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
                        },
                    });
                }

                // Reset values when Modal is closed
                $("#modalAddTablet").on('hidden.bs.modal', function(){
                    resetFormValues();
                });

                // SCRIPT FOR IMPORTING
                $('#formImportTablet').submit(function(e){
                    e.preventDefault();

                    $.ajax({
                        url: 'import_tablet',
                        method: 'post',
                        data: new FormData(this),
                        dataType: 'json',
                        cache: false,
                        contentType: false,
                        processData: false,
                        success: function (response) {
                            if(response['result'] == 1){
                                $('#modalImportTabletExcel').modal('hide');
                                $('#formImportTablet')[0].reset();
                                toastr.success('Import Data Successful!');
                                dataTablesTablet.draw();
                            }
                            else{
                                toastr.error('Import Failed! Please Check File');
                                $('#modalImportTabletExcel').modal('hide');
                                $('#formImportTablet')[0].reset();
                            }
                        }
                    });
                })
            });


            $('#modalExportTablet').on('click', function(){
                var date = new Date();
                var month = date.getMonth() + 1;
                var year = date.getFullYear();
                $('#monthTodayId').val(month);
                $('#yearTodayId').val(year);
                // console.log(today_month);
                window.location.href = `export_tablet_data/${month}/${year}`;
            // $('#modalExportTabletExcel').modal('hide');
            });

            //================================== ADD APPROVER ==================================
            $("#formTabletSelectApprover").submit(function(event){
                event.preventDefault(); // to stop the form submission
                TabletSelectApprover();
                dataTablesTablet.draw();
            });

            $(document).on('click', '.actionTabletSelectApprover', function(){
                let get_id = $(this).attr('id');
                console.log('ID:', get_id);
                $("input[name='id_for_edit'", $("#formTabletSelectApprover")).val(get_id);
            });

            const TabletSelectApprover = () => {
                toastr.options = {
                    "closeButton": false,
                    "debug": false,
                    "newestOnTop": true,
                    "progressBar": true,
                    "positionClass": "toast-top-right",
                    "preventDuplicates": false,
                    "onclick": null,
                    "showDuration": "300",
                    "hideDuration": "3000",
                    "timeOut": "3000",
                    "extendedTimeOut": "3000",
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut",
                };

                let formData = new FormData($('#formTabletSelectApprover')[0]);
                $.ajax({
                    url: "tablet_select_approver",
                    method: "post",
                    processData: false,
                    contentType: false,
                    data: formData,
                    dataType: "json",
                    beforeSend: function(){
                        $("#iconTabletSelectApprover").addClass('fa fa-spinner fa-pulse');
                        $("#btnTabletSelectApprover").prop('disabled', 'disabled');
                    },
                    success: function(response){
                        if(response['validation'] == 'hasError'){
                            toastr.error('Saving Failed!');
                            if(response['error']['tablet_select_approver'] === undefined){
                                $("#selTabletSelectApprover").removeClass('is-invalid');
                                $("#selTabletSelectApprover").attr('title', '');
                            }
                            else{
                                $("#selTabletSelectApprover").addClass('is-invalid');
                                $("#selTabletSelectApprover").attr('title', response['error']['tablet_select_approver']);
                            }

                            if(response['error']['tablet_select_supervisor'] === undefined){
                                $("#selTabletSelectSupervisor").removeClass('is-invalid');
                                $("#selTabletSelectSupervisor").attr('title', '');
                            }
                            else{
                                $("#selTabletSelectSupervisor").addClass('is-invalid');
                                $("#selTabletSelectSupervisor").attr('title', response['error']['tablet_select_supervisor']);
                            }
                        }else{
                            if(response['result'] == 1){
                                toastr.success('Success!');
                            }
                            $('#modalTabletSelectApprover').modal('hide');
                            $("#formTabletSelectApprover")[0].reset();
                            resetFormValues();
                            dataTablesTablet.draw();
                        }
                        $("#iconTabletSelectApprover").removeClass('fa fa-spinner fa-pulse');
                        $("#btnTabletSelectApprover").removeAttr('disabled');
                        $("#iconTabletSelectApprover").addClass('fa fa-check');
                    },
                    error: function(data, xhr, status){
                        toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
                        $("#iconTabletSelectApprover").removeClass('fa fa-spinner fa-pulse');
                        $("#btnTabletSelectApprover").removeAttr('disabled');
                        $("#iconTabletSelectApprover").addClass('fa fa-check');
                    }
                });
            }

            //============================== APPROVED DISAPPROVED ==============================
            $(document).on('click', '.actionTabletApprovedDisapproved', function(){
                let approvalStatus = $(this).attr('status');
                let approvalcId = $(this).attr('id');
                console.log(approvalStatus);
                $("#txtApprovalStat").val(approvalStatus);
                $("#txtApprovalId").val(approvalcId);

                if(approvalStatus == 2){
                    // $("#lblChangeApprovalStatLabel").text('Are you sure to approve?');
                    $("#h4ChangeApprovalStat").html('<i class="fa fa-thumbs-up"></i> Are you sure to approve?');
                }
                else{
                    // $("#lblChangeApprovalStatLabel").text('Are you sure to disapprove?');
                    $("#h4ChangeApprovalStat").html('<i class="fa fa-thumbs-down"></i> Are you sure to disapprove?');
                }
            });
            $("#formApprovedDisapproved").submit(function(event){
                event.preventDefault();
                ApprovedDisapproved();
            });

            function ApprovedDisapproved(){
            toastr.options = {
                "closeButton": false,
                "debug": false,
                "newestOnTop": true,
                "progressBar": true,
                "positionClass": "toast-top-right",
                "preventDuplicates": false,
                "onclick": null,
                "showDuration": "300",
                "hideDuration": "3000",
                "timeOut": "3000",
                "extendedTimeOut": "3000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut",
            };

            $.ajax({
                url: "tablet_approved_disapproved",
                method: "post",
                data: $('#formApprovedDisapproved').serialize(),
                dataType: "json",
                beforeSend: function(){
                    $("#iBtnApprovedDisapprovedIcon").addClass('fa fa-spinner fa-pulse');
                    $("#txtApprovalStat").prop('disabled', 'disabled');
                },
                success: function(response){

                    if(response['validation'] == 'hasError'){
                        toastr.error('Failed!');
                    }else{
                        if(response['result'] == 1){
                            console.log('response', response);
                            if($("#txtApprovalStat").val() == 3){
                                toastr.error('Disapproved!');
                                $("#txtApprovalStat").val() == 3;
                            }
                            else{
                                toastr.success('Approved!');
                                $("#txtApprovalStat").val() == 1;
                            }
                        }
                        $("#modalTabletApprovedDisapproved").modal('hide');
                        $("#formApprovedDisapproved")[0].reset();
                        dataTablesTablet.draw();
                    }

                    $("#iBtnApprovedDisapprovedIcon").removeClass('fa fa-spinner fa-pulse');
                    $("#txtApprovalStat").removeAttr('disabled');
                    $("#iBtnApprovedDisapprovedIcon").addClass('fa fa-check');
                },
                error: function(data, xhr, status){
                    toastr.error('An error occured!\n' + 'Data: ' + data + "\n" + "XHR: " + xhr + "\n" + "Status: " + status);
                    $("#iBtnApprovedDisapprovedIcon").removeClass('fa fa-spinner fa-pulse');
                    $("#txtApprovalStat").removeAttr('disabled');
                    $("#iBtnApprovedDisapprovedIcon").addClass('fa fa-check');
                }
            });
        }

        // SCRIPT FOR SCANNING
        $('#modalQRChecking').on('shown.bs.modal', function () {
            $('#txtQRScanning').focus();
        });

        $('#txtQRScanning').on('keyup', function(e){
            if( e.keyCode == 13 ){
                setTimeout(() => {
                    let scannedData = $('#txtQRScanning').val();
                    verifyData(scannedData);
                    $('#txtQRScanning').val("");
                }, 400);
            }
        });

        </script>
    @endsection
@else
    <script type="text/javascript">
        window.location = '../RapidX/';
    </script>
@endif
