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
                            <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Dynamic Table
                                <!--begin::Separator-->
                                <span class="h-20px border-gray-200 border-start ms-3 mx-2"></span>
                                <!--end::Separator-->
                                <!--begin::Description-->
                                <small class="text-muted fs-7 fw-bold my-1 ms-1">Fill up Dynamic Table </small>
                                <!--end::Description--></h1>
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
                                                    <input class="form-check-input" type="checkbox" value="1"/>
                                                    <span class="form-check-label">Author</span>
                                                </label>
                                                <!--end::Options-->
                                                <!--begin::Options-->
                                                <label
                                                    class="form-check form-check-sm form-check-custom form-check-solid">
                                                    <input class="form-check-input" type="checkbox" value="2"
                                                           checked="checked"/>
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
                                                       name="notifications" checked="checked"/>
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
                            <a href="{{ route('dynamictable-index') }}" class="btn btn-sm btn-primary" id="kt_toolbar_primary_button">Dynamic Table List</a>
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
                            <div class="card card-xxl-stretch mt-5">
                                <div class="card-header">
                                    <!--begin::Card title-->
                                    <div class="card-title m-0">
                                        <h3 class="fw-bolder m-0">Dynamic Table Create</h3>
                                    </div>
                                    <!--end::Card title-->
                                </div>

                                <!-- Card Body-->
                                <div class="card-body">

                                    <!-- Start Form-->

                                    <form class="g-form w-100" action="{{ route('dynamictable-store') }}"  enctype="multipart/form-data" method="POST">
                                         @csrf
                                        <div class="row">
                                            

                                            <div class="col-md-6">
                                                <div class="fv-row mb-3">
                                                    <label class="form-label fw-bolder text-dark">Form Name</label>
                                                    <select class=" form-control form-control-sm form-control-solid" name="form_id"
                                                            aria-label="Default select example">
                                                            <option value="">Select Form Name</option>
                                                            @foreach($formName as $id => $name)
                                                                <option value="{{ $id }}">{{$name}}</option>
                                                            @endforeach
                                                        
                                                    </select>
                                                    @if ($errors->has('form_id'))
                                                        <span class="text-danger">{{ $errors->first('form_id') }}</span>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="fv-row mb-3">
                                                    <!--begin::Label-->
                                                    <label class="form-label fw-bolder text-dark">
                                                        Table Name</label>
                                                    <!--end::Label-->
                                                    <!--begin::Input-->
                                                    <input class="form-control form-control-sm form-control-solid"
                                                           type="text" name="table_name" autocomplete="off"/>
                                                    <!--end::Input-->
                                                    @if ($errors->has('table_name'))
                                                        <span class="text-danger">{{ $errors->first('table_name') }}</span>
                                                    @endif
                                                   
                                                </div>
                                            </div>
                                        <div class="row mb-3" id="fields">
                                            <div class="col-md-2">
                                                <div class="fv-row">
                                                    <!--begin::Label-->
                                                    <label class="form-label fw-bolder text-dark">Field Name</label>
                                                    <!--end::Label-->
                                                    <!--begin::Input-->
                                                    <input class="form-control form-control-sm form-control-solid" type="text" name="fields[0][name]" autocomplete="off" />
                                                    @if ($errors->has('fields.0.name'))
                                                        <span class="text-danger">{{ $errors->first('fields.0.name') }}</span>
                                                    @endif
                                                    
                                                    <!--end::Input-->
                                                </div>
                                            </div>

                                            <div class="col-md-2">
                                                <div class="fv-row">
                                                    <!--begin::Label-->
                                                    <label class="form-label fw-bolder text-dark">Field Value</label>
                                                    <select class="form-control form-control-sm form-control-solid" name="fields[0][type]" aria-label="Default select example">
                                                        <option value="">Select Field Value</option>
                                                        <option value="varchar">String</option>
                                                        <option value="char">Character</option>
                                                        <option value="int">Integer</option>
                                                        <option value="date">Date</option>
                                                        <option value="text">Text</option>
                                                        <option value="boolean">Boolean</option>
                                                    </select>
                                                     @if ($errors->has('fields.0.type'))
                                                        <span class="text-danger">{{ $errors->first('fields.0.type') }}</span>
                                                    @endif
                                                    <!--end::Input-->
                                                </div>
                                            </div>

                                            <div class="col-md-2">
                                                <div class="fv-row">
                                                    <!--begin::Label-->
                                                    <label class="form-label fw-bolder text-dark">Character Length</label>
                                                    <!--end::Label-->
                                                    <!--begin::Input-->
                                                    <input class="form-control form-control-sm form-control-solid" type="number" name="fields[0][character_length]" autocomplete="off" />
                                                    <!--end::Input-->
                                                </div>
                                            </div>

                                            <div class="col-md-1">
                                                <div class="fv-row mb-3">
                                                    <!--begin::Label-->
                                                    <label class="form-label fw-bolder text-dark">Is Index</label>
                                                    <!--end::Label-->
                                                    <!--begin::Input-->
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="fields[0][is_index]" value="1">
                                                        <label class="form-check-label">Is Index</label>
                                                    </div>
                                                    <!--end::Input-->
                                                </div>
                                            </div>

                                            <div class="col-md-1">
                                                <div class="fv-row mb-3">
                                                    <!--begin::Label-->
                                                    <label class="form-label fw-bolder text-dark">Is Null</label>
                                                    <!--end::Label-->
                                                    <!--begin::Input-->
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="fields[0][is_null]" value="1">
                                                        <label class="form-check-label">Is Null</label>
                                                    </div>
                                                    <!--end::Input-->
                                                </div>
                                            </div>

                                            <div class="col-md-2">
                                                <div class="fv-row mb-3">
                                                    <!--begin::Label-->
                                                    <label class="form-label fw-bolder text-dark">Is Unique</label>
                                                    <!--end::Label-->
                                                    <!--begin::Input-->
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="fields[0][is_unique]" value="1">
                                                        <label class="form-check-label">Is Unique</label>
                                                    </div>
                                                    <!--end::Input-->
                                                </div>
                                            </div>

                                            <div class="col-md-2">
                                                <div class="fv-row mt-8 text-center">
                                                    <button type="button" class="btn btn-sm btn-success" onclick="addField()"><i class="bi bi-plus-lg"></i></button>
                                                </div>
                                            </div>
                                        </div>

                                        <!--End Row-->

                                            


                                           

                                     </div>
                                        <!--End Row-->
                                      <div class="card-footer d-flex justify-content-end py-6 px-9">
                                        <a href="{{ route('dynamictable-create') }}" class="btn btn-light me-2">Reset</a>
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
function addField() {
    const fields = document.getElementById('fields');
    const fieldCount = fields.children.length;
    const newFieldGroup = document.createElement('div');
    newFieldGroup.className = 'row mb-3 field-group';

    newFieldGroup.innerHTML = `
        <div class="col-md-2">
            <div class="fv-row">
                <label class="form-label fw-bolder text-dark">Field Name</label>
                <input class="form-control form-control-sm form-control-solid" type="text" name="fields[${fieldCount}][name]" autocomplete="off" required />
            </div>
        </div>

        <div class="col-md-2">
            <div class="fv-row">
                <label class="form-label fw-bolder text-dark">Field Value</label>
                <select class="form-control form-control-sm form-control-solid" name="fields[${fieldCount}][type]" aria-label="Default select example" required>
                    <option value="">Select Field Value</option>
                    <option value="varchar">String</option>
                    <option value="char">Character</option>
                    <option value="int">Integer</option>
                    <option value="date">Date</option>
                    <option value="text">Text</option>
                    <option value="boolean">Boolean</option>
                </select>
            </div>
        </div>

        <div class="col-md-2">
            <div class="fv-row">
                <label class="form-label fw-bolder text-dark">Character Length</label>
                <input class="form-control form-control-sm form-control-solid" type="number" name="fields[${fieldCount}][character_length]" autocomplete="off" />
            </div>
        </div>

        <div class="col-md-1">
            <div class="fv-row mb-3">
                <label class="form-label fw-bolder text-dark">Is Index</label>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="fields[${fieldCount}][is_index]" value="1">
                    <label class="form-check-label">Is Index</label>
                </div>
            </div>
        </div>

        <div class="col-md-1">
            <div class="fv-row mb-3">
                <label class="form-label fw-bolder text-dark">Is Null</label>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="fields[${fieldCount}][is_null]" value="1">
                    <label class="form-check-label">Is Null</label>
                </div>
            </div>
        </div>

        <div class="col-md-2">
            <div class="fv-row mb-3">
                <label class="form-label fw-bolder text-dark">Is Unique</label>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="fields[${fieldCount}][is_unique]" value="1">
                    <label class="form-check-label">Is Unique</label>
                </div>
            </div>
        </div>

        <div class="col-md-2">
            <div class="fv-row mt-8 text-center" style="padding-left:34px">
                <button type="button" class="btn btn-sm btn-danger" onclick="removeField(this)"><i class="bi bi-x-lg"></i></button>
            </div>
        </div>
    `;
    fields.appendChild(newFieldGroup);
}

function removeField(button) {
    const fieldGroup = button.closest('.field-group');
    fieldGroup.remove();
}

</script>


                <!-- End Forms-->


            <!-- </div> -->
            <!--end::Content-->
           

@endsection