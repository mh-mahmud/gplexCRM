<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ProductService;

class ProductController extends Controller {

    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
        $this->middleware('auth');
    }

    public function productList(Request $request)
    {      
        $products = $this->productService->productList($request);
        return view('products.product-list', compact('products'));
    }

    public function productCreate()
    {       
        return view('emails.template-create');
    }

    public function productStore(Request $request)
    { 
        $result = $this->productService->productStore($request);
        if($result->status == 201){
            return redirect()->route('email-template')->with('success', 'Email template created successfully.');

        }else{
            session()->flash('error', 'Can not Create !');
        }

    }

}