@extends('admin.includes.main')
@section('header')
<meta name="csrf-token" content="{{ csrf_token() }}">


<link rel="stylesheet" type="text/css" href="../../../app-assets/vendors/css/tables/datatable/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/vendors/css/tables/datatable/responsive.bootstrap5.min.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/vendors/css/tables/datatable/buttons.bootstrap5.min.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/vendors/css/tables/datatable/rowGroup.bootstrap5.min.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/vendors/css/pickers/flatpickr/flatpickr.min.css">
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
                        <h2 class="content-header-title float-start mb-0">Labour</h2>
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
                                        <th>Name</th>
                                        <th>Category Name</th>
                                        <th>Phone</th>
                                        <th>Status</th>
                                        <th>CNIC</th>
                                        <th>CNIC Front Img</th>
                                        <th>CNIC Back Img</th>
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
                        <form id="store-labour" class="add-new-record modal-content pt-0" method="POST" action="{{ route('admin.labour.store') }}" enctype="multipart/form-data">
                            @csrf
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
                            <div class="modal-header mb-1">
                                <h5 class="modal-title" id="exampleModalLabel">New Labour</h5>
                            </div>
                            <div class="modal-body flex-grow-1">
                                <div class="mb-1">
                                    <label class="form-label" for="basic-icon-default-fullname">Name</label>
                                    <input type="text" class="form-control labour-name" id="basic-icon-default-fullname" name="name" placeholder="Enter Name of Labour" aria-label="John Doe" required/>
                                    <div class="invalid-feedback name-error"></div>
                                </div>
                                <div class="mb-1">
                                    <label class="form-label" for="basic-icon-default-fullname">Phone Number</label>
                                    <input type="text" class="form-control labour-phone" id="basic-icon-default-fullname" name="phone" placeholder="Enter Phone Number" aria-label="03002200222" required/>
                                    <div class="invalid-feedback phone-error"></div>
                                </div>
                                <div class="mb-1">
                                    <label class="form-label" for="basic-icon-default-post">Category</label>
                                    {{-- select option for category --}}
                                    <select class="form-select labour-category" id="basic-icon-default-post" name="category_id" required>
                                        <option value="">Select Category of Labour</option>
                                        @foreach ($category as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback category_id-error"></div>
                                </div>
                                <div class="mb-1">
                                    <label class="form-label" for="basic-icon-default-fullname">CNIC Number</label>
                                    <input type="text" class="form-control labour-cnic_no" id="basic-icon-default-fullname" name="cnic_no" placeholder="Enter CNIC without dashes" aria-label="3660100000000" required/>
                                    <div class="invalid-feedback cnic_no-error"></div>
                                </div>
                                <div class="mb-1">
                                    <label class="form-label" for="basic-icon-default-fullname">CNIC Front Image</label>
                                    <input type="file" class="form-control labour-cnic_front_img" id="basic-icon-default-fullname" name="cnic_front_img" required/>
                                    <div class="invalid-feedback cnic_front_img-error"></div>
                                </div>
                                <div class="mb-1">
                                    <label class="form-label" for="basic-icon-default-fullname">CNIC Back Image</label>
                                    <input type="file" class="form-control labour-cnic_back_img" id="basic-icon-default-fullname" name="cnic_back_img" required/>
                                    <div class="invalid-feedback cnic_back_img-error"></div>
                                </div>
                                <div class="mb-1">
                                    <label class="form-label" for="basic-icon-default-fullname">Address</label>
                                    <textarea id="basic-icon-default-fullname" class="form-control labour-address" name="address" placeholder="Enter Address" aria-label="Address" required></textarea>
                                    <div class="invalid-feedback address-error"></div>
                                </div>
                                <div class="mb-1">
                                    <div class="form-check form-switch form-check-success">
                                        <label class="form-check-label mb-50" for="customSwitch111">Active</label>
                                        <input type="checkbox" name="status" class="form-check-input" id="customSwitch111" checked />
                                        <label class="form-check-label" for="customSwitch111">
                                            <span class="switch-icon-left"><i data-feather="check"></i></span>
                                            <span class="switch-icon-right"><i data-feather="x"></i></span>
                                        </label>
                                    </div>
                                    <div class="invalid-feedback status-error"></div>
                                </div>
                                <div class="mb-3">
                                    <h5 class="form-label">Account Details</h5>
                                    <div id="account-details-wrapper">
                                        <!-- First account detail fields (No Delete Button) -->
                                        <div class="account-detail mb-2 d-flex align-items-center">
                                            <div class="me-1">
                                                <label class="form-label" for="account-type-0">Account Type</label>
                                                <select class="form-select" name="accounts[0][type]" id="account-type-0" required>
                                                    <option value="">Select Type</option>
                                                    @foreach ($accountTypes as $accountType)
                                                        <option value="{{$accountType->id}}">{{$accountType->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="me-1">
                                                <label class="form-label" for="account-number-0">Account Number</label>
                                                <input type="text" class="form-control" name="accounts[0][number]" id="account-number-0" placeholder="Enter Number" required>
                                            </div>
                                            <div class="me-1">
                                                <label class="form-label" for="account-title-0">Account Title</label>
                                                <input type="text" class="form-control" name="accounts[0][title]" id="account-title-0" placeholder="Enter Title" required>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="button" id="add-account-btn" class="btn btn-info btn-sm mt-1">+ Add</button>
                                </div>
                                <button type="submit" class="btn btn-primary data-submit me-1">Submit</button>
                                <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                            </div>
                        </form>
                        <!-- Hidden template -->
                        <div id="account-template" class="d-none">
                            <div class="account-detail mb-2 d-flex align-items-center">
                                <div class="me-1">
                                    <label class="form-label">Account Type</label>
                                    <select class="form-select" name="accounts[__INDEX__][type]" required>
                                        <option value="">Select Type</option>
                                        @foreach ($accountTypes as $accountType)
                                            <option value="{{$accountType->id}}">{{$accountType->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="me-1">
                                    <label class="form-label">Account Number</label>
                                    <input type="text" class="form-control" name="accounts[__INDEX__][number]" placeholder="Enter Number" required>
                                </div>
                                <div class="me-1">
                                    <label class="form-label">Account Title</label>
                                    <input type="text" class="form-control" name="accounts[__INDEX__][title]" placeholder="Enter Title" required>
                                </div>
                                <button type="button" class="btn btn-danger btn-remove-account mt-2"><i data-feather="x"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
              <!-- Modal -->
              <div class="modal modal-slide-in fade" id="modals-slide-in-edit">
                <div class="modal-dialog sidebar-sm">
                    <form id="update-labour" class="add-new-record modal-content pt-0" method="POST" action="{{ route('admin.labour.update') }}" enctype="multipart/form-data">
                        @csrf

                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
                        <div class="modal-header mb-1">
                            <h5 class="modal-title" id="exampleModalLabel">New Labour</h5>
                        </div>
                        <input type="hidden" class="user_id" id="user_id" name="user_id" />

                        <div class="modal-body flex-grow-1">
                            <div class="mb-1">
                                <label class="form-label" for="basic-icon-default-fullname">Name</label>
                                <input type="text" class="form-control labour-name" id="basic-icon-default-fullname" name="name" placeholder="Enter Name of Labour" aria-label="John Doe" required/>
                                <div class="invalid-feedback name-error"></div>
                            </div>
                            <div class="mb-1">
                                <label class="form-label" for="basic-icon-default-fullname">Phone Number</label>
                                <input type="text" class="form-control labour-phone" id="basic-icon-default-fullname" name="phone" placeholder="Enter Phone Number" aria-label="03002200222" required/>
                                <div class="invalid-feedback phone-error"></div>
                            </div>
                            <div class="mb-1">
                                <label class="form-label" for="basic-icon-default-post">Category</label>
                                {{-- select option for category --}}
                                <select class="form-select labour-category" id="basic-icon-default-post" name="category_id" required>
                                    <option value="">Select Category of Labour</option>
                                    {{-- @foreach ($category as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach --}}
                                </select>
                                <div class="invalid-feedback category_id-error"></div>
                            </div>
                            <div class="mb-1">
                                <label class="form-label" for="basic-icon-default-fullname">CNIC Number</label>
                                <input type="text" class="form-control labour-cnic_no" id="basic-icon-default-fullname" name="cnic_no" placeholder="Enter CNIC without dashes" aria-label="3660100000000" required/>
                                <div class="invalid-feedback cnic_no-error"></div>
                            </div>
                            <div class="mb-1">
                                <label class="form-label" for="basic-icon-default-fullname">CNIC Front Image</label>
                                <input type="file" class="form-control labour-cnic_front_img" id="labour-cnic_front_img" name="labour-cnic_front_img" required/>
                                <div class="invalid-feedback cnic_front_img-error"></div>
                                <div id="front-preview" class="mt-2"></div>

                            </div>
                            <div class="mb-1">
                                <label class="form-label" for="basic-icon-default-fullname">CNIC Back Image</label>
                                <input type="file" class="form-control labour-cnic_back_img" id="labour-cnic_back_img" name="labour-cnic_back_img" required/>
                                <div class="invalid-feedback cnic_back_img-error"></div>
                                <div id="back-preview" class="mt-2"></div>

                            </div>
                            <div class="mb-1">
                                <label class="form-label" for="basic-icon-default-fullname">Address</label>
                                <textarea id="basic-icon-default-fullname" class="form-control labour-address" name="address" placeholder="Enter Address" aria-label="Address" required></textarea>
                                <div class="invalid-feedback address-error"></div>
                            </div>
                          
                            <div class="mb-3">
                                <h5 class="form-label">Account Details</h5>
                                <div id="account-details-wrapper-edit">
                            
                                </div>
                                <button type="button" id="add-account-btn-edit" class="btn btn-info btn-sm mt-1">+ Add</button>
                            </div>
                            <button type="submit" class="btn btn-primary data-submit me-1">Submit</button>
                            <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                    <!-- Hidden template -->
                    <div id="account-template-edit" class="d-none">
                        <div class="account-detail mb-2 d-flex align-items-center">
                            <div class="me-1">
                                <label class="form-label">Account Type</label>
                                <select class="form-select" name="accounts[__INDEX__][type]" required>
                                    <option value="">Select Type</option>
                                    @foreach ($accountTypes as $accountType)
                                        <option value="{{$accountType->id}}">{{$accountType->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="me-1">
                                <label class="form-label">Account Number</label>
                                <input type="text" class="form-control" name="accounts[__INDEX__][number]" placeholder="Enter Number" required>
                            </div>
                            <div class="me-1">
                                <label class="form-label">Account Title</label>
                                <input type="text" class="form-control" name="accounts[__INDEX__][title]" placeholder="Enter Title" required>
                            </div>
                            <button type="submit" class="btn btn-danger btn-remove-account mt-2"><i data-feather="x"></i></button>
                        </div>
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
    <script src="../../../app-assets/js/labour/custom.js"></script>
    <!-- END: Page JS-->
@endsection
