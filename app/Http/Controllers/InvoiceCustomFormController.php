<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\InvoiceCustomFormService;
use App\Models\InvoiceCustomForm;

class InvoiceCustomFormController extends Controller
{
    protected $invoiceCustomFormService;

    public function __construct(InvoiceCustomFormService $invoiceCustomFormService)
    {
        $this->invoiceCustomFormService = $invoiceCustomFormService;
    }
    public function create()
    {
        return view('invoice_custom.create');
    }

    public function store(Request $request)
    {   
        $data = $request->validate([
            'invoice_name' => 'required|string|max:255',
            'field_details' => 'array',
            'field_details.*.field_name' => 'required|string',
            'field_details.*.field_value' => 'required|string',
            'footer_details' => 'array',
            'footer_details.*.field_name' => 'required|string',
            'footer_details.*.field_value' => 'required|string',
            'total_in_word' => 'nullable|string|max:255',
            'bank_details' => 'nullable|string',
            'issued_by' => 'nullable|string',
        ], [
            //custom error messages
            'field_details.*.field_name.required' => 'Each Item Field Name is required.',
            'field_details.*.field_value.required' => 'Each Item Field Value is required.',
            'footer_details.*.field_name.required' => 'Each Footer Field Name is required.',
            'footer_details.*.field_value.required' => 'Each Footer Field Value is required.',
            'invoice_name.required' => 'The Invoice Name is required.',
            'total_in_word.max' => 'The Total in Words field should not exceed 255 characters.',
        ]);
        $this->invoiceCustomFormService->createInvoiceCustomForm($data);

        return redirect()->route('invoice-custom-index')->with('success', 'Invoice Form created successfully.');
    }
    

    public function show(InvoiceCustomForm $invoiceCustomForm)
    {
        return view('invoice_custom_form.show', compact('invoiceCustomForm'));
    }
}
