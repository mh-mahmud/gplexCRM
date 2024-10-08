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
            <div class="card card-xxl-stretch mt-4">
                <div class="card-header bg-light bd-cyan">
                    <!--begin::Card title-->
                    <div class="card-title m-0">
                        <h3 class="fw-bolder m-0">New Invoice</h3>
                    </div>
                    <!--end::Card title-->
                </div>

                <!-- Card Body-->
                <div class="card-body">

                    <!-- Start Form-->

                    <form class="g-form g-proposal w-100" action="{{ route('add-product-pro') }}" method="POST">
                        <div class="row">
                            <!--Left Part-->
                            <div class="col-xl-6">
                                <div class="row">


                                    <div class="col-md-12">
                                        <div class="fv-row mb-5">
                                            <label class="form-label fw-bolder text-dark">Customer

                                            </label>
                                            <select class="form-control form-control-sm form-control-solid" name="customer_id" aria-label="Default select example">
                                                <option selected>Select Customer</option>
                                                @foreach($customers as $customer)
                                                <option value="{{ $customer->id }}">
                                                    {{ $customer->customer_group }}
                                                </option>
                                                @endforeach
                                            </select>

                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="fv-row mb-5">
                                            <label class="form-label fw-bolder text-dark" for="textarea">Bill To</label>
                                            <textarea class="form-control form-control-sm  form-control-solid" id="address" name="address" rows="3">{{ old('address') }}</textarea>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="fv-row mb-5">
                                            <!--begin::Label-->
                                            <label class="form-label fw-bolder text-dark">
                                                Invoice Number

                                                <span class="text-danger">*</span>
                                            </label>
                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <div class="input-group">
                                                <span class="input-group-text bg-light">INV-</span>
                                                <input class="form-control form-control-sm"
                                                    type="text" name="invoice_number" id="invoice_number"
                                                    value="{{ old('invoice_number', sprintf('%06d', $nextInvoiceNumber)) }}" />
                                            </div>
                                            <!--end::Input-->
                                        </div>
                                    </div>

                                    <div class="col-xl-6">

                                        <div class="fv-row mb-5">
                                            <!--begin::Label-->
                                            <label class="form-label fw-bolder text-dark">
                                                Invoice Date<span class="text-danger">*</span></label>

                                            <!--end::Label-->
                                            <!--begin::Input-->
                                            <div class="position-relative">
                                                <input type="text" class="form-control form-control-sm form-control-solid flatpickr date" placeholder="Date" name="invoice_date" value="{{ old('invoice_date') }}">
                                                @if ($errors->has('invoice_date'))
                                                <span class="text-danger">{{ $errors->first('invoice_date') }}</span>
                                                @endif
                                            </div>

                                        </div>

                                    </div>

                                    <div class="col-xl-6">

                                        <div class="fv-row mb-5">
                                            <label class="form-label fw-bolder text-dark">
                                                Due Date</label>

                                            <div class="position-relative">
                                                <input type="text" class="form-control form-control-sm form-control-solid flatpickr date" placeholder="Due Date" name="due_date" value="{{ old('due_date') }}">
                                                @if ($errors->has('due_date'))
                                                <span class="text-danger">{{ $errors->first('due_date') }}</span>
                                                @endif
                                            </div>
                                        </div>

                                    </div>


                                    {{-- <div class="col-md-6">
                                                <div class="form-check form-switch form-check-light">
                                                    <label class="form-label fw-bolder text-dark g-proposal-c-label"
                                                           for="status">Allow Comments</label>
                                                    <div>
                                                        <input class="form-check-input" type="checkbox" value=""
                                                               id="status"
                                                               name="status" checked="checked"/>
                                                    </div>
                                                </div>
                                            </div> --}}

                                </div>
                            </div>

                            <!--Right Part-->
                            <div class="col-xl-6">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="fv-row mb-5">
                                            <label class="form-label fw-bolder text-dark">Allowed payment modes for this invoice

                                            </label>
                                            <select class=" form-control form-control-sm form-control-solid" name="payment_mode"
                                                aria-label="Default select example">
                                                <option value="" selected>Nothing Selected</option>
                                                <option value="Bank">Bank</option>
                                                <option value="Stripe Checkout">Stripe Checkout</option>

                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="fv-row mb-5">
                                            <label class="form-label fw-bolder text-dark">Currency</label>
                                            <select class=" form-control form-control-sm form-control-solid" id="currency" name="currency"
                                                aria-label="Default select example">
                                                <option value=''>Select</option>
                                                @foreach($currencies as $currency)
                                                <option value="{{$currency->id}}" {{ old('currency') == $currency->id ? 'selected' : '' }}>{{ $currency->name }} </option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('currency'))
                                            <span class="text-danger">{{ $errors->first('currency') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="fv-row mb-5">
                                            <label class="form-label fw-bolder text-dark">Sale Agent</label>
                                            <select class="form-control form-control-sm form-control-solid" name="sale_agent_id" aria-label="Default select example">
                                                <option value="" selected>Nothing Selected</option>
                                                @foreach($agents as $agent)
                                                <option value="{{ $agent->agent_id }}">{{ $agent->first_name }} {{ $agent->last_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>



                                    <div class="col-md-6">
                                        <div class="fv-row mb-5">
                                            <label class="form-label fw-bolder text-dark">Discount Type</label>
                                            <select class="form-control form-control-sm form-control-solid" name="discount_type" aria-label="Default select example">
                                                <option value="" disabled selected>Nothing Selected</option>
                                                @foreach($discountTypes as $type)
                                                <option value="{{ $type }}">{{ $type }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="fv-row mb-5">
                                            <label class="form-label fw-bolder text-dark" for="textarea">Admin Note</label>
                                            <textarea class="form-control form-control-sm  form-control-solid" id="address" name="address" rows="3">{{ old('admin_note') }}</textarea>
                                        </div>
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
                                                        name="product_id" data-placeholder="Add an item" id="product-select">
                                                        <option value="" selected>Nothing Selected</option>
                                                        @foreach($products as $product)
                                                        <option value="{{ $product->id }}"
                                                            data-description="{{ $product->description }}"
                                                            data-rate="{{ $product->rate }}">
                                                            {{ $product->name }}
                                                        </option>
                                                        @endforeach
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
                                                <input class="form-check-input" type="radio" value="" id="g-qty" name="quantity" />
                                                <label class="form-check-label" for="g-qty">
                                                    qty
                                                </label>
                                            </div>
                                            <div class="form-check form-check-custom form-check-solid">
                                                <input class="form-check-input" type="radio" value="" id="g-hours" name="quantity" />
                                                <label class="form-check-label" for="g-hours">
                                                    hours
                                                </label>
                                            </div>
                                            <div class="form-check form-check-custom form-check-solid">
                                                <input class="form-check-input" type="radio" value="" id="g-qty-hours" name="quantity" />
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
                                                    </select>
                                                </td>
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
                                                    <td class="text-end"><strong>BDT</strong> -0.00</td>
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

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="fv-row mb-5">
                                            <label class="form-label fw-bolder text-dark" for="textarea">Client Note</label>
                                            <textarea class="form-control form-control-sm  form-control-solid" id="address" name="client_note" rows="3">{{ old('client_note') }}</textarea>
                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="fv-row mb-5">
                                            <label class="form-label fw-bolder text-dark" for="textarea">Terms & Conditions</label>
                                            <textarea class="form-control form-control-sm  form-control-solid" id="address" name="terms_condition" rows="3">{{ old('terms_condition') }}</textarea>
                                        </div>
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

<script>
    $(document).ready(function() {
        // Listen for changes in the product select dropdown
        $('#product-select').on('change', function() {
            // Get the selected product option
            var selectedOption = $(this).find('option:selected');

            // Get the product data from data attributes
            var itemName = selectedOption.text();
            var description = selectedOption.data('description');
            var rate = selectedOption.data('rate');

            // Populate the table fields with the selected product data
            $('#item-name').val(itemName);
            $('#item-description').val(description);
            $('#item-rate').val(rate);

            // Optionally calculate the amount (quantity * rate)
            var quantity = $('#item-quantity').val();
            if (quantity && rate) {
                $('#item-amount').text((quantity * rate).toFixed(2));
            }
        });

        // Listen for changes in the quantity field to update the amount
        $('#item-quantity').on('input', function() {
            var quantity = $(this).val();
            var rate = $('#item-rate').val();
            if (quantity && rate) {
                $('#item-amount').text((quantity * rate).toFixed(2));
            }
        });

        // Listen for changes in the rate field to update the amount
        $('#item-rate').on('input', function() {
            var rate = $(this).val();
            var quantity = $('#item-quantity').val();
            if (quantity && rate) {
                $('#item-amount').text((quantity * rate).toFixed(2));
            }
        });
    });
</script>
<!-- End Forms-->


<!-- </div> -->
<!--end::Content-->


@endsection