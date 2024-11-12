@extends('layouts.master')

@section('content')

<!-- <div class="content d-flex flex-column flex-column-fluid" id="kt_content"> -->

<!--begin::Toolbar-->
<div class="toolbar" id="kt_toolbar">
    <!--begin::Container-->
    <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
        <!--begin::Page title-->
        <div data-kt-swapper="true" data-kt-swapper-mode="prepend"
            data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}"
            class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
            <!--begin::Title-->
            <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Product Specification Forms
                <!--begin::Separator-->
                <span class="h-20px border-gray-200 border-start ms-3 mx-2"></span>
                <!--end::Separator-->
                <!--begin::Description-->
                <small class="text-muted fs-7 fw-bold my-1 ms-1">Fill up the Product Specification form</small>
                <!--end::Description-->
            </h1>
            <!--end::Title-->
        </div>
        <!--end::Page title-->
        <!--begin::Actions-->
        <div class="d-flex align-items-center py-1">
            <!--begin::Wrapper-->
            <div class="me-4">
                <!--begin::Menu-->

                <!--begin::Menu 1-->
                <div class="menu menu-sub menu-sub-dropdown w-250px w-md-300px" data-kt-menu="true"
                    id="kt_menu_61484bf44d957">
                    <!--begin::Header-->
                    <div class="px-7 py-5">
                        <div class="fs-5 text-dark fw-bolder">Filter Options</div>
                    </div>
                    <!--end::Header-->
                    <!--begin::Menu separator-->
                    <div class="separator border-gray-200"></div>
                    <!--end::Menu separator-->
                    <!--begin::Form-->
                    <div class="px-7 py-5">
                        <!--begin::Input group-->
                        <div class="mb-10">
                            <!--begin::Label-->
                            <label class="form-label fw-bold">Status:</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <div>
                                <select class="form-select form-select-solid" data-kt-select2="true"
                                    data-placeholder="Select option"
                                    data-dropdown-parent="#kt_menu_61484bf44d957"
                                    data-allow-clear="true">
                                    <option></option>
                                    <option value="1">Approved</option>
                                    <option value="2">Pending</option>
                                    <option value="2">In Process</option>
                                    <option value="2">Rejected</option>
                                </select>
                            </div>
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="mb-10">
                            <!--begin::Label-->
                            <label class="form-label fw-bold">Member Type:</label>
                            <!--end::Label-->
                            <!--begin::Options-->
                            <div class="d-flex">
                                <!--begin::Options-->
                                <label
                                    class="form-check form-check-sm form-check-custom form-check-solid me-5">
                                    <input class="form-check-input" type="checkbox" value="1" />
                                    <span class="form-check-label">Author</span>
                                </label>
                                <!--end::Options-->
                                <!--begin::Options-->
                                <label
                                    class="form-check form-check-sm form-check-custom form-check-solid">
                                    <input class="form-check-input" type="checkbox" value="2"
                                        checked="checked" />
                                    <span class="form-check-label">Customer</span>
                                </label>
                                <!--end::Options-->
                            </div>
                            <!--end::Options-->
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="mb-10">
                            <!--begin::Label-->
                            <label class="form-label fw-bold">Notifications:</label>
                            <!--end::Label-->
                            <!--begin::Switch-->
                            <div
                                class="form-check form-switch form-switch-sm form-check-custom form-check-solid">
                                <input class="form-check-input" type="checkbox" value=""
                                    name="notifications" checked="checked" />
                                <label class="form-check-label">Enabled</label>
                            </div>
                            <!--end::Switch-->
                        </div>
                        <!--end::Input group-->
                        <!--begin::Actions-->
                        <div class="d-flex justify-content-end">
                            <button type="reset"
                                class="btn btn-sm btn-light btn-active-light-primary me-2"
                                data-kt-menu-dismiss="true">Reset
                            </button>
                            <button type="submit" class="btn btn-sm btn-primary"
                                data-kt-menu-dismiss="true">Apply
                            </button>
                        </div>
                        <!--end::Actions-->
                    </div>
                    <!--end::Form-->
                </div>
                <!--end::Menu 1-->
                <!--end::Menu-->
            </div>
            <!--end::Wrapper-->
            <!--begin::Button-->
            <a href="{{ route('product-specification-index') }}" class="btn btn-sm btn-primary" id="kt_toolbar_primary_button">Product Specification List</a>
            <!--end::Button-->
        </div>
        <!--end::Actions-->
    </div>
    <!--end::Container-->
</div>
<!--end::Toolbar-->

<!--**********************************
                                Forms
                  ***********************************-->
