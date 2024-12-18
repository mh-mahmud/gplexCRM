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
            <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1">Custom Invoice Forms
                <!--begin::Separator-->
                <span class="h-20px border-gray-200 border-start ms-3 mx-2"></span>
                <!--end::Separator-->
                <!--begin::Description-->
                <small class="text-muted fs-7 fw-bold my-1 ms-1">Fill up the Custom Invoice Edit form</small>
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
            <a href="{{ route('invoice-custom-index') }}" class="btn btn-sm btn-primary" id="kt_toolbar_primary_button">Custom Invoice List</a>
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
                <div class="card-header bg-light bd-cyan">
                    <div class="card-title m-0">
                        <h3 class="fw-bolder m-0">Custom Invoice Update</h3>
                    </div>
                </div>

                <div class="card-body">
                    
                    <form class="g-form w-100" action="{{ route('invoice-custom-update', $invoice->id) }}" enctype="multipart/form-data" method="POST">
                        @csrf
                        @method('PUT') 

                       
                        <div class="row">
                            <div class="col-md-6">
                                <div class="fv-row mb-3">
                                    <label class="form-label fw-bolder text-dark">Invoice Name</label>
                                    <input class="form-control form-control-sm form-control-solid" type="text" name="invoice_name" value="{{ old('invoice_name', $invoice->invoice_name) }}" autocomplete="off" />
                                    @if ($errors->has('invoice_name'))
                                    <span class="text-danger">{{ $errors->first('invoice_name') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                       
                        <div class="row justify-content-center align-items-center mb-3">
                            <div class="col-md-6">
                                <h3>Item Section</h3>
                            </div>
                            <div class="col-md-6 text-end">
                                <button type="button" class="btn btn-sm btn-success" onclick="addItemField()"><i class="bi bi-plus-lg"></i> Add Field</button>
                            </div>
                        </div>

                        
                        <div id="item-field-group-container">
                            @foreach ($invoice->field_details as $index => $field)
                            <div class="row mb-3 item-field-group">
                                <div class="col-md-4">
                                    <div class="fv-row">
                                        <label class="form-label fw-bolder text-dark">Field Name</label>
                                        <input class="form-control form-control-sm form-control-solid" type="text" name="field_details[{{ $index }}][field_name]" value="{{ old("field_details.$index.field_name", $field['field_name']) }}" autocomplete="off" />
                                        @error("field_details.$index.field_name")
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="fv-row">
                                        <label class="form-label fw-bolder text-dark">Sum</label>
                                        <select class="form-control form-control-sm form-control-solid" name="field_details[{{ $index }}][is_sum]">
                                            <option value=''>Select</option>
                                            <option value='1' {{ old("field_details.$index.is_sum", $field['is_sum']) == '1' ? 'selected' : '' }}>Yes</option>
                                            <option value='0' {{ old("field_details.$index.is_sum", $field['is_sum']) == '0' ? 'selected' : '' }}>No</option>
                                        </select>   
                                        @error("field_details.$index.is_sum")
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="fv-row">
                                        <label class="form-label fw-bolder text-dark">Mandatory</label>
                                        <select class="form-control form-control-sm form-control-solid" name="field_details[{{ $index }}][is_mandatory]">
                                            <option value=''>Select</option>
                                            <option value='1' {{ old("field_details.$index.is_mandatory", $field['is_mandatory']) == '1' ? 'selected' : '' }}>Yes</option>
                                            <option value='0' {{ old("field_details.$index.is_mandatory", $field['is_mandatory']) == '0' ? 'selected' : '' }}>No</option>
                                        </select>   
                                        @error("field_details.$index.is_mandatory")
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                
                                

                                <div class="col-md-4 text-center" style="padding-top: 1.5rem;">
                                    <button type="button" class="btn btn-sm btn-danger" onclick="removeItemField(this)"><i class="bi bi-x"></i></button>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        
                        {{-- <div id="footer-field-group-container">
                            @foreach ($invoice->footer_details as $index => $footer)
                            <div class="row mb-3 footer-field-group">
                                <div class="col-md-4">
                                    <div class="fv-row">
                                        <label class="form-label fw-bolder text-dark">Field Name</label>
                                        <input class="form-control form-control-sm form-control-solid" type="text" name="footer_details[{{ $index }}][field_name]" value="{{ old("footer_details.$index.field_name", $footer['field_name']) }}" autocomplete="off" />
                                        @error("footer_details.$index.field_name")
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="fv-row">
                                        <label class="form-label fw-bolder text-dark">Field Value</label>
                                        <input class="form-control form-control-sm form-control-solid" type="text" name="footer_details[{{ $index }}][field_value]" value="{{ old("footer_details.$index.field_value", $footer['field_value']) }}" autocomplete="off" />
                                        @error("footer_details.$index.field_value")
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-4 text-center" style="padding-top: 1.5rem;">
                                    <button type="button" class="btn btn-sm btn-danger" onclick="removeFooterField(this)"><i class="bi bi-x"></i></button>
                                </div>
                            </div>
                            @endforeach
                        </div> --}}

                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label fw-bolder text-dark">Total in Words</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="total_in_word" value="Yes" {{ old('total_in_word', $invoice->total_in_word) == 'Yes' ? 'checked' : '' }}>
                                        <label class="form-check-label">Yes</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="total_in_word" value="No" {{ old('total_in_word', $invoice->total_in_word) == 'No' ? 'checked' : '' }}>
                                        <label class="form-check-label">No</label>
                                    </div>
                                    @if ($errors->has('total_in_word'))
                                    <span class="text-danger">{{ $errors->first('total_in_word') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label fw-bolder text-dark">Bank Details</label>
                                    <textarea class="form-control form-control-sm form-control-solid editor" name="bank_details" rows="3">{{ old('bank_details', $invoice->bank_details) }}</textarea>
                                    @if ($errors->has('bank_details'))
                                    <span class="text-danger">{{ $errors->first('bank_details') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label fw-bolder text-dark">Issued By</label>
                                    <textarea class="form-control form-control-sm form-control-solid editor" name="issued_by" rows="3">{{ old('issued_by', $invoice->issued_by) }}</textarea>
                                    @if ($errors->has('issued_by'))
                                    <span class="text-danger">{{ $errors->first('issued_by') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                       
                        <div class="card-footer d-flex justify-content-end py-6 px-9">
                            <a href="{{ route('invoice-custom-edit', $invoice->id) }}" class="btn btn-light me-2">Reset</a>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    let itemFieldIndex = {{ isset($invoice->field_details) ? count($invoice->field_details) : 0 }};
    let footerFieldIndex = 1;

    
    function addItemField() {
        const container = document.getElementById('item-field-group-container');
        const newItemFieldGroup = document.createElement('div');
        newItemFieldGroup.className = 'row mb-3 item-field-group';

        newItemFieldGroup.innerHTML = `
            <div class="col-md-4">
                <div class="fv-row">
                    <label class="form-label fw-bolder text-dark">Field Name</label>
                    <input class="form-control form-control-sm form-control-solid" type="text" name="field_details[${itemFieldIndex}][field_name]" autocomplete="off" />
                </div>
            </div>

             <div class="col-md-2">
                <div class="fv-row">
                    <label class="form-label fw-bolder text-dark">Sum</label>
                    <select class="form-control form-control-sm form-control-solid" name="field_details[${itemFieldIndex}][is_sum]">
                        <option value=''>Select</option>
                        <option value='1'>Yes</option>
                        <option value='0'>No</option>
                    </select>   
                </div>
            </div>

            <div class="col-md-2">
                <div class="fv-row">
                    <label class="form-label fw-bolder text-dark">Is Mandatory</label>
                    <select class="form-control form-control-sm form-control-solid" name="field_details[${itemFieldIndex}][is_mandatory]">
                        <option value=''>Select</option>
                        <option value='1'>Yes</option>
                        <option value='0'>No</option>
                    </select>   
                </div>
            </div>

            <div class="col-md-4 text-center" style="padding-top: 1.5rem;">
                <button type="button" class="btn btn-sm btn-danger" onclick="removeItemField(this)"><i class="bi bi-x"></i></button>
            </div>
        `;

        container.appendChild(newItemFieldGroup);
        itemFieldIndex++;
    }

   
    function removeItemField(button) {
        const fieldGroup = button.closest('.item-field-group');
        fieldGroup.remove();
    }

   
    function addFooterField() {
        const container = document.getElementById('footer-field-group-container');
        const newFooterFieldGroup = document.createElement('div');
        newFooterFieldGroup.className = 'row mb-3 footer-field-group';

        newFooterFieldGroup.innerHTML = `
            <div class="col-md-4">
                <div class="fv-row">
                    <label class="form-label fw-bolder text-dark">Field Name</label>
                    <input class="form-control form-control-sm form-control-solid" type="text" name="footer_details[${footerFieldIndex}][field_name]" autocomplete="off" />
                </div>
            </div>

            <div class="col-md-4 text-center" style="padding-top: 1.5rem;">
                <button type="button" class="btn btn-sm btn-danger" onclick="removeFooterField(this)"><i class="bi bi-x"></i></button>
            </div>
        `;

        container.appendChild(newFooterFieldGroup);
        footerFieldIndex++;
    }

   
    function removeFooterField(button) {
        const fieldGroup = button.closest('.footer-field-group');
        fieldGroup.remove();
    }
</script>


<script>
    function getTotalAmount(value) {
        let total = 0;

        const amountInputs = document.querySelectorAll('.custom-amount-input');

        amountInputs.forEach(input => {
            let value = parseFloat(input.value.replace(/,/g, '')) || 0;
            total += value;
        });

        const formattedTotal = total.toFixed(2);
        
        document.getElementById('custom-subtotal-amount').innerHTML = formattedTotal;
        document.getElementById('subtotal-hidden').value = formattedTotal;
        document.getElementById('total-hidden').value = formattedTotal;
        document.getElementById('custom-total-amount').innerHTML = formattedTotal;
        let vatInput = document.querySelector('[id="custom_vat"]');
        if (vatInput && vatInput.value) {
            calculateVat(vatInput.value);
        }
        let adjustmentInput = document.querySelector('[id="custom_adjustment"]');
        if (adjustmentInput && adjustmentInput.value) {
            calculateCustomAdjustment(adjustmentInput.value);
        }
    }
    function calculateVat(value)
    {
        value = parseFloat(value);
        if (isNaN(value)) {
            value = 0;
        }
        let subTotalAmount = document.getElementById('subtotal-hidden').value;
        let totalVat = (subTotalAmount * value) / 100;
        document.getElementById('totaltax-hidden').value = totalVat;
        let totalAmount = 0;
        totalAmount = parseFloat(subTotalAmount) + parseFloat(totalVat) + parseFloat(totalAmount); 
        document.getElementById('custom-total-vat').innerHTML = totalVat.toFixed(2);
        document.getElementById('total-hidden').value = totalAmount.toFixed(2);
        document.getElementById('custom-total-amount').innerHTML = totalAmount.toFixed(2);
    }
    function calculateCustomAdjustment(value) {
        // Validate the input value
        value = value === '' || isNaN(parseFloat(value)) ? 0 : parseFloat(value);

        // Fetch values and validate them
        let subTotalAmount = getValidNumber(document.getElementById('subtotal-hidden')?.value);
        let totalVat = getValidNumber(document.getElementById('totaltax-hidden')?.value);
        console.log('totalVat', totalVat)
        // Calculate the total amount
        let totalAmount = subTotalAmount + totalVat + value;


        // Safely update DOM elements if they exist
        let totalHidden = document.getElementById('total-hidden');
        let totalAmountDisplay = document.getElementById('custom-total-amount');
        let adjustmentDisplay = document.getElementById('custom-adjustment-amount');

        if (totalHidden) 
            totalHidden.value = totalAmount.toFixed(2);
        if (totalAmountDisplay) 
            totalAmountDisplay.innerHTML = totalAmount.toFixed(2);
        if (adjustmentDisplay) 
            adjustmentDisplay.innerHTML = totalAmount.toFixed(2);
    }

    function getValidNumber(value) {
        return value === '' || isNaN(parseFloat(value)) ? 0 : parseFloat(value);
    }

    document.addEventListener('DOMContentLoaded', function() {
        const customInvoiceSelect = document.getElementById('custom-invoice-select');
        const defaultInvoice = document.getElementById('default-invoice');
        const proposalTable = document.getElementById('custom-invoice-table'); // custom table id
        const customInvoiceHeader = document.getElementById('custom-invoice-header');
        const customInvoiceBody = document.getElementById('custom-invoice-body');

        const footerTable = document.getElementById('custom-invoice-footer-table'); 
        const customInvoiceFooterHeader = document.getElementById('custom-invoice-footer-header');
        const customInvoiceFooterBody = document.getElementById('custom-invoice-footer-body');
        const customInvoiceDiv = document.getElementById('custom-invoice');

        const customVat = document.getElementById('custom_vat');
        const customAdjustment = document.getElementById('custom_adjustment');


        window.sanitizeInput = function (inputElement) {
            inputElement.value = inputElement.value.replace(/,/g, '');
            getTotalAmount(inputElement.value);
        };

        customVat.addEventListener('input', function() {
            calculateVat(this.value);  
        });

        customAdjustment.addEventListener('input', function() {
            calculateCustomAdjustment(this.value);  
        });

        customInvoiceSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const fieldDetails = selectedOption.dataset.fields ? JSON.parse(selectedOption.dataset.fields) : null;
            // const footerDetails = selectedOption.dataset.fields ? JSON.parse(selectedOption.dataset.footer) : null;
            if (fieldDetails && fieldDetails.length > 0) {

                defaultInvoice.style.display = 'none';
                proposalTable.style.display = 'table';
                customInvoiceDiv.style.display = 'block';

                populateCustomInvoiceFields(fieldDetails);
            } else {
                customInvoiceDiv.style.display = 'none';
                defaultInvoice.style.display = 'block';
                proposalTable.style.display = 'none';
            }

            // if (footerDetails && footerDetails.length > 0) {
            //     footerTable.style.display = 'table';
            //     populateCustomInvoiceFooters(footerDetails);

            // }else {
            //     footerTable.style.display = 'none';

            // }

        });


        function populateCustomInvoiceFields(fields) {
            // headers in custom invoice table
            customInvoiceHeader.innerHTML = fields.map(field => `<th>${field.field_name}</th>`).join('') + '<th>Amount</th><th>Action</th>';


            customInvoiceBody.innerHTML = `
            <tr>
                ${fields.map(field => `<td><input type="text" class="form-control" name="items[${field.field_value}][]" placeholder="${field.field_name}" /></td>`).join('')}
                <td><input type="text" class="form-control custom-amount-input" name="items[amount][]" placeholder="Amount" oninput="sanitizeInput(this)"  onblur="getTotalAmount(this.value)"/></td>
                <td>
                    
                    <button type="button" class="btn btn-sm btn-primary py-2 px-3" id="add-row">
                                                            <i class="bi bi-plus-lg pe-0"></i>
                                                        </button>
                </td>
            </tr>
        `;

            //"add More" button and remove buttons
            addRemoveFunctionality();

            // Add event listener for the "Add More" button
            document.getElementById('add-row').addEventListener('click', function() {
                // insert new row
                customInvoiceBody.insertAdjacentHTML('beforeend', `
                <tr>
                    ${fields.map(field => `<td><input type="text" class="form-control" name="items[${field.field_value}][]" placeholder="${field.field_name}" /></td>`).join('')}
                    <td><input type="text" class="form-control custom-amount-input" name="items[amount][]" placeholder="Amount" oninput="sanitizeInput(this)"/></td>
                    <td><button type="button" class="btn btn-sm btn-danger py-2 px-3 remove-row">
                           <i class="bi bi-trash pe-0"></i>
                       </button>
                </tr>
            `);

                addRemoveFunctionality(); // reapply remove functionality to new row
            });
        }

        // function populateCustomInvoiceFooters(fields) {
        //     // headers in custom invoice table
        //     customInvoiceFooterHeader.innerHTML = fields.map(field => `<th>${field.field_name}</th>`).join('');


        //     customInvoiceFooterBody.innerHTML = `
        //     <tr>
        //         ${fields.map(field => `<td><input type="text" class="form-control" name="footer[${field.field_value}]" placeholder="${field.field_name}" /></td>`).join('')}
        //     </tr>
        // `;

        // }

        //remove row button
        function addRemoveFunctionality() {
            document.querySelectorAll('.remove-row').forEach(button => {
                button.addEventListener('click', function() {
                    this.closest('tr').remove();
                });
            });
        }

        // Trigger the change event on page load
        customInvoiceSelect.dispatchEvent(new Event('change'));
    });
</script>


<script>
    $(document).ready(function() {
        $('.editor').summernote({
            height: 0, // set the height to 200px
            toolbar: [
                // customize toolbar options as needed
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['height', ['height']]
            ]
        });
    });
</script>

<!-- End Forms-->


<!-- </div> -->
<!--end::Content-->


@endsection