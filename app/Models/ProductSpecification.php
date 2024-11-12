<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductSpecification extends Model
{
    use HasFactory;
    protected $table = 'product_specification';

    protected $fillable = [
        'product_id',
        'work_order_number',
        'work_order_value',
        'work_order_file',
        'work_order_rate',
        'purchase_order_value',
        'purchase_order_file',
        'amc_start_date',
        'amc_renewal_date',
        'amc_rate',
        'amc_effective_amount',
        'amc_agreement_documents',
        'service_type',
        'software_value',
        'hardware_value',
        'implementation_value',
        'invoice_mushak_file',
        'tax_exemption_certificate',
        'note',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
