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
        return view('products.create');
    }

    public function productStore(Request $request)
    { 
        $result = $this->productService->productStore($request);
        if($result->status == 201){
            return redirect()->route('product-list')->with('success', 'Product added successfully.');

        }else{
            session()->flash('error', 'Can not Add!');
        }

    }

    public function productShow($id)
    {
        $product = $this->productService->getProductById($id);
        return view('products.product-show', compact('product'));
    }

    public function productEdit($id)
    {
        $product = $this->productService->getProductById($id);
        return view('products.edit', compact('product'));
    }

    public function productUpdate(Request $request, $id)
    { 
        $result = $this->productService->productUpdate($request, $id);
        if($result->status == 208){
            return redirect()->route('product-list')->with('success', 'Product updated successfully.');

        }else{
            session()->flash('error', 'Can not Update!');
        }

    }


    public function productDelete($id)
    {
        $result = $this->productService->productDelete($id);
        if($result->status == 200){
            return redirect()->route('product-list')->with('success', 'Product deleted successfully.');

        }else{
            session()->flash('error', 'Can not Delete !');
        }
    }

}