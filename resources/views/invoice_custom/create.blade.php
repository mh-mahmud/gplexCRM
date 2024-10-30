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

                            <div class="row mb-3 field-group">
                                <div class="col-md-4">
                                    <div class="fv-row">
                                        <label class="form-label fw-bolder text-dark">Field Name</label>
                                        <input class="form-control form-control-sm form-control-solid" type="text" name="fields[{{ $index }}][name]" value="{{ $field['name'] }}" autocomplete="off" />
                                        @if ($errors->has("fields.$index.name"))
                                        <span class="text-danger">{{ $errors->first("fields.$index.name") }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="fv-row">
                                        <label class="form-label fw-bolder text-dark">Field Value</label>
                                        <select class="form-control form-control-sm form-control-solid" name="fields[{{ $index }}][type]" aria-label="Default select example" required>
                                            <option value="">Select Field Value</option>
                                            <option value="varchar" @if($field['type']=='varchar' ) selected @endif>String</option>
                                            <option value="char" @if($field['type']=='char' ) selected @endif>Character</option>
                                            <option value="int" @if($field['type']=='int' ) selected @endif>Integer</option>
                                            <option value="date" @if($field['type']=='date' ) selected @endif>Date</option>
                                            <option value="text" @if($field['type']=='text' ) selected @endif>Text</option>
                                            <option value="boolean" @if($field['type']=='boolean' ) selected @endif>Boolean</option>
                                            <option value="file" @if($field['type']=='file' ) selected @endif>File</option>
                                            <option value="dropdown" @if($field['type']=='dropdown' ) selected @endif>Dropdown</option>
                                        </select>
                                        @if ($errors->has("fields.$index.type"))
                                        <span class="text-danger">{{ $errors->first("fields.$index.type") }}</span>
                                        @endif
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
                       <button type="button" class="btn btn-sm btn-danger py-2 px-3 remove-row">
                           <i class="bi bi-trash pe-0"></i>
                       </button>
                   </td>
               </tr>`;

                //append the new row to the table body
                $('#table-body').append(newRow);
                // clear the product selection
                $('#product-select').val('').trigger('change');
            } else {
                //alert user if any field in the last row is not filled
                alert('Please fill all fields in the last row before adding a new one.');
            }
        });


        $(document).on('click', '.add-row-backup', function() {
            //alert('asdsd');
            var lastRow = $('#table-body tr:last'); // reference to the last row
            // clear any previous error messages and highlights
            lastRow.find('.error-message').remove(); // remove any existing error messages
            lastRow.find('textarea, input').removeClass('is-invalid'); // remove error highlight
            //get the values from the last row
            var itemName = lastRow.find('textarea[name="items[item_name][]"]').val();
            var description = lastRow.find('textarea[name="items[description][]"]').val();
            var quantity = lastRow.find('input[name="items[quantity][]"]').val();
            var rate = lastRow.find('input[name="items[rate][]"]').val();

            var isValid = true;

            //validate Item Name,Description,Quantity,Rate
            if (itemName == "") {
                alert('asdsd');
                lastRow.find('textarea[name="items[item_name][]"]').addClass('is-invalid'); // highlight field
                lastRow.find('textarea[name="items[item_name][]"]').after('<div class="error-message text-danger">Item Name is required</div>'); // add error message
                isValid = false;
            }


            if (description === "") {
                lastRow.find('textarea[name="items[description][]"]').addClass('is-invalid');
                lastRow.find('textarea[name="items[description][]"]').after('<div class="error-message text-danger">Description is required</div>');
                isValid = false;
            }


            if (quantity === "" || quantity <= 0) {
                lastRow.find('input[name="items[quantity][]"]').addClass('is-invalid');
                lastRow.find('input[name="items[quantity][]"]').after('<div class="error-message text-danger">Quantity must be greater than 0</div>');
                isValid = false;
            }


            if (rate === "" || rate <= 0) {
                lastRow.find('input[name="items[rate][]"]').addClass('is-invalid');
                lastRow.find('input[name="items[rate][]"]').after('<div class="error-message text-danger">Rate must be greater than 0</div>');
                isValid = false;
            }

            //all fields are valid, add a new row
            if (isValid) {
                var newRow = `<tr>
            <td>
                <textarea class="form-control form-control-sm min-w-250px" name="items[item_name][]" cols="30" rows="2"
                    placeholder="Item Name"></textarea>
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

                //clear the product selection if there is any dropdown or selection mechanism
                $('#product-select').val('').trigger('change');
            }
        });


        //remove row logic
        $(document).on('click', '.remove-row', function() {
            $(this).closest('tr').remove();
            updateTotal(); // recalculate total after row removal
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