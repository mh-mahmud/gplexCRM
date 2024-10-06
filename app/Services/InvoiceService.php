<?php

namespace App\Services;

use App\Models\Invoice;

class InvoiceService
{
    public function createInvoice($data)
    {
        $invoice = Invoice::create([
            'invoice_number' => $data['invoice_number'],
            'customer_id' => $data['customer_id'],
            'invoice_date' => $data['invoice_date'],
            'due_date' => $data['due_date'],
            'total_amount' => $data['total_amount'],
            'discount' => $data['discount'],
            'adjustment' => $data['adjustment'],
            'currency' => $data['currency'],
            'allowed_payment_modes' => $data['allowed_payment_modes'],
        ]);

        foreach ($data['items'] as $item) {
            InvoiceItem::create([
                'invoice_id' => $invoice->id,
                'description' => $item['description'],
                'quantity' => $item['quantity'],
                'rate' => $item['rate'],
                'tax' => $item['tax'],
                'amount' => $item['amount'],
            ]);
        }

        return $invoice;
    }

    public function updateInvoice($data, $id)
    {
        $invoice = Invoice::findOrFail($id);

        $invoice->update([
            'customer_id' => $data['customer_id'],
            'invoice_date' => $data['invoice_date'],
            'due_date' => $data['due_date'],
            'total_amount' => $data['total_amount'],
            'discount' => $data['discount'],
            'adjustment' => $data['adjustment'],
            'currency' => $data['currency'],
            'allowed_payment_modes' => $data['allowed_payment_modes'],
        ]);

        // Update items
        foreach ($data['items'] as $item) {
            if (isset($item['id'])) {
                InvoiceItem::find($item['id'])->update($item);
            } else {
                InvoiceItem::create([
                    'invoice_id' => $invoice->id,
                    'description' => $item['description'],
                    'quantity' => $item['quantity'],
                    'rate' => $item['rate'],
                    'tax' => $item['tax'],
                    'amount' => $item['amount'],
                ]);
            }
        }

        return $invoice;
    }
}