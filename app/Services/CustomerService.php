<?php

namespace App\Services;
use App\Models\Customer;
use App\Models\Lead;
use Exception;
use Illuminate\Support\Facades\Auth;

class CustomerService
{
    public function get_customer_data($id) {

        try {
            return Lead::findOrFail($id);
        }
        catch(Exception $e) {
            return $e->getMessage();
        }
    }

    public function createCustomer($request) {

        $data = new Customer();
        $data->lead_id = $request->lead_id;
        $data->customer_id = $request->customer_id;
        $data->customer_group = $request->customer_group;
        $data->customer_notes = $request->customer_notes;
        if($data->save()) {
            return true;
        }
        return false;
    }
}