<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductSpecification;
use App\Services\ProductSpecificationService;
use Illuminate\Support\Facades\Validator;
use App\Models\Product;
use App\Models\Customer;
use App\Helpers\Helper;
use Illuminate\Support\Facades\DB;
use App\Models\Invoice;

class ProductSpecificationController extends Controller
{
    protected $productSpecificationService;

    public function __construct(ProductSpecificationService $productSpecificationService)
    {
        $this->productSpecificationService = $productSpecificationService;
    }

    public function index()
    { 
        $productSpecifications = $this->productSpecificationService->getAllProductSpecifications();
        $invoicesGroupedByPsId = Invoice::join('customers', 'invoices.customer_id', '=', 'customers.id')
        ->join('leads', 'customers.lead_id', '=', 'leads.id')
        ->select(
            'invoices.*',
            'customers.customer_group',
            'leads.first_name',
            'leads.last_name'
        )
        ->orderBy('invoices.created_at', 'desc')
        ->get()
        ->groupBy('ps_id');
        return view('product_specifications.index', compact('productSpecifications','invoicesGroupedByPsId'));
    }

    public function create()
    {   
        //$products = Product::all();
        $products = Product::where('status', 1)->get();
        $customers = Customer::join('leads', 'customers.lead_id', '=', 'leads.id')
        ->select('customers.*', 'leads.first_name', 'leads.last_name')
        ->get();
        return view('product_specifications.create', compact('products','customers'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customer_id' => 'required|exists:customers,id',
            //'product_id' => 'required|integer',
            'work_order_number' => 'required|string|max:50',
            'work_order_value' => 'required|numeric',
            'amc_start_date' => 'nullable|date',
            'amc_renewal_date' => 'nullable|date',
            'work_order_file' => 'nullable|file|max:10048',
            'purchase_order_file' => 'nullable|file|max:10048',
            'amc_agreement_documents' => 'nullable|file|max:10048',
            'invoice_mushak_file' => 'nullable|file|max:10048',
            'tax_exemption_certificate' => 'nullable|file|max:10048',
            // Add other validation rules as necessary

            'payment_date_cycle' => 'nullable|date',
            'advance_amount' => 'required|numeric',
            'total_installment' => 'required|numeric',
            'per_month_installment' => 'nullable|numeric',
            'remaining_month' => 'nullable|numeric',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $customer = Customer::find($request->customer_id);
        $lead_id = $customer->lead_id;

        $this->productSpecificationService->createProductSpecification($request);
        Helper::storeLog("Product Specification created successfully", "Product Specification", "Create Product Specification", null, $lead_id);
        return redirect()->route('product-specification-index')->with('success', 'Product Specification created successfully.');
    }

    public function show($id)
    {
        $productSpecification = $this->productSpecificationService->getProductSpecificationById($id);
        return view('product_specifications.show', compact('productSpecification'));
    }

    public function edit($id)
    {   
        //$products = Product::all();
        $products = Product::where('status', 1)->get();
        $customers = Customer::join('leads', 'customers.lead_id', '=', 'leads.id')
        ->select('customers.*', 'leads.first_name', 'leads.last_name')
        ->get();
        $productSpecification = $this->productSpecificationService->getProductSpecificationById($id);
        return view('product_specifications.edit', compact('productSpecification','products','customers'));
    }


    public function search(Request $request)
    {

        $searchTerm = trim($request->input('search'));

        if (empty($searchTerm)) {
            return redirect()->route('product-specification-index')->with('error', 'Search Field cannot be blank.');
        }

        $request->validate([
            'search' => 'required|string',
        ]);
       
        $productSpecifications = $this->productSpecificationService->searchProductSpecification($request);
        return view('product_specifications.index', compact('productSpecifications'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'customer_id' => 'required|exists:customers,id',
            //'product_id' => 'required|integer',
            'work_order_number' => 'required|string|max:50',
            'work_order_value' => 'required|numeric',
            'amc_start_date' => 'nullable|date',
            'amc_renewal_date' => 'nullable|date',
            'work_order_file' => 'nullable|file|max:10048',
            'purchase_order_file' => 'nullable|file|max:10048',
            'amc_agreement_documents' => 'nullable|file|max:10048',
            'invoice_mushak_file' => 'nullable|file|max:10048',
            'tax_exemption_certificate' => 'nullable|file|max:10048',
            // Add other validation rules as necessary
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $customer = Customer::find($request->customer_id);
        $lead_id = $customer->lead_id;

        $this->productSpecificationService->updateProductSpecification($request, $id);
        Helper::storeLog("Product Specification updated successfully", "Product Specification", "Edit Product Specification", null,$lead_id);
        return redirect()->route('product-specification-index')->with('success', 'Product Specification updated successfully.');
    }

    public function destroy($id)
    {
        try {
            $productSpecification =ProductSpecification::findOrFail($id);
            $customer_id = $productSpecification->customer_id;
            $customer =Customer::find($customer_id);
            $lead_id = $customer ? $customer->lead_id : null; 
            $this->productSpecificationService->deleteProductSpecification($id);
            Helper::storeLog("Product Specification deleted successfully", "Product Specification", "Delete Product Specification", null, $lead_id);
            return redirect()->route('product-specification-index')->with('success', 'Product Specification deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }


    public function updateSpecificationFile(Request $request, $id)
    {
        $specification = ProductSpecification::findOrFail($id);
        $fileType = $request->input('type');
    
        // file type to the database field
        $fileFields = [
            'work_order_file' => 'work_order_file',
            'purchase_order_file' => 'purchase_order_file',
            'amc_agreement_documents' => 'amc_agreement_documents',
            'invoice_mushak_file' => 'invoice_mushak_file',
            'tax_exemption_certificate' => 'tax_exemption_certificate',
        ];
    
       
        if (isset($fileFields[$fileType]) && $specification->{$fileFields[$fileType]}) {
            $filePath = public_path('uploads/product_specification/' . $specification->{$fileFields[$fileType]});
            if (file_exists($filePath)) {
                unlink($filePath); 
            }
    
            //update the database to remove the file reference
            $specification->{$fileFields[$fileType]} = null;
            $specification->save();
    
            return response()->json(['success' => true]);
        }
    
        return response()->json(['success' => false, 'message' => 'No file found']);
    }
    




}
