@extends('layouts.master')

@section('content')

            <!-- <div class="content d-flex flex-column flex-column-fluid" id="kt_content"> -->

            						     <!--begin::Toolbar-->
	  <div class="toolbar" id="kt_toolbar">
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
                    <div class="card card-xxl-stretch mt-5">
                        <div class="card-header bg-light bd-cyan">
                            <!--begin::Card title-->
                            <div class="card-title m-0">
                                <h3 class="fw-bolder m-0">New Proposal</h3>
                            </div>
                            <!--end::Card title-->
                        </div>

                        <!-- Card Body-->
                        <div class="card-body">

                            <!-- Start Form-->

                            <form class="g-form g-proposal w-100" action="{{ route('add-product-pro') }}"  method="POST">
                                <div class="row">
                                    <!--Left Part-->
                                    <div class="col-xl-6">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="fv-row mb-5">
                                                    <!--begin::Label-->
                                                    <label class="form-label fw-bolder text-dark">Name<span class="text-danger">*</span></label>
                                                    <!--end::Label-->
                                                    <!--begin::Input-->
                                                    <input class="form-control form-control-sm form-control-solid"
                                                           type="text" name="name" autocomplete="off" value="{{ old('name') }}" />
                                                    <!--end::Input-->
                                                    @if ($errors->has('name'))
                                                        <span class="text-danger">{{ $errors->first('name') }}</span>
                                                    @endif
                                                    <!--end::Input-->
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="fv-row mb-5">
                                                    <label class="form-label fw-bolder text-dark">Related
                                                        <sup><i class="bi bi-asterisk text-danger"></i></sup>
                                                    </label>
                                                    <select class=" form-control form-control-sm form-control-solid"
                                                            aria-label="Default select example">
                                                        <option selected>Nothing Selected</option>
                                                        <option value="1">One</option>
                                                        <option value="2">Two</option>
                                                        <option value="3">Three</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-xl-6">

                                                <div class="fv-row mb-5">
                                                    <!--begin::Label-->
                                                    <label for="g-proposal-datepicker"
                                                           class="form-label fw-bolder text-dark">Date
                                                        <sup><i class="bi bi-asterisk text-danger"></i></sup>
                                                    </label>
                                                    <!--end::Label-->
                                                    <input class="form-control form-control-sm form-control-solid ps-12"
                                                           name="date" placeholder="Pick a date"
                                                           id="g-proposal-datepicker"/>

                                                </div>

                                            </div>

                                            <div class="col-xl-6">

                                                <div class="fv-row mb-5">
                                                    <!--begin::Label-->
                                                    <label for="g-proposal-opentill"
                                                           class="form-label fw-bolder text-dark">Open Till
                                                        <sup><i class="bi bi-asterisk text-danger"></i></sup>
                                                    </label>
                                                    <!--end::Label-->
                                                    <input class="form-control form-control-sm form-control-solid ps-12"
                                                           name="date" placeholder="Pick a date"
                                                           id="g-proposal-opentill"/>

                                                </div>

                                            </div>

                                            <div class="col-md-6">
                                                <div class="fv-row mb-5">
                                                    <label class="form-label fw-bolder text-dark">Currency
                                                        <sup><i class="bi bi-asterisk text-danger"></i></sup>
                                                    </label>
                                                    <select class=" form-control form-control-sm form-control-solid"
                                                            aria-label="Default select example">
                                                        <option selected>Open this select menu</option>
                                                        <option value="1">One</option>
                                                        <option value="2">Two</option>
                                                        <option value="3">Three</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="fv-row mb-5">
                                                    <label class="form-label fw-bolder text-dark">Discount Type
                                                    </label>
                                                    <select class=" form-control form-control-sm form-control-solid"
                                                            aria-label="Default select example">
                                                        <option selected>Open this select menu</option>
                                                        <option value="1">One</option>
                                                        <option value="2">Two</option>
                                                        <option value="3">Three</option>
                                                    </select>
                                                </div>
                                            </div>


                                            <div class="col-md-6">
                                                <div class="form-check form-switch form-check-light">
                                                    <label class="form-label fw-bolder text-dark g-proposal-c-label"
                                                           for="status">Allow Comments</label>
                                                    <div>
                                                        <input class="form-check-input" type="checkbox" value=""
                                                               id="status"
                                                               name="status" checked="checked"/>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                    <!--Right Part-->
                                    <div class="col-xl-6">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="fv-row mb-5">
                                                    <!--begin::Label-->
                                                    <label class="form-label fw-bolder text-dark">Email</label>
                                                    <!--end::Label-->
                                                    <!--begin::Input-->
                                                    <input class="form-control form-control-sm form-control-solid"
                                                           type="email" name="email" autocomplete="off"/>
                                                    <!--end::Input-->
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="fv-row mb-5">
                                                    <!--begin::Label-->
                                                    <label class="form-label fw-bolder text-dark">First
                                                        Name</label>
                                                    <!--end::Label-->
                                                    <!--begin::Input-->
                                                    <input class="form-control form-control-sm form-control-solid"
                                                           type="text" name="email" autocomplete="off"/>
                                                    <!--end::Input-->
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="fv-row mb-5">
                                                    <!--begin::Label-->
                                                    <label class="form-label fw-bolder text-dark">Last Name</label>
                                                    <!--end::Label-->
                                                    <!--begin::Input-->
                                                    <input class="form-control form-control-sm form-control-solid"
                                                           type="text" name="email" autocomplete="off"/>
                                                    <!--end::Input-->
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="fv-row mb-5">
                                                    <!--begin::Label-->
                                                    <label class="form-label fw-bolder text-dark">Password</label>
                                                    <!--end::Label-->
                                                    <!--begin::Input-->
                                                    <input class="form-control form-control-sm form-control-solid"
                                                           type="password" name="email" autocomplete="off"/>
                                                    <!--end::Input-->
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="fv-row mb-5">
                                                    <!--begin::Label-->
                                                    <label class="form-label fw-bolder text-dark">Retype
                                                        Password</label>
                                                    <!--end::Label-->
                                                    <!--begin::Input-->
                                                    <input class="form-control form-control-sm form-control-solid"
                                                           type="password" name="email" autocomplete="off"/>
                                                    <!--end::Input-->
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="fv-row mb-5">
                                                    <!--begin::Label-->
                                                    <label class="form-label  fw-bolder text-dark">File
                                                        Upload</label>
                                                    <!--end::Label-->
                                                    <!--begin::Input-->
                                                    <input class="form-control form-control-sm form-control-solid"
                                                           type="file" name="email" autocomplete="off"/>
                                                    <!--end::Input-->
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="fv-row mb-5">
                                                    <!--begin::Label-->
                                                    <label class="form-label  fw-bolder text-dark">Number</label>
                                                    <!--end::Label-->
                                                    <!--begin::Input-->
                                                    <input class="form-control form-control-sm form-control-solid"
                                                           type="number" name="email" autocomplete="off"/>
                                                    <!--end::Input-->
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="fv-row mb-5">
                                                    <label class="form-label fw-bolder text-dark">Select Options</label>
                                                    <select class=" form-control form-control-sm form-control-solid"
                                                            aria-label="Default select example">
                                                        <option selected>Open this select menu</option>
                                                        <option value="1">One</option>
                                                        <option value="2">Two</option>
                                                        <option value="3">Three</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="fv-row mb-5">
                                                    <label class="form-label fw-bolder text-dark">Select Company</label>
                                                    <select class=" form-control form-control-sm form-control-solid"
                                                            aria-label="Default select example">
                                                        <option selected>Open this select menu</option>
                                                        <option value="1">One</option>
                                                        <option value="2">Two</option>
                                                        <option value="3">Three</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label fw-bolder text-dark"
                                                           for="g-proposal-textarea">Textarea</label>
                                                    <textarea class="form-control form-control-sm  form-control-solid"
                                                              name="g-proposal-textarea" rows="3"
                                                              id="g-proposal-textarea"></textarea>
                                                </div>
                                            </div>


                                            <div class="col-md-6">

                                                <div class="fv-row form-label">
                                                    <label class="col-lg-4 fw-bolder text-dark">Communication</label>
                                                </div>

                                                <!--begin::Options-->
                                                <div class="d-flex align-items-center">
                                                    <!--begin::Option-->
                                                    <label class="form-check form-check-inline form-check-solid">
                                                        <input class="form-check-input" name="communication[]"
                                                               type="checkbox" value="1"/>
                                                        <span class="fw-bold ps-2 fs-6">Email</span>
                                                    </label>
                                                    <!--end::Option-->
                                                    <!--begin::Option-->
                                                    <label class="form-check form-check-inline form-check-solid">
                                                        <input class="form-check-input" name="communication[]"
                                                               type="checkbox" value="2"/>
                                                        <span class="fw-bold ps-2 fs-6">Phone</span>
                                                    </label>
                                                    <!--end::Option-->
                                                </div>
                                                <!--end::Options-->
                                            </div>


                                        </div>
                                    </div>


                                </div>
                                <!--End Row-->

                                <div class="container-fluid mt-2 overflow-hidden">

                                    <div class="card">
                                        <div class="card-header">
                                            <div
                                                class="g-proposal-add-item d-flex flex-wrap justify-content-between align-items-center w-100 gap-3">
                                                <div>
                                                    <!--begin::Both add-ons-->
                                                    <div class="input-group input-group-sm min-w-300px w-100 w-md-500px">
                                                        <div class="flex-grow-1">
                                                            <select class="form-select form-select-sm rounded-end-0 border-end" data-control="select2"
                                                                    data-placeholder="Add an item">
                                                                <option></option>
                                                                <option value="1">Option 1</option>
                                                                <option value="2">Option 2</option>
                                                                <option value="3">Option 3</option>
                                                                <option value="4">Option 4</option>
                                                                <option value="5">Option 5</option>
                                                            </select>
                                                        </div>
                                                        <span class="input-group-sm input-group-text"><i class="bi bi-plus fs-4"></i></span>
                                                    </div>
                                                    <!--end::Both add-ons-->
                                                </div>
                
                
                                                <div class="g-right-proposal-table-header d-flex align-items-center gap-3">
                
                                                    <div class="min-w-sm-100px">
                                                        <strong>Show quantity as: </strong>
                                                    </div>
                
                                                    <div class="form-check form-check-custom form-check-solid">
                                                        <input class="form-check-input" type="radio" value="" id="g-qty" name="quantity"/>
                                                        <label class="form-check-label" for="g-qty">
                                                            qty
                                                        </label>
                                                    </div>
                                                    <div class="form-check form-check-custom form-check-solid">
                                                        <input class="form-check-input" type="radio" value="" id="g-hours" name="quantity"/>
                                                        <label class="form-check-label" for="g-hours">
                                                            hours
                                                        </label>
                                                    </div>
                                                    <div class="form-check form-check-custom form-check-solid">
                                                        <input class="form-check-input" type="radio" value="" id="g-qty-hours" name="quantity"/>
                                                        <label class="form-check-label" for="g-qty-hours">
                                                            qty/hours
                                                        </label>
                                                    </div>
                
                                                </div>
                
                                            </div>
                                        </div>
                
                
                                        
                                            <div class="table-responsive">
                                                <!--Proposal Table Preview-->
                                                <table class="table table-rounded table-sm table-striped border align-middle gs-2">
                                                    <thead>
                                                    <tr class="fw-bold fs-6 text-gray-800 border-bottom border-gray-200">
                                                        <th>Item</th>
                                                        <th>Description</th>
                                                        <th>Qty</th>
                                                        <th>Rate</th>
                                                        <th>Tax</th>
                                                        <th>Amount</th>
                                                        <th><i class="bi bi-gear-fill"></i>
                                                        </th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr>
                                                        <td>
                                                            <textarea class="form-control form-control-sm min-w-250px" name="" cols="30" rows="2"
                                                                      placeholder="Description"></textarea>
                                                        </td>
                                                        <td>
                                                            <textarea class="form-control form-select-sm min-w-250px" name="" cols="30" rows="2"
                                                                      placeholder="Long Description"></textarea>
                                                        </td>
                                                        <td>
                                                            <input class="form-control form-control-sm" type="number" name="" placeholder="Unit">
                                                        </td>
                                                        <td>
                                                            <input class="form-control form-control-sm" type="number" name="" placeholder="Rate">
                                                        </td>
                                                        <td>
                                                            <select class="form-select form-select-sm" data-control="select2"
                                                                    data-placeholder="No Tax">
                                                                <option></option>
                                                                <option value="1">Option 1</option>
                                                                <option value="2">Option 2</option>
                                                            </select></td>
                                                        <td>320,800</td>
                                                        <td>
                                                            <button type="button" class="btn btn-sm btn-primary py-2 px-2">
                                                                <i class="bi bi-check"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                
                                                    </tbody>
                                                </table>
                
                                                <!--End Proposal Table Preview-->
                                            </div>
                
                
                                            <div class="row">
                                                <div class="col-md-4 ms-auto ">
                                                    <!-- Proposal Calculations-->
                                                    <div class="table-responsive bg-light-warning rounded-2 p-3">
                                                        <table class="table table-sm table-row-bordered align-middle">
                                                            <tr>
                                                                <th class="text-end"><strong>Sub Total:</strong></th>
                                                                <td class="text-end"><strong>BDT</strong> 0.00</td>
                                                            </tr>
                                                            <tr>
                                                                <th><strong>Discount :</strong>
                                                                    <div class="input-group">
                                                                        <div class="flex-grow-1">
                                                                            <input
                                                                                class="form-control form-control-sm rounded-end-0 border-end"
                                                                                type="text" name="">
                                                                        </div>
                                                                        <select class="form-select form-select-sm form-control-sm"
                                                                                name="" id="">
                                                                            <option value="fixed">Fixed Amount</option>
                                                                            <option value="percentage">%</option>
                                                                        </select>
                                                                    </div>
                
                                                                </th>
                                                                <td class="text-end"> <strong>BDT</strong> -0.00</td>
                                                            </tr>
                                                            <tr>
                                                                <th><strong>Adjustment :</strong>
                                                                    <input class="form-control form-control-sm" type="text" name="">
                                                                </th>
                                                                <td class="text-end"><strong>BDT</strong>  -0.00</td>
                                                            </tr>
                                                            <tr>
                                                                <th class="text-end"><strong>Total</strong></th>
                                                                <td class="text-end">
                                                                    <strong>BDT</strong> 15478.025
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                    <!--End Proposal Calculations-->
                                                </div>
                                            </div>
                
                
                                       
                
                                        <!--begin::Actions-->
                                        <div class="card-footer d-flex justify-content-end py-6 px-9">
                                            <button type="reset" class="btn btn-light btn-active-light-primary me-2">Discard
                                            </button>
                                            <button type="submit" class="btn btn-primary"
                                                    id="kt_account_profile_details_submit">Save Changes
                                            </button>
                                        </div>
                                        <!--end::Actions-->
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