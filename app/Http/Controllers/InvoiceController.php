<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Invoice;
use App\Services\InvoiceService;
use App\Services\CountryService;
use App\Services\CurrencyService;
use PHPUnit\TextUI\Help;
use App\Helpers\Helper;
use App\Models\Agent;
use App\Models\Product;

class InvoiceController extends Controller
{
    protected $invoiceService;
    protected $countryService;
    protected $currencyService;

    public function __construct(InvoiceService $invoiceService, CountryService $countryService, CurrencyService $currencyService)
    {
        $this->invoiceService = $invoiceService;
        $this->countryService  = $countryService;
        $this->currencyService  = $currencyService;
    }

    public function index()
    {
        $invoices = Invoice::all();
        return view('invoices.index', compact('invoices'));
    }

    public function create(Request $request)
    {
        $customers = Customer::all();
        $countries = $this->countryService->countryList($request);
        $currencies = $this->currencyService->currencyList($request);
        $lastInvoice = Invoice::latest()->first();
        $nextInvoiceNumber = $lastInvoice ? $lastInvoice->id + 1 : 1;
        $discountTypes = Helper::getEnumValues('invoices', 'discount_type');
        $agents = Agent::select('agent_id', 'first_name', 'last_name')->get();
        $products = Product::select('id', 'name','description','product_value')->get();
        return view('invoices.create', compact('customers','countries','currencies','nextInvoiceNumber','discountTypes','agents','products'));
    }

    public function store(Request $request)
    {
        $invoice = $this->invoiceService->createInvoice($request->all());
        return redirect()->route('invoices.index')->with('success', 'Invoice Created Successfully!');
    }

    public function show($id)
    {
        $invoice = Invoice::findOrFail($id);
        return view('invoices.show', compact('invoice'));
    }

    public function edit($id)
    {
        $invoice = Invoice::findOrFail($id);
        $customers = Customer::all();
        return view('invoices.edit', compact('invoice', 'customers'));
    }

    public function update(Request $request, $id)
    {
        $this->invoiceService->updateInvoice($request->all(), $id);
        return redirect()->route('invoices.index')->with('success', 'Invoice Updated Successfully!');
    }

    public function destroy($id)
    {
        Invoice::destroy($id);
        return redirect()->route('invoices.index')->with('success', 'Invoice Deleted Successfully!');
    }
}
