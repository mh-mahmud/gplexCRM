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
            <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Invoice Forms
                <!--begin::Separator-->
                <span class="h-20px border-gray-200 border-start ms-3 mx-2"></span>
                <!--end::Separator-->
                <!--begin::Description-->
                <small class="text-muted fs-7 fw-bold my-1 ms-1">Fill up the Invoice form</small>
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
            <a href="{{ route('invoice-index') }}" class="btn btn-sm btn-primary" id="kt_toolbar_primary_button">Invoice List</a>
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
                <div class="card-header bg-light bd-cyan">
                    <!--begin::Card title-->
                    <div class="card-title m-0">
                        <h3 class="fw-bolder m-0">Edit New Invoice</h3>
                    </div>
                    <!--end::Card title-->
                </div>

                <!-- Card Body-->
                <div class="card-body">

                    <!-- Start Form-->

                    <form class="g-form g-proposal w-100" action="{{ route('invoice-update', $invoice->id) }}" enctype="multipart/form-data" method="POST">
                        <input type="hidden" name="sub_total" id="subtotal-hidden" value="0.00">
                        <input type="hidden" name="total_amount" id="total-hidden" value="0.00">
                        <input type="hidden" name="total_tax" id="totaltax-hidden" value="0.00">
                        <input type="hidden" name="total_discount" id="totaldiscount-hidden" value="0.00">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <!--Left Part-->
                            <div class="col-xl-6">
                                <div class="row">


                                    <div class="col-md-12">
                                        <div class="fv-row mb-5">
                                            <label class="form-label fw-bolder text-dark">Customer<span class="text-danger">*</span>

                                            </label>
                                            <select class="form-control form-control-sm form-control-solid" name="customer_id">
                                                <option value="" {{ old('customer_id', $invoice->customer_id) == '' ? 'selected' : '' }}>Select Customer</option>
                                                @foreach($customers as $customer)
                                                <option value="{{ $customer->id }}" {{ old('customer_id', $invoice->customer_id) == $customer->id ? 'selected' : '' }}>
                                                {{ $customer->first_name }} {{ $customer->last_name }}
                                                </option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('customer_id'))
                                            <span class="text-danger">{{ $errors->first('customer_id') }}</span>
                                            @endif

                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="fv-row mb-5">
                                            <label class="form-label fw-bolder text-dark" for="address">Bill To</label>
                                            <textarea class="form-control form-control-sm form-control-solid" id="address" name="address" rows="3">{{ old('address', $invoice->address) }}</textarea>
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
                                                    value="{{ old('invoice_number', str_replace('INV-', '', $invoice->invoice_number)) }}" />

                                                @if ($errors->has('invoice_number'))
                                                <span class="text-danger">{{ $errors->first('invoice_number') }}</span>
                                                @endif
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
                                                <input type="text" class="form-control form-control-sm form-control-solid flatpickr date" placeholder="Date" name="invoice_date" value="{{ old('invoice_date', $invoice->invoice_date) }}">
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
                                                <input type="text" class="form-control form-control-sm form-control-solid flatpickr date" placeholder="Due Date" name="due_date" value="{{ old('due_date', $invoice->due_date) }}">
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
                                            <select class="form-control form-control-sm form-control-solid" name="payment_mode">
                                                <option value="" {{ old('payment_mode', $invoice->payment_mode) == '' ? 'selected' : '' }}>Nothing Selected</option>
                                                <option value="Bank" {{ old('payment_mode', $invoice->payment_mode) == 'Bank' ? 'selected' : '' }}>Bank</option>
                                                <option value="Stripe Checkout" {{ old('payment_mode', $invoice->payment_mode) == 'Stripe Checkout' ? 'selected' : '' }}>Stripe Checkout</option>
                                            </select>

                                            @if ($errors->has('payment_mode'))
                                            <span class="text-danger">{{ $errors->first('payment_mode') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="fv-row mb-5">
                                            <label class="form-label fw-bolder text-dark">Currency</label>
                                            <select class="form-control form-control-sm form-control-solid" id="currency" name="currency">
                                                <option value="">Select</option>
                                                @foreach($currencies as $currency)
                                                <option value="{{$currency->id}}" {{ old('currency', $invoice->currency) == $currency->id ? 'selected' : '' }}>{{ $currency->name }}</option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('currency'))
                                            <span class="text-danger">{{ $errors->first('currency') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="fv-row mb-5">
                                            <label class="form-label fw-bolder text-dark">Status

                                            </label>
                                            <select class="form-control form-control-sm form-control-solid" name="invoice_status">
                                                @foreach(config('constants.invoice_status') as $key => $status)
                                                <option value="{{ $key }}" {{ old('invoice_status', $invoice->status) == $key ? 'selected' : '' }}>{{ $status }}</option>
                                                @endforeach
                                            </select>

                                            @if ($errors->has('invoice_status'))
                                            <span class="text-danger">{{ $errors->first('invoice_status') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="fv-row mb-5">
                                            <label class="form-label fw-bolder text-dark">Sale Agent</label>
                                            <select class="form-control form-control-sm form-control-solid" name="sale_agent_id">
                                                <option value="" {{ old('sale_agent_id', $invoice->sale_agent_id) === null ? 'selected' : '' }}>Nothing Selected</option>
                                                @foreach($agents as $agent)
                                                <option value="{{ $agent->agent_id }}" {{ old('sale_agent_id', $invoice->sale_agent_id) == $agent->agent_id ? 'selected' : '' }}>
                                                    {{ $agent->first_name }} {{ $agent->last_name }}
                                                </option>
                                                @endforeach
                                            </select>

                                            @if ($errors->has('sale_agent_id'))
                                            <span class="text-danger">{{ $errors->first('sale_agent_id') }}</span>
                                            @endif
                                        </div>
                                    </div>



                                    <div class="col-md-6">
                                        <div class="fv-row mb-5">
                                            <label class="form-label fw-bolder text-dark">Discount Type</label>
                                            <select class="form-control form-control-sm form-control-solid" name="discount_type_name">
                                                <option value="" {{ old('discount_type_name', $invoice->discount_type) === null ? 'selected' : '' }}>Nothing Selected</option>
                                                @foreach($discountTypes as $type)
                                                <option value="{{ $type }}" {{ old('discount_type_name', $invoice->discount_type) == $type ? 'selected' : '' }}>{{ $type }}</option>
                                                @endforeach
                                            </select>

                                            @if ($errors->has('discount_type'))
                                            <span class="text-danger">{{ $errors->first('discount_type') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="fv-row mb-5">
                                            <label class="form-label fw-bolder text-dark" for="textarea">Admin Note</label>
                                            <textarea class="form-control form-control-sm form-control-solid" id="admin_note" name="admin_note" rows="3">{{ old('admin_note', $invoice->admin_note) }}</textarea>
                                            @if ($errors->has('admin_note'))
                                            <span class="text-danger">{{ $errors->first('admin_note') }}</span>
                                            @endif
                                        </div>
                                    </div>






                                </div>
                            </div>


                        </div>
                        <!--End Row-->

                        <div class="my-3 overflow-hidden">

                            <div class="card">
                                <div class="card-header p-0">
                                    <div
                                        class="g-proposal-add-item d-flex flex-wrap justify-content-between align-items-center w-100 gap-3">
                                        <div>
                                            <!--begin::Both add-ons-->
                                            <div class="input-group input-group-sm min-w-300px w-100 w-md-500px">
                                                <div class="flex-grow-1">
                                                    <select class="form-select form-select-sm rounded-end-0 border-end" data-control="select2" name="product_id" data-placeholder="Add an item" id="product-select">
                                                        <option value="" {{ old('product_id') == '' ? 'selected' : '' }}>Nothing Selected</option>
                                                        @foreach($products as $product)
                                                        <option value="{{ $product->id }}"
                                                            data-name="{{ $product->name }}"
                                                            data-description="{{ $product->description }}"
                                                            data-rate="{{ $product->product_value }}"
                                                            {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                                            {{ $product->name }}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                    @if ($errors->has('product_id'))
                                                    <span class="text-danger">{{ $errors->first('product_id') }}</span>
                                                    @endif
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
                                    <!--Invoice Table Preview-->
                                    <table class="table table-rounded table-sm table-striped border align-middle gs-2" id="proposal-table">
                                        <thead>
                                            <tr class="fw-bold fs-6 text-gray-800 border-bottom border-gray-200">
                                                <th>Item</th>
                                                <th>Description</th>
                                                <th>Qty</th>
                                                <th>Rate</th>
                                                <th>Tax</th>
                                                <th>Amount</th>
                                                <th><i class="bi bi-gear-fill"></i></th>
                                            </tr>
                                        </thead>


                                        <tbody id="table-body">
                                            @foreach($invoiceItems as $item)

                                            <tr>
                                                <td>
                                                    <textarea class="form-control form-control-sm min-w-250px" name="items[item_name][]" cols="30" rows="2"
                                                        id="item-name" placeholder="Item Name" readonly>{{ $item['Item'] }}</textarea>
                                                        @error('items.*.item_name')
                                                    <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </td>
                                                <td>
                                                    <textarea class="form-control form-select-sm min-w-250px" name="items[description][]" cols="30" rows="2"
                                                        id="item-description" placeholder="Description">{{ $item['Description'] }}</textarea>
                                                </td>
                                                <td>
                                                    <input class="form-control form-control-sm" type="number" name="items[quantity][]" id="item-quantity"
                                                        placeholder="Quantity" value="{{$item['Qty'] }}">
                                                </td>
                                                <td>
                                                    <input class="form-control form-control-sm" type="number" name="items[rate][]" id="item-rate"
                                                        placeholder="Rate" value="{{ $item['Rate']}}">
                                                </td>
                                                <td>
                                                    <select class="form-select form-select-sm" data-control="select2" data-placeholder="No Tax" id="item-tax"
                                                        name="items[tax][]">
                                                        <option value="" {{ $item['Tax'] == '' ? 'selected' : '' }}>No Tax (0.00%)</option>
                                                        <option value="5.00" {{ $item['Tax'] == '5.00' ? 'selected' : '' }}>5.00%</option>
                                                        <option value="10.00" {{ $item['Tax'] == '10.00' ? 'selected' : '' }}>10.00%</option>
                                                        <option value="15.00" {{ $item['Tax'] == '15.00' ? 'selected' : '' }}>15.00%</option>
                                                    </select>
                                                </td>
                                                <td class="item-amount">{{ $item['Amount'] }}</td>
                                                <td>
                                                    <button type="button" class="btn btn-sm btn-danger py-2 px-2 remove-row">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            @endforeach
                                            <tr>
                                                <td>
                                                    <textarea class="form-control form-control-sm min-w-250px" name="items[item_name][]" cols="30" rows="2"
                                                        id="item-name" placeholder="Item Name" readonly></textarea>
                                                </td>
                                                <td>
                                                    <textarea class="form-control form-select-sm min-w-250px" name="items[description][]" cols="30" rows="2"
                                                        id="item-description" placeholder="Description"></textarea>
                                                </td>
                                                <td>
                                                    <input class="form-control form-control-sm" type="number" name="items[quantity][]" id="item-quantity"
                                                        placeholder="Quantity">
                                                </td>
                                                <td>
                                                    <input class="form-control form-control-sm" type="number" name="items[rate][]" id="item-rate"
                                                        placeholder="Rate">
                                                </td>
                                                <td>
                                                    <select class="form-select form-select-sm" data-control="select2" data-placeholder="No Tax" id="item-tax"
                                                        name="items[tax][]">
                                                        <option value="0.00">No Tax (0.00%)</option>
                                                        <option value="5.00">5.00%</option>
                                                        <option value="10.00">10.00%</option>
                                                        <option value="15.00">15.00%</option>
                                                    </select>
                                                </td>
                                                <td class="item-amount">0.00</td>
                                                <td>
                                                    <button type="button" class="btn btn-sm btn-primary py-2 px-2 add-row">
                                                        <i class="bi bi-check"></i>
                                                    </button>
                                                </td>
                                            </tr>

                                             <!-- <tr>

                                                <td>
                                                    <textarea class="form-control form-control-sm min-w-250px" name="items[item_name][]" cols="30" rows="2" id="item-name" placeholder="Item Name">{{ old('items.item_name.0') }}</textarea>
                                                    @error('items.item_name.0')
                                                    <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </td>


                                                <td>
                                                    <textarea class="form-control form-control-sm min-w-250px" name="items[description][]" cols="30" rows="2" id="item-description" placeholder="Description">{{ old('items.description.0') }}</textarea>
                                                    @error('items.description.0')
                                                    <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </td>


                                                <td>
                                                    <input class="form-control form-control-sm" type="number" name="items[quantity][]" id="item-quantity" placeholder="Quantity" value="{{ old('items.quantity.0') }}">
                                                    @error('items.quantity.0')
                                                    <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </td>


                                                <td>
                                                    <input class="form-control form-control-sm" type="number" name="items[rate][]" id="item-rate" placeholder="Rate" value="{{ old('items.rate.0') }}">
                                                    @error('items.rate.0')
                                                    <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </td>


                                                <td>
                                                    <select class="form-select form-select-sm" name="items[tax][]">
                                                        <option value="0.00" {{ old('items.tax.0') == '0.00' ? 'selected' : '' }}>No Tax (0.00%)</option>
                                                        <option value="5.00" {{ old('items.tax.0') == '5.00' ? 'selected' : '' }}>5.00%</option>
                                                        <option value="10.00" {{ old('items.tax.0') == '10.00' ? 'selected' : '' }}>10.00%</option>
                                                        <option value="15.00" {{ old('items.tax.0') == '15.00' ? 'selected' : '' }}>15.00%</option>
                                                    </select>
                                                    @error('items.tax.0')
                                                    <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </td>


                                                <td class="item-amount">0.00</td>


                                                <td>
                                                    <button type="button" class="btn btn-sm btn-primary py-2 px-2 add-row">
                                                        <i class="bi bi-check"></i>
                                                    </button>
                                                </td>
                                            </tr> -->
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
                                                    <td class="text-end"><strong>BDT</strong> <span id="subtotal-amount">{{ old('sub_total', $invoice->sub_total) }}</span></td>
                                                </tr>
                                                <tr>
                                                    <th><strong>Discount :</strong>
                                                        <div class="input-group flex-nowrap">
                                                            <div class="flex-grow-1">
                                                                <input class="form-control form-control-sm rounded-end-0 border-end" type="number" name="discount" placeholder="Discount">
                                                            </div>
                                                            <select class="form-select form-select-sm form-control-sm" name="discount_type">
                                                                <option value="fixed">Fixed Amount</option>
                                                                <option value="percentage">%</option>
                                                            </select>
                                                        </div>
                                                    </th>
                                                    <td class="text-end"><strong>BDT</strong> <span id="discount-amount">-{{ old('discount', $invoice->discount) }}</span></td>
                                                </tr>
                                                <!-- New Tax Row -->
                                                <tr>
                                                    <th class="text-end"><strong>Total Tax:</strong></th>
                                                    <td class="text-end"><strong>BDT</strong> <span id="total-tax-amount">{{ old('total_tax', $invoice->total_tax) }}</span></td>
                                                </tr>
                                                <tr>
                                                    <th><strong>Adjustment :</strong>
                                                        <input class="form-control form-control-sm" type="number" name="adjustment" placeholder="Adjustment">
                                                    </th>
                                                    <td class="text-end"><strong>BDT</strong> <span id="adjustment-amount">{{ old('adjustment', $invoice->adjustment) }}</span></td>
                                                </tr>
                                                <tr>
                                                    <th class="text-end"><strong>Total</strong></th>
                                                    <td class="text-end">
                                                        <strong>BDT</strong> <span id="total-amount">{{ old('total_amount', $invoice->total_amount) }}</span>
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
                                            <textarea class="form-control form-control-sm  form-control-solid" id="client_note" name="client_note" rows="3">{{ old('client_note', $invoice->client_note) }}</textarea>
                                            @if ($errors->has('client_note'))
                                            <span class="text-danger">{{ $errors->first('client_note') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="fv-row mb-5">
                                            <label class="form-label fw-bolder text-dark" for="textarea">Terms & Conditions</label>
                                            <textarea class="form-control form-control-sm  form-control-solid" id="address" name="terms_conditions" rows="3">{{ old('terms_conditions', $invoice->terms_conditions) }}</textarea>
                                            @if ($errors->has('terms_condition'))
                                            <span class="text-danger">{{ $errors->first('terms_condition') }}</span>
                                            @endif
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

        //function to calculate row amount including tax
        function calculateRowAmount_Backup(row) {
            var quantity = parseFloat(row.find('input[name="items[quantity][]"]').val()) || 0;
            var rate = parseFloat(row.find('input[name="items[rate][]"]').val()) || 0;
            var taxRate = parseFloat(row.find('select[name="items[tax][]"]').val()) || 0;

            var amount = quantity * rate;
            var taxAmount = amount * (taxRate / 100);
            var totalAmount = amount + taxAmount;

            row.find('.item-amount').text(totalAmount.toFixed(2));
            return totalAmount;
        }

        //function to calculate the subtotal
        function calculateSubtotal_backup() {
            var subtotal = 0;
            $('#table-body tr').each(function() {
                var row = $(this);
                var rowAmount = calculateRowAmount(row);
                subtotal += rowAmount;
            });
            return subtotal;
        }

        //function to calculate and update the total
        function updateTotal_backup() {
            var subtotal = calculateSubtotal();
            var discountValue = parseFloat($('input[name="discount"]').val()) || 0;
            var discountType = $('select[name="discount_type"]').val();
            var adjustmentValue = parseFloat($('input[name="adjustment"]').val()) || 0;

            //count discount
            if (discountType === 'percentage') {
                discountValue = (subtotal * discountValue) / 100;
            }

            var discountedSubtotal = subtotal - discountValue;
            var total = discountedSubtotal + adjustmentValue;

            //update values on the view
            $('#subtotal-amount').text(subtotal.toFixed(2));
            $('#discount-amount').text('-' + discountValue.toFixed(2));
            $('#adjustment-amount').text(adjustmentValue.toFixed(2));
            $('#total-amount').text(total.toFixed(2));

            //update hidden input values
            $('#subtotal-hidden').val(subtotal.toFixed(2));
            $('#total-hidden').val(total.toFixed(2));
        }

        //function to calculate row amount including tax
        function calculateRowAmount(row) {
            var quantity = parseFloat(row.find('input[name="items[quantity][]"]').val()) || 0;
            var rate = parseFloat(row.find('input[name="items[rate][]"]').val()) || 0;
            var taxRate = parseFloat(row.find('select[name="items[tax][]"]').val()) || 0;

            var amount = quantity * rate;
            var taxAmount = amount * (taxRate / 100);
            var totalAmount = amount + taxAmount;

            row.find('.item-amount').text(totalAmount.toFixed(2));
            return {
                totalAmount: totalAmount,
                taxAmount: taxAmount
            };
        }

        //function to calculate the subtotal and total tax
        function calculateSubtotalAndTax() {
            var subtotal = 0;
            var totalTax = 0;
            $('#table-body tr').each(function() {
                var row = $(this);
                var rowData = calculateRowAmount(row);
                subtotal += rowData.totalAmount - rowData.taxAmount; //subtotal excluding tax
                totalTax += rowData.taxAmount; //total tax
            });
            return {
                subtotal: subtotal,
                totalTax: totalTax
            };
        }

        //function to calculate and update the total
        function updateTotal() {
            var values = calculateSubtotalAndTax();
            var subtotal = values.subtotal;
            var totalTax = values.totalTax;
            var discountValue = parseFloat($('input[name="discount"]').val()) || 0;
            var discountType = $('select[name="discount_type"]').val();
            var adjustmentValue = parseFloat($('input[name="adjustment"]').val()) || 0;

            //count discount
            if (discountType === 'percentage') {
                discountValue = (subtotal * discountValue) / 100;
            }

            var discountedSubtotal = subtotal - discountValue;
            var total = discountedSubtotal + adjustmentValue + totalTax; // total includes tax

            //update values on the view
            $('#subtotal-amount').text(subtotal.toFixed(2));
            $('#discount-amount').text('-' + discountValue.toFixed(2));
            $('#adjustment-amount').text(adjustmentValue.toFixed(2));
            $('#total-tax-amount').text(totalTax.toFixed(2)); // update total tax
            $('#total-amount').text(total.toFixed(2));

            //update hidden input values
            $('#subtotal-hidden').val(subtotal.toFixed(2));
            $('#total-hidden').val(total.toFixed(2));
            $('#totaltax-hidden').val(totalTax.toFixed(2));
            $('#totaldiscount-hidden').val(discountValue.toFixed(2));
        }

        //add new row logic
        $(document).on('click', '.add-row', function() {
            var lastRow = $('#table-body tr:last'); //reference to the last row

            //ensure necessary fields in the last row are filled before adding a new row
            var itemName = lastRow.find('textarea[name="items[item_name][]"]').val();
            var description = lastRow.find('textarea[name="items[description][]"]').val();
            var quantity = lastRow.find('input[name="items[quantity][]"]').val();
            var rate = lastRow.find('input[name="items[rate][]"]').val();

            if (itemName !== "" && quantity !== "" && rate !== "") {
                //all fields are filled, add a new row
                var newRow = `<tr>
                   <td>
                       <textarea class="form-control form-control-sm min-w-250px" name="items[item_name][]" cols="30" rows="2"
                           placeholder="Item Name" readonly></textarea>
                   </td>
                   <td>
                       <textarea class="form-control form-select-sm min-w-250px" name="items[description][]" cols="30" rows="2"
                           placeholder="Description"></textarea>
                   </td>
                   <td>
                       <input class="form-control form-control-sm" type="number" name="items[quantity][]"
                           placeholder="Quantity">
                   </td>
                   <td>
                       <input class="form-control form-control-sm" type="number" name="items[rate][]"
                           placeholder="Rate">
                   </td>
                   <td>
                       <select class="form-select form-select-sm" name="items[tax][]">
                           <option value="0.00">No Tax (0.00%)</option>
                           <option value="5.00">5.00%</option>
                           <option value="10.00">10.00%</option>
                           <option value="15.00">15.00%</option>
                       </select>
                   </td>
                   <td class="item-amount">0.00</td>
                   <td>
                       <button type="button" class="btn btn-sm btn-danger py-2 px-2 remove-row">
                           <i class="bi bi-trash"></i>
                       </button>
                   </td>
               </tr>`;

                //append the new row to the table body
                $('#table-body').append(newRow);

                //clear the product selection
                $('#product-select').val('').trigger('change');
                //when add more row click this input hide
                $('input[name="discount"]').val('');
                $('input[name="adjustment"]').val('');
            } else {
                //alert user if any field in the last row is not filled
                alert('Please fill all fields in the last row before adding a new one.');
            }
        });

        //remove row logic
        $(document).on('click', '.remove-row', function() {
            $(this).closest('tr').remove();
            updateTotal(); //recalculate total after row removal
        });

        //handle product selection and populate only the last row
        $('#product-select').on('change', function() {
            var selectedOption = $(this).find('option:selected');

            //get selected product details
            var productName = selectedOption.data('name');
            var productDescription = selectedOption.data('description');
            var productRate = selectedOption.data('rate');
            //get the last row in the table
            var lastRow = $('#table-body tr:last');
            //set values in the last row
            lastRow.find('textarea[name="items[item_name][]"]').val(productName);
            lastRow.find('textarea[name="items[description][]"]').val(productDescription);
            lastRow.find('input[name="items[rate][]"]').val(productRate);

            //optionally calculate the amount ex(quantity * rate)
            var quantity = lastRow.find('input[name="items[quantity][]"]').val();
            if (quantity && productRate) {
                lastRow.find('.item-amount').text((quantity * productRate).toFixed(2));
            }
        });

        //changes in the quantity, rate, or tax fields to update the row amount
        $(document).on('input change', 'input[name="items[quantity][]"], input[name="items[rate][]"], select[name="items[tax][]"]', function() {
            var row = $(this).closest('tr');
            calculateRowAmount(row);
            updateTotal();
        });

        //changes in the discount or adjustment inputs
        $('input[name="discount"], select[name="discount_type"], input[name="adjustment"]').on('input change', function() {
            updateTotal();
        });
    });
</script>

<!-- End Forms-->


<!-- </div> -->
<!--end::Content-->


@endsection