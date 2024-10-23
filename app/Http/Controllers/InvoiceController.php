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
use PDF;

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
        //$invoices = Invoice::all();
        $invoices = $this->invoiceService->getAllInvoices();
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
        $products = Product::select('id', 'name', 'description', 'product_value')->get();
        return view('invoices.create', compact('customers', 'countries', 'currencies', 'nextInvoiceNumber', 'discountTypes', 'agents', 'products'));
    }

    public function store_backup(Request $request)
    {
        // Validate the request data with custom error messages
        $validatedData = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'invoice_number' => 'required|unique:invoices,invoice_number',
            'invoice_date' => 'required|date',
            'due_date' => 'nullable|date|after_or_equal:invoice_date',
            'product_id' => 'required|exists:products,id',
        ], [
            'product_id.required' => 'Product item is required', // Custom error message
        ]);

        // Create the invoice using the validated data
        $invoice = $this->invoiceService->createInvoice($request->all());

        // Redirect to the invoice index with a success message
        return redirect()->route('invoice-index')->with('success', 'Invoice Created Successfully!');
    }

    public function store(Request $request)
{
    // Validate the request data with custom error messages for each item field
    $validatedData = $request->validate([
        'customer_id' => 'required|exists:customers,id',
        'invoice_number' => 'required|unique:invoices,invoice_number',
        'invoice_date' => 'required|date',
        'due_date' => 'nullable|date|after_or_equal:invoice_date',
        
        // Item validation
        'items.item_name.*' => 'required|string',  // Validate each item name
        'items.description.*' => 'required|string',  // Validate each description
        'items.quantity.*' => 'required|integer|min:1',  // Validate each quantity
        'items.rate.*' => 'required|numeric|min:0',  // Validate each rate
        'items.tax.*' => 'nullable|numeric|min:0|max:100',  // Validate each tax percentage
    ], [
        // Custom error messages for each item
        'items.item_name.*.required' => 'Item Name is required for all items',
        'items.description.*.required' => 'Description is required for all items',
        'items.quantity.*.required' => 'Quantity is required and must be at least 1',
        'items.rate.*.required' => 'Rate is required and must be a positive number',
        'items.tax.*.numeric' => 'Tax must be a valid percentage',
        'items.tax.*.max' => 'Tax cannot exceed 100%',
    ]);

    // Create the invoice using the validated data
    $invoice = $this->invoiceService->createInvoice($request->all());

    // Redirect to the invoice index with a success message
    return redirect()->route('invoice-index')->with('success', 'Invoice Created Successfully!');
}


    public function show($id)
    {
        $invoice = Invoice::findOrFail($id);
        $invoiceItems = json_decode($invoice->item_description, true);
        $products = Product::select('id', 'name', 'description', 'product_value')->get();
        return view('invoices.show', compact('invoice', 'products', 'invoiceItems'));
    }

    public function edit($id, Request $request)
    {
        $invoice = Invoice::findOrFail($id);
        $invoiceItems = json_decode($invoice->item_description, true);
        //dd($items);die();
        $customers = Customer::all();
        $countries = $this->countryService->countryList($request);
        $currencies = $this->currencyService->currencyList($request);
        $discountTypes = Helper::getEnumValues('invoices', 'discount_type');
        $agents = Agent::select('agent_id', 'first_name', 'last_name')->get();
        $products = Product::select('id', 'name', 'description', 'product_value')->get();
        return view('invoices.edit', compact('invoice', 'customers', 'countries', 'currencies', 'discountTypes', 'agents', 'products', 'invoiceItems'));
    }


    public function update(Request $request, $id)
    {

        $validatedData = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'invoice_number' => 'required|unique:invoices,invoice_number,' . $id, //current invoice number
            'invoice_date' => 'required|date',
            'due_date' => 'nullable|date|after_or_equal:invoice_date',
        ]);

        $invoice = $this->invoiceService->updateInvoice($request->all(), $id);
        return redirect()->route('invoice-index')->with('success', 'Invoice Updated Successfully!');
    }

    public function destroy($id)
    {
        Invoice::destroy($id);
        return redirect()->route('invoice-index')->with('success', 'Invoice Deleted Successfully!');
    }

    // searech for invoice
    public function search(Request $request)
    {
        $searchTerm = trim($request->input('search'));

        if (empty($searchTerm)) {
            return redirect()->route('invoice-index')->with('error', 'Search field cannot be blank.');
        }

        $invoices = $this->invoiceService->searchInvoices($request);
        return view('invoices.index', compact('invoices'));
    }

    public function downloadInvoice($invoiceId)
    {
        // Fetch your invoice data and related items
        $invoice = Invoice::findOrFail($invoiceId);
        $invoiceItems = json_decode($invoice->item_description, true);
        // Generate the PDF from the view
        $pdf = PDF::loadView('invoices.invoice_pdf', compact('invoice', 'invoiceItems'));

        // Download the PDF
        return $pdf->download('invoice_' . $invoice->invoice_number . '.pdf');
    }
}
