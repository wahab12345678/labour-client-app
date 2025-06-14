@extends('admin.includes.main')
@section('header')
<meta name="csrf-token" content="{{ csrf_token() }}">


<link rel="stylesheet" type="text/css" href="../../../app-assets/vendors/css/tables/datatable/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/vendors/css/tables/datatable/responsive.bootstrap5.min.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/vendors/css/tables/datatable/buttons.bootstrap5.min.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/vendors/css/tables/datatable/rowGroup.bootstrap5.min.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/vendors/css/pickers/flatpickr/flatpickr.min.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/vendors/css/forms/select/select2.min.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/vendors/css/pickers/pickadate/pickadate.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/css/plugins/forms/pickers/form-flat-pickr.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/css/plugins/forms/pickers/form-pickadate.css">
@endsection
@section('content')
<!-- BEGIN: Content-->
<div class="app-content content ">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper container-xxl p-0">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-start mb-0">Bookings</h2>
                        {{-- <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.html">Home</a>
                                </li>
                                <li class="breadcrumb-item"><a href="#">Datatable</a>
                                </li>
                                <li class="breadcrumb-item active">Basic
                                </li>
                            </ol>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
        <div class="content-body">
            <!-- Basic table -->
            <section id="basic-datatable">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <table class="datatables-basic table">
                                <thead>
                                    <tr>
                                        <th>id</th>
                                        <th>Client Name</th>
                                        <th>Labour Name</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Status</th>
                                        <th>Price</th>
                                        <th>Created At</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- Modal to add new record -->
                <div class="modal modal-slide-in fade" id="modals-slide-in">
                    <div class="modal-dialog sidebar-sm">
                        <form id="store-booking" class="add-new-record modal-content pt-0" method="POST" action="{{ route('admin.booking.store') }}" enctype="multipart/form-data">
                            @csrf
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
                            <div class="modal-header mb-1">
                                <h5 class="modal-title" id="exampleModalLabel">New Booking</h5>
                            </div>
                            <div class="modal-body flex-grow-1">
                                <div class="me-1 mb-1">
                                    <label class="form-label" for="client_id">Clients</label>
                                    <select class="select2 form-select" id="client_id" name="client_id" required>
                                        <option value="">Select Client</option>
                                        @foreach ($clients as $client)
                                            <option value="{{$client->id}}">{{$client->name}} - {{$client->phone}}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback client_id-error"></div>
                                </div>
                               
                                <div class="me-1 mb-1">
                                    <label class="form-label" for="labour_id">Labours</label>
                                    <select class="select2 form-select" name="labour_id[]" multiple="multiple" id="default-select-multi" required>
                                    <option value="">Select Labour</option>

                                        @foreach ($labours as $labour)
                                            <option value="{{$labour->id}}">{{$labour->name}} - {{$labour->phone}}</option>
                                        @endforeach
                                    </select>
                                    
                                    <div class="invalid-feedback labour_id-error"></div>
                                </div>
                                <div class="me-1 mb-1">
                                    <label class="form-label" for="start_date">Start Date</label>
                                    <input type="text" id="start_date" name="start_date" class="form-control flatpickr-date-time" placeholder="YYYY-MM-DD HH:MM" required/>
                                    <div class="invalid-feedback start_date-error"></div>
                                </div>
                                <div class="me-1 mb-1">
                                    <label class="form-label" for="end_date">End Date</label>
                                    <input type="text" id="end_date" name="end_date" class="form-control flatpickr-date-time" placeholder="YYYY-MM-DD HH:MM" />
                                    <div class="invalid-feedback end_date-error"></div>
                                </div>
                                <div class="me-1 mb-1">
                                    <label class="form-label" for="status">Status</label>
                                    <select class="select2 form-select" id="status" name="status" required>
                                        <option value="">Select Status</option>
                                        <option value="pending">Pending</option>
                                        <option value="accepted">Accepted</option>
                                        <option value="cancelled">Cancelled</option>
                                        <option value="completed">Completed</option>
                                    </select>
                                    <div class="invalid-feedback status-error"></div>
                                </div>
                                <div class="me-1 mb-1">
                                    <label class="form-label" for="price">Amount</label>
                                    <input type="number" id="price" name="price" class="form-control" placeholder="Enter Amount of Booking" required/>
                                    <div class="invalid-feedback price-error"></div>
                                </div>
                                <div class="me-1 mb-1">
                                    <label class="form-label" for="description">Description</label>
                                    <textarea class="form-control" id="description" name="description" placeholder="Enter Description"></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary data-submit me-1">Submit</button>
                                <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
              <!-- Modal -->

              <!-- Modal to Update new record -->
              <div class="modal modal-slide-in fade" id="modals-slide-in-edit">
                <div class="modal-dialog sidebar-sm">
                    <form id="update-booking" class="add-new-record modal-content pt-0" method="POST" action="{{ route('admin.booking.update') }}" enctype="multipart/form-data">
                        @csrf
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
                        <div class="modal-header mb-1">
                            <h5 class="modal-title" id="exampleModalLabel">Update Booking</h5>
                        </div>
                        <input type="hidden" class="booking_id" id="booking_id" name="booking_id" />

                        <div class="modal-body flex-grow-1">
                            <div class="me-1 mb-1">
                                <label class="form-label" for="client_id">Clients</label>
                                <select class="select2 form-select" id="client_id_Edit" name="client_id" required>
                                    <option value="">Select Client</option>
                                    @foreach ($clients as $client)
                                        <option value="{{$client->id}}">{{$client->name}} - {{$client->phone}}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback client_id-error"></div>
                            </div>
                            <div class="me-1 mb-1">
                                <label class="form-label" for="labour_id">Labours</label>
                                {{-- <select class="select2 form-select" id="labour_id_Edit" name="labour_id" required>
                                    <option value="">Select Labour</option>
                                    @foreach ($labours as $labour)
                                        <option value="{{$labour->id}}">{{$labour->name}} - {{$labour->phone}}</option>
                                    @endforeach
                                </select> --}}
                                <select class="select2 form-select" name="labour_id[]" multiple="multiple" id="labour_id_Edit" required>
                                    @foreach ($labours as $labour)
                                        <option value="{{$labour->id}}">{{$labour->name}} - {{$labour->phone}}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback labour_id-error"></div>
                            </div>
                            <div class="me-1 mb-1">
                                <label class="form-label" for="start_date">Start Date</label>
                                <input type="text" id="start_date_edit" name="start_date" class="form-control flatpickr-date-time" placeholder="YYYY-MM-DD HH:MM" required/>
                                <div class="invalid-feedback start_date-error"></div>
                            </div>
                            <div class="me-1 mb-1">
                                <label class="form-label" for="end_date">End Date</label>
                                <input type="text" id="end_date_edit" name="end_date" class="form-control flatpickr-date-time" placeholder="YYYY-MM-DD HH:MM" />
                                <div class="invalid-feedback end_date-error"></div>
                            </div>
                            <div class="me-1 mb-1">
                                <label class="form-label" for="price">Amount</label>
                                <input type="number" id="price_edit" name="price" class="form-control" placeholder="Enter Amount of Booking" required/>
                                <div class="invalid-feedback price-error"></div>
                            </div>
                            <div class="me-1 mb-1">
                                <label class="form-label" for="description">Description</label>
                                <textarea class="form-control" id="description_edit" name="description" placeholder="Enter Description"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary data-submit me-1">Submit</button>
                            <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
          <!-- Modal -->

            </section>
            <!--/ Basic table -->
        </div>
    </div>
</div>
<!-- END: Content-->
@endsection
@section('footer')
    <script src="../../../app-assets/vendors/js/tables/datatable/jquery.dataTables.min.js"></script>
    <script src="../../../app-assets/vendors/js/tables/datatable/dataTables.bootstrap5.min.js"></script>
    <script src="../../../app-assets/vendors/js/tables/datatable/dataTables.responsive.min.js"></script>
    <script src="../../../app-assets/vendors/js/tables/datatable/responsive.bootstrap5.min.js"></script>
    <script src="../../../app-assets/vendors/js/tables/datatable/datatables.checkboxes.min.js"></script>
    <script src="../../../app-assets/vendors/js/tables/datatable/datatables.buttons.min.js"></script>
    <script src="../../../app-assets/vendors/js/tables/datatable/jszip.min.js"></script>
    <script src="../../../app-assets/vendors/js/tables/datatable/pdfmake.min.js"></script>
    <script src="../../../app-assets/vendors/js/tables/datatable/vfs_fonts.js"></script>
    <script src="../../../app-assets/vendors/js/tables/datatable/buttons.html5.min.js"></script>
    <script src="../../../app-assets/vendors/js/tables/datatable/buttons.print.min.js"></script>
    <script src="../../../app-assets/vendors/js/tables/datatable/dataTables.rowGroup.min.js"></script>
    <script src="../../../app-assets/vendors/js/pickers/flatpickr/flatpickr.min.js"></script>
    <!-- BEGIN: Page JS-->
    <script src="../../../app-assets/js/booking/custom.js"></script>
    <script src="../../../app-assets/vendors/js/forms/select/select2.full.min.js"></script>
    <script src="../../../app-assets/js/scripts/forms/form-select2.js"></script>

    <script src="../../../app-assets/vendors/js/pickers/pickadate/picker.js"></script>
    <script src="../../../app-assets/vendors/js/pickers/pickadate/picker.date.js"></script>
    <script src="../../../app-assets/js/scripts/forms/pickers/form-pickers.js"></script>
    <!-- END: Page JS-->
@endsection