<div class="container-xxl">
    <div class="row">
        <div class="col-xxl-12">
            <div class="card card-xxl-stretch mt-4">
                <!-- <div class="card card-xxl-stretch"> -->
                <div class="card-header bg-light bd-cyan">
                    <!--begin::Card title-->
                    <div class="card-title m-0">
                        <h3 class="fw-bolder m-0">Product Specification Create</h3>
                    </div>
                    <!--end::Card title-->
                </div>

                <!-- Card Body-->
                <div class="card-body">

                    <!-- Start Form-->

                    <form class="g-form w-100" action="{{ route('product-specification-store') }}" enctype="multipart/form-data" method="POST">
                        @csrf
                        <div class="row">
                           
                            <div class="col-md-4">
                                <label class="form-label fw-bolder text-dark">Product</label>
                                <select class="form-control form-control-sm form-control-solid" name="product_id" required>
                                    <option value="">Select Product</option>
                                    @foreach ($products as $product)
                                    <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                        {{ $product->name }}
                                    </option>
                                    @endforeach
                                </select>
                                @if ($errors->has('product_id'))
                                <div class="text-danger">{{ $errors->first('product_id') }}</div>
                                @endif
                            </div>

                            
                            <div class="col-md-4">
                                <label class="form-label fw-bolder text-dark">Work Order Number</label>
                                <input class="form-control form-control-sm form-control-solid" type="text" name="work_order_number" value="{{ old('work_order_number') }}" required />
                                @if ($errors->has('work_order_number'))
                                <div class="text-danger">{{ $errors->first('work_order_number') }}</div>
                                @endif
                            </div>

                         
                            <div class="col-md-4">
                                <label class="form-label fw-bolder text-dark">Work Order Value</label>
                                <input class="form-control form-control-sm form-control-solid" type="number" name="work_order_value" value="{{ old('work_order_value') }}" step="0.01" required />
                                @if ($errors->has('work_order_value'))
                                <div class="text-danger">{{ $errors->first('work_order_value') }}</div>
                                @endif
                            </div>

                           
                            <div class="col-md-4">
                                <label class="form-label fw-bolder text-dark">Work Order File</label>
                                <input class="form-control form-control-sm form-control-solid" type="file" name="work_order_file" />
                                @if ($errors->has('work_order_file'))
                                <div class="text-danger">{{ $errors->first('work_order_file') }}</div>
                                @endif
                            </div>

                          
                            <div class="col-md-4">
                                <label class="form-label fw-bolder text-dark">Work Order Rate</label>
                                <input class="form-control form-control-sm form-control-solid" type="text" name="work_order_rate" value="{{ old('work_order_rate') }}" />
                                @if ($errors->has('work_order_rate'))
                                <div class="text-danger">{{ $errors->first('work_order_rate') }}</div>
                                @endif
                            </div>

                            
                            <div class="col-md-4">
                                <label class="form-label fw-bolder text-dark">Purchase Order Value</label>
                                <input class="form-control form-control-sm form-control-solid" type="number" name="purchase_order_value" value="{{ old('purchase_order_value') }}" step="0.01" />
                                @if ($errors->has('purchase_order_value'))
                                <div class="text-danger">{{ $errors->first('purchase_order_value') }}</div>
                                @endif
                            </div>

                          
                            <div class="col-md-4">
                                <label class="form-label fw-bolder text-dark">Purchase Order File</label>
                                <input class="form-control form-control-sm form-control-solid" type="file" name="purchase_order_file" />
                                @if ($errors->has('purchase_order_file'))
                                <div class="text-danger">{{ $errors->first('purchase_order_file') }}</div>
                                @endif
                            </div>

                           
                            <div class="col-md-4">
                                <label class="form-label fw-bolder text-dark">AMC Start Date</label>
                                <input class="form-control form-control-sm form-control-solid flatpickr" type="text" id="common_dob" name="amc_start_date" value="{{ old('amc_start_date') }}" />
                                @if ($errors->has('amc_start_date'))
                                <div class="text-danger">{{ $errors->first('amc_start_date') }}</div>
                                @endif
                            </div>

                            
                            <div class="col-md-4">
                                <label class="form-label fw-bolder text-dark">AMC Renewal Date</label>
                                <input class="form-control form-control-sm form-control-solid flatpickr" type="text" id="common_dob" name="amc_renewal_date" value="{{ old('amc_renewal_date') }}" />
                                @if ($errors->has('amc_renewal_date'))
                                <div class="text-danger">{{ $errors->first('amc_renewal_date') }}</div>
                                @endif
                            </div>

                           
                            <div class="col-md-4">
                                <label class="form-label fw-bolder text-dark">AMC Rate</label>
                                <input class="form-control form-control-sm form-control-solid" type="text" name="amc_rate" value="{{ old('amc_rate') }}" />
                                @if ($errors->has('amc_rate'))
                                <div class="text-danger">{{ $errors->first('amc_rate') }}</div>
                                @endif
                            </div>

                          
                            <div class="col-md-4">
                                <label class="form-label fw-bolder text-dark">AMC Effective Amount</label>
                                <input class="form-control form-control-sm form-control-solid" type="number" name="amc_effective_amount" value="{{ old('amc_effective_amount') }}" step="0.01" />
                                @if ($errors->has('amc_effective_amount'))
                                <div class="text-danger">{{ $errors->first('amc_effective_amount') }}</div>
                                @endif
                            </div>

                            
                            <div class="col-md-4">
                                <label class="form-label fw-bolder text-dark">AMC Agreement Documents</label>
                                <input class="form-control form-control-sm form-control-solid" type="file" name="amc_agreement_documents" />
                                @if ($errors->has('amc_agreement_documents'))
                                <div class="text-danger">{{ $errors->first('amc_agreement_documents') }}</div>
                                @endif
                            </div>

                          
                            <div class="col-md-4">
                                <label class="form-label fw-bolder text-dark">Service Type</label>
                                <input class="form-control form-control-sm form-control-solid" type="text" name="service_type" value="{{ old('service_type') }}" />
                                @if ($errors->has('service_type'))
                                <div class="text-danger">{{ $errors->first('service_type') }}</div>
                                @endif
                            </div>

                           
                            <div class="col-md-4">
                                <label class="form-label fw-bolder text-dark">Software Value</label>
                                <textarea class="form-control form-control-sm form-control-solid" name="software_value" rows="3">{{ old('software_value') }}</textarea>
                                @if ($errors->has('software_value'))
                                <div class="text-danger">{{ $errors->first('software_value') }}</div>
                                @endif
                            </div>

                           
                            <div class="col-md-4">
                                <label class="form-label fw-bolder text-dark">Hardware Value</label>
                                <textarea class="form-control form-control-sm form-control-solid" name="hardware_value" rows="3">{{ old('hardware_value') }}</textarea>
                                @if ($errors->has('hardware_value'))
                                <div class="text-danger">{{ $errors->first('hardware_value') }}</div>
                                @endif
                            </div>

                          
                            <div class="col-md-4">
                                <label class="form-label fw-bolder text-dark">Implementation Value</label>
                                <textarea class="form-control form-control-sm form-control-solid" name="implementation_value" rows="3">{{ old('implementation_value') }}</textarea>
                                @if ($errors->has('implementation_value'))
                                <div class="text-danger">{{ $errors->first('implementation_value') }}</div>
                                @endif
                            </div>

                           
                            <div class="col-md-4">
                                <label class="form-label fw-bolder text-dark">Invoice Mushak File</label>
                                <input class="form-control form-control-sm form-control-solid" type="file" name="invoice_mushak_file" />
                                @if ($errors->has('invoice_mushak_file'))
                                <div class="text-danger">{{ $errors->first('invoice_mushak_file') }}</div>
                                @endif
                            </div>

                            
                            <div class="col-md-4">
                                <label class="form-label fw-bolder text-dark">Tax Exemption Certificate</label>
                                <input class="form-control form-control-sm form-control-solid" type="file" name="tax_exemption_certificate" />
                                @if ($errors->has('tax_exemption_certificate'))
                                <div class="text-danger">{{ $errors->first('tax_exemption_certificate') }}</div>
                                @endif
                            </div>

                           
                            <div class="col-md-4">
                                <label class="form-label fw-bolder text-dark">Note</label>
                                <textarea class="form-control form-control-sm form-control-solid" name="note" rows="3">{{ old('note') }}</textarea>
                                @if ($errors->has('note'))
                                <div class="text-danger">{{ $errors->first('note') }}</div>
                                @endif
                            </div>

                        
                            <div class="card-footer d-flex justify-content-end py-6 px-9">
                                <a href="{{ route('product-specification-create') }}" class="btn btn-light me-2">Reset</a>
                                <button type="submit" class="btn btn-primary">Save Changes</button>
                            </div>
                        </div>
                    </form>


                    <!-- End Form-->

                </div>
                <!--End Card body-->

                <!--begin::Actions-->

                <!--end::Actions-->
            </div>
        </div>
    </div>
</div>
<!-- End Forms-->


<!-- </div> -->
<!--end::Content-->


@endsection