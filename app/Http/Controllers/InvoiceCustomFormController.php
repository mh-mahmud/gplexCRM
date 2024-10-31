<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InvoiceCustomForm;

class InvoiceCustomFormController extends Controller
{
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
        ]);

        // Store as JSON data
        InvoiceCustomForm::create([
            'invoice_name' => $data['invoice_name'],
            'field_details' => $data['field_details'],
            'footer_details' => $data['footer_details'],
            'total_in_word' => $data['total_in_word'],
            'bank_details' => $data['bank_details'],
            'issued_by' => $data['issued_by'],
        ]);

        return redirect()->route('invoice_custom_form.index')->with('success', 'Invoice created successfully.');
    }

    public function show(InvoiceCustomForm $invoiceCustomForm)
    {
        return view('invoice_custom_form.show', compact('invoiceCustomForm'));
    }
}
