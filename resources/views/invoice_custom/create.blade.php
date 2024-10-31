@extends('layouts.master')

@section('content')

<!-- <div class="content d-flex flex-column flex-column-fluid" id="kt_content"> -->

<!--begin::Toolbar-->
<div class="toolbar" id="kt_toolbar">

    <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
        <!--begin::Page title-->
        <div data-kt-swapper="true" data-kt-swapper-mode="prepend"
            data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}"
            class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
            <!--begin::Title-->
            <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Custom Invoice Forms
                <!--begin::Separator-->
                <span class="h-20px border-gray-200 border-start ms-3 mx-2"></span>
                <!--end::Separator-->
                <!--begin::Description-->
                <small class="text-muted fs-7 fw-bold my-1 ms-1">Fill up the Custom Invoice form</small>
                <!--end::Description-->
            </h1>
            <!--end::Title-->
        </div>
        <!--end::Page title-->
        <!--begin::Actions-->
        <div class="d-flex align-items-center py-1">
            <!--begin::Wrapper-->

            <!--end::Wrapper-->
            <!--begin::Button-->
            <a href="{{ route('invoice-custom-index') }}" class="btn btn-sm btn-primary" id="kt_toolbar_primary_button">Custom Invoice Form List</a>
            <!--end::Button-->
        </div>
        <!--end::Actions-->
    </div>
    <!--begin::Container-->

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
                        <h3 class="fw-bolder m-0">Custom Invoice Create</h3>
                    </div>
                    <!--end::Card title-->
                </div>

                <!-- Card Body-->
                <div class="card-body">

                    <!-- Start Form-->

                    <form class="g-form w-100" action="{{ route('invoice-custom-store') }}" enctype="multipart/form-data" method="POST">
                        @csrf


                        <div class="row">
                            <div class="col-md-6">
                                <div class="fv-row mb-3">
                                    <!--begin::Label-->
                                    <label class="form-label fw-bolder text-dark">Invoice Name</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input class="form-control form-control-sm form-control-solid"
                                        type="text" name="invoice_name" value="{{ old('invoice_name') }}" autocomplete="off" />
                                    <!--end::Input-->
                                    @if ($errors->has('invoice_name'))
                                    <span class="text-danger">{{ $errors->first('invoice_name') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="row justify-content-center align-items-center mb-3">

                                <div class="col-md-6" style="text-align: right;">
                                    <button type="button" class="btn btn-sm btn-success" onclick="addField()"><i
                                            class="bi bi-plus-lg"></i> Add Field
                                    </button>
                                </div>
                            </div>

                            <div class="row mb-3 field-group">
                                <div class="col-md-4">
                                    <div class="fv-row">
                                        <label class="form-label fw-bolder text-dark">Field Name</label>
                                        <input class="form-control form-control-sm form-control-solid" type="text" name="field_details[0][field_name]" autocomplete="off" />

                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="fv-row">
                                        <label class="form-label fw-bolder text-dark">Field Value</label>
                                        <input class="form-control form-control-sm form-control-solid" type="text" name="field_details[0][field_value]" autocomplete="off" />

                                    </div>
                                </div>


                                <div class="col-md-4">
                                    <div class="fv-row mt-8 text-center" style="padding-left:34px">
                                        <button type="button" class="btn btn-sm btn-danger py-1 py-0" onclick="removeField(this)"><i class="bi bi-x pe-0 pb-1"></i></button>
                                    </div>
                                    <!--end::Input-->
                                </div>
                            </div>




                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label fw-bolder text-dark" for="textarea">Bank Details</label>
                                    <textarea class="form-control form-control-sm  form-control-solid" name="bank_details" rows="3">{{ old('bank_details') }}</textarea>
                                    @if ($errors->has('bank_details'))
                                    <span class="text-danger">{{ $errors->first('bank_details') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label fw-bolder text-dark" for="textarea">Issued By</label>
                                    <textarea class="form-control form-control-sm  form-control-solid" name="issued_by" rows="3">{{ old('issued_by') }}</textarea>
                                    @if ($errors->has('issued_by'))
                                    <span class="text-danger">{{ $errors->first('issued_by') }}</span>
                                    @endif
                                </div>
                            </div>


                        </div>
                        <!--End Row-->
                        <div class="card-footer d-flex justify-content-end py-6 px-9">
                            <a href="{{ route('agents-create') }}" class="btn btn-light me-2">Reset</a>
                            <button type="submit" class="btn btn-primary"
                                id="kt_account_profile_details_submit">Save Changes
                            </button>
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



<script>

</script>

<!-- End Forms-->


<!-- </div> -->
<!--end::Content-->


@endsection