<?php

namespace App\Services;

use App\Models\Invoice;
use App\Models\InvoiceCustomForm;

class InvoiceCustomFormService
{
    public function createInvoiceCustomForm(array $data)
    {   //store json
        return InvoiceCustomForm::create([
            'invoice_name' => $data['invoice_name'],
            'field_details' => $data['field_details'], // direct array insertion
            'footer_details' => $data['footer_details'],
            'total_in_word' => $data['total_in_word'] ?? null,
            'bank_details' => $data['bank_details'] ?? null,
            'issued_by' => $data['issued_by'] ?? null,
        ]);
    }

}
