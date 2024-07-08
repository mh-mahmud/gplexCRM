<?php

namespace App\Services;
use App\Models\Product;
use Exception;
use Illuminate\Support\Facades\Auth;

class ProductService
{
    public function productList($request)
    {
        $sql = Product::query();
        $data = $request->all();
        if(!empty($data["search"])) {
            $sql->where('name','like', '%' . $data["search"] . '%');

        }
        if (isset($data['paginate']) && $data['paginate'] == false) {
            return  $sql->orderBy('id', 'DESC')->get();

        } else {
            return  $sql->orderBy('id', 'DESC')->paginate(config('constants.ROW_PER_PAGE'));

        }
    }

    public function productStore($request)
    {
        $request->validate([
            'name'          => 'required|unique:products|max:191',
            'product_code'  => 'required|max:20',
            'product_type'  => 'required',
        ]);
        $data = $request->all();

        try {
            $dataObj                        = new Product();
            $dataObj->name                  = $data['name'];
            $dataObj->product_type          = $data['product_type'];
            $dataObj->product_cost          = $data['product_cost'];
            $dataObj->product_value         = $data['product_value'];
            $dataObj->product_code          = $data['product_code'];
            $dataObj->description           = $data['description'];
            $dataObj->status                = $data['status'];

            $dataObj->save();

        } catch (Exception $e) {
            return (object)[
                'status'             => 424,
                'error'              => $e->getMessage()
            ];
        }

        return (object)[
            'status'                 => 201,
            'info'                   => $dataObj->id
        ];

    }

    public function productUpdate($request, $id)
    {
        $request->validate([
            'name'         => 'required|max:191|unique:products,name,'.$id,
            'product_code'  => 'required|max:20',
            'product_type'  => 'required',
        ]);
        $data = $request->all();

        try {
            $dataObj                        = Product::findOrFail($id);;
            $dataObj->name                  = $data['name'];
            $dataObj->product_type          = $data['product_type'];
            $dataObj->product_cost          = $data['product_cost'];
            $dataObj->product_value         = $data['product_value'];
            $dataObj->product_code          = $data['product_code'];
            $dataObj->description           = $data['description'];
            $dataObj->status                = $data['status'];

            $dataObj->save();

        } catch (Exception $e) {
            return (object)[
                'status'             => 424,
                'error'              => $e->getMessage()
            ];
        }

        return (object)[
            'status'                 => 208,
            'info'                   => $dataObj->id
        ];

    }

    public function getProductById($id)
    {
        return Product::findOrFail($id);
    }

    public function productDelete($id)
    {
        try {
            $data = Product::findOrFail($id);
            $data->delete();
        } catch (Exception $e) {
            return (object)[
                'status'             => 424,
                'error'              => $e->getMessage()
            ];
        }

        return (object)[
            'status'                 => 200,
        ];
    }
}