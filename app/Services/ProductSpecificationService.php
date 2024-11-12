<?php

namespace App\Services;

use App\Models\ProductSpecification;
use Illuminate\Support\Facades\Storage;

class ProductSpecificationService
{
    public function getAllProductSpecifications()
    {
        return ProductSpecification::orderBy('created_at', 'desc')->paginate(config('constants.ROW_PER_PAGE'));
    }

    public function getProductSpecificationById($id)
    {
        return ProductSpecification::findOrFail($id);
    }

    public function createProductSpecification($data)
    {
        $specificationData = $data->except([
            'work_order_file',
            'purchase_order_file',
            'amc_agreement_documents',
            'invoice_mushak_file',
            'tax_exemption_certificate'
        ]);

        //handle file uploads each specified field
        $fileFields = [
            'work_order_file',
            'purchase_order_file',
            'amc_agreement_documents',
            'invoice_mushak_file',
            'tax_exemption_certificate'
        ];

        foreach ($fileFields as $field) {
            if ($data->hasFile($field)) {
                $file = $data->file($field);
                $fileName = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('uploads/product_specification'), $fileName);
                $specificationData[$field] = $fileName;
            }
        }

        return ProductSpecification::create($specificationData);
    }


    public function updateProductSpecification($data, $id)
    {
        $productSpecification = ProductSpecification::findOrFail($id);
        $specificationData = $data->except(['work_order_file']);

        // Handle file update if a new file is provided
        if ($data->hasFile('work_order_file')) {
            // Delete old file if exists
            if ($productSpecification->work_order_file && file_exists(public_path('uploads/product_specification/' . $productSpecification->work_order_file))) {
                unlink(public_path('uploads/product_specification/' . $productSpecification->work_order_file));
            }
            
            // Upload new file
            $file = $data->file('work_order_file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/product_specification'), $fileName);
            $specificationData['work_order_file'] = $fileName;
        }

        return $productSpecification->update($specificationData);
    }


    public function searchroductSpecification($request)
    {
        $searchTerm = trim($request->input('search'));
        $query = ProductSpecification::query();

        $query->where(function($q) use ($searchTerm) {
            $q->where('work_order_number', 'LIKE', '%' . $searchTerm . '%')
              ->orWhere('work_order_value', 'LIKE', '%' . $searchTerm . '%')
              ->orWhere('amc_start_date', 'LIKE', '%' . $searchTerm . '%');
        });

        return $query->paginate(config('constants.ROW_PER_PAGE'));
    }

    public function deleteProductSpecification($id)
    {
        $productSpecification = ProductSpecification::findOrFail($id);

        // Delete file if exists
        if ($productSpecification->work_order_file ) {
            //$existingFilePath = public_path('uploads/meetings/'.$meeting->attachments);
            $existingFilePath = getcwd() . '/uploads/product_specification/' . $productSpecification->work_order_file;
            if (file_exists($existingFilePath)) {
                unlink($existingFilePath);
            }
        }

        $productSpecification->delete();
    }
    
}
