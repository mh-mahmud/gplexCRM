<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CustomerService;
use Auth;

class CustomerController extends Controller
{
    protected $service;
    public function __construct(CustomerService $customer_service) {
        $this->middleware('auth');
        $this->service = $customer_service;
    }

    public function index() {
        return 'hi';
    }

    public function add_customer() {
        $data = [];
        $data['rand_str'] = $this->generateRandomString();
        return view('customers.add_customer', $data);
    }

    public function save_customer() {

    }

    function generateRandomString($length = 5) {
        // Define the characters to use in the string
        $characters = '0123456789ABCDEFGHIJKLMN';
        $charactersLength = strlen($characters);
        $randomString = '';

        // Generate a random string of the specified length
        for ($i = 0; $i < $length; $i++) {
            $randomIndex = random_int(0, $charactersLength - 1);
            $randomString .= $characters[$randomIndex];
        }

        return $randomString;
    }
}
