<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductSpecification;
use App\Services\ProductSpecificationService;
use Illuminate\Support\Facades\Validator;
use App\Models\Product;

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
        return view('product_specifications.index', compact('productSpecifications'));
    }

    public function create()
    {   
        $products = Product::all();
        return view('product_specifications.create', compact('products'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'work_order_number' => 'required|string|max:50',
            'work_order_value' => 'required|numeric',
            'amc_start_date' => 'nullable|date',
            'amc_renewal_date' => 'nullable|date',
            'work_order_file' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            // Add other validation rules as necessary
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $this->productSpecificationService->createProductSpecification($request);
        return redirect()->route('product_specifications.index')->with('success', 'Product Specification created successfully.');
    }

    public function show($id)
    {
        $productSpecification = $this->productSpecificationService->getProductSpecificationById($id);
        return view('product_specifications.show', compact('productSpecification'));
    }

    public function edit($id)
    {
        $productSpecification = $this->productSpecificationService->getProductSpecificationById($id);
        return view('product_specifications.edit', compact('productSpecification'));
    }


    public function search(Request $request)
    {

        $searchTerm = trim($request->input('search'));

        if (empty($searchTerm)) {
            return redirect()->route('agents-index')->with('error', 'Search Field cannot be blank.');
        }

        $request->validate([
            'search' => 'required|string',
        ]);
       
        $agents = $this->productSpecificationService->searchAgents($request);
        return view('agents.index', compact('agents'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'work_order_number' => 'required|string|max:50',
            'work_order_value' => 'required|numeric',
            'amc_start_date' => 'nullable|date',
            'amc_renewal_date' => 'nullable|date',
            'work_order_file' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            // Add other validation rules as necessary
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $this->productSpecificationService->updateProductSpecification($request, $id);
        return redirect()->route('product_specifications.index')->with('success', 'Product Specification updated successfully.');
    }

    public function destroy($id)
    {
        try {
            $this->productSpecificationService->deleteProductSpecification($id);
            return redirect()->route('product-specification-index')->with('success', 'Product Specification deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }



}
