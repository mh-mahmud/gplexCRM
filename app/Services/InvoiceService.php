<?php

namespace App\Services;

use App\Models\Invoice;

class InvoiceService
{


    public function getAllInvoices()
    {
        return Invoice::orderBy('created_at', 'desc')->paginate(config('constants.ROW_PER_PAGE'));
    }


    public function createInvoice($data)
    {
        //prepare items array by iterating
        //dd($data);die();
        $items = [];
        $itemCount = count($data['items']['item_name']); //assuming all arrays have the same length

        for ($i = 0; $i < $itemCount; $i++) {
            $items[] = [
                'Item' => $data['items']['item_name'][$i] ?? '',
                'Description' => $data['items']['description'][$i] ?? '',
                'Qty' => $data['items']['quantity'][$i] ?? 0,         
                'Rate' => $data['items']['rate'][$i] ?? 0,            
                'Tax' => $data['items']['tax'][$i] ?? 0,
                'Amount' => ($data['items']['quantity'][$i] ?? 0) * ($data['items']['rate'][$i] ?? 0) // Calculate Amount (Qty * Rate)
            ];
        }
        //encode the items array as JSON
        $itemDescriptionJson = json_encode($items);
        //create the invoice
        $invoice = Invoice::create([
            'invoice_number' =>  'INV-' . $data['invoice_number'],
            'customer_id' => $data['customer_id'],
            'address' => $data['address'],
            'invoice_date' => $data['invoice_date'],
            'due_date' => $data['due_date'],
            'total_amount' => $data['total_amount'],
            'total_tax' => $data['total_tax'],
            'sub_total' => $data['sub_total'],
            'discount' => $data['discount'],
            'discount_type' => $data['discount_type_name'],
            'admin_note' => $data['admin_note'],
            'client_note' => $data['client_note'],
            'terms_conditions' => $data['terms_conditions'],
            'adjustment' => $data['adjustment'],
            'currency' => $data['currency'],
            'payment_mode' => $data['payment_mode'],
            'sale_agent_id' => $data['sale_agent_id'],
            'invoice_status' => $data['invoice_status'],
            'item_description' => $itemDescriptionJson,
        ]);

        return $invoice;
    }



    public function updateInvoice(array $data, $id)
    {
        $invoice = Invoice::findOrFail($id);

        // Update the invoice fields
        $invoice->invoice_number = 'INV-' .$data['invoice_number'];
        $invoice->sub_total = $data['sub_total'];
        $invoice->total_amount = $data['total_amount'];
        $invoice->total_tax = $data['total_tax'];
        $invoice->discount = $data['discount'] ?? null;
        $invoice->discount_type = $data['discount_type_name'] ?? null;
        $invoice->adjustment = $data['adjustment'] ?? null;

        // Prepare items data to be saved as JSON
        $items = [];
        foreach ($data['items']['item_name'] as $key => $itemName) {
            $items[] = [
                'Item' => $itemName,
                'Description' => $data['items']['description'][$key],
                'Qty' => $data['items']['quantity'][$key],
                'Rate' => $data['items']['rate'][$key],
                'Tax' => $data['items']['tax'][$key],
                'Amount' => ($data['items']['quantity'][$key] ?? 0) * ($data['items']['rate'][$key] ?? 0)
            ];
        }

        // Convert items array to JSON
        $invoice->item_description = json_encode($items);

        // Save the updated invoice
        $invoice->save();
    }

    public function searchInvoices($request)
    {
        $searchTerm = trim($request->input('search'));

        return Invoice::where('invoice_number', 'LIKE', "%{$searchTerm}%")
            ->orWhere('invoice_date', 'LIKE', "%{$searchTerm}%")
            ->orWhere('due_date', 'LIKE', "%{$searchTerm}%")
            ->orderBy('created_at', 'desc')
            ->paginate(config('constants.ROW_PER_PAGE'));
    }
}