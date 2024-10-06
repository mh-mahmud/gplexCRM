<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    // Table name if it's not following Laravel's naming convention
    protected $table = 'invoices';

    // The attributes that are mass assignable
    protected $fillable = [
        'customer_id',
        'invoice_number',
        'invoice_date',
        'due_date',
        'currency',
        'sub_total',
        'discount',
        'discount_type',
        'adjustment',
        'total_amount',
        'client_note',
        'item_description',
        'prevent_reminders',
        'is_recurring',
        'sale_agent_id',
    ];

    // Dates to handle date and soft delete functionality
    protected $dates = ['invoice_date', 'due_date', 'deleted_at'];

    /**
     * Get the customer that owns the invoice.
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Get the sale agent associated with the invoice.
     */
    public function saleAgent()
    {
        return $this->belongsTo(Agent::class, 'sale_agent_id');
    }

    
}