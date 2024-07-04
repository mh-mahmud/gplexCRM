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
            $sql->where('title','like', '%' . $data["search"] . '%');

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
            'name' => 'required|unique:sms_templates|max:100',
            'description' => 'required|max:191',
           
        ]);
        $data = $request->all();

        try {
            $dataObj                        = new Product();
            $dataObj->name                  = $data['name'];
            $dataObj->type                  = $data['type'];
            $dataObj->cost                  = $data['cost'];
            $dataObj->value                 = $data['value'];
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
           'name' => 'required|unique:sms_templates|max:100',
           'description' => 'required|max:191',
           
        ]);
        $data = $request->all();

        try {
            $dataObj                        = Product::findOrFail($id);
            $dataObj->name                  = $data['name'];
            $dataObj->type                  = $data['type'];
            $dataObj->cost                  = $data['cost'];
            $dataObj->value                 = $data['value'];
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

    public function productDelete($id)
    {
        $promotion = Product::findOrFail($id);
        $promotion->delete();
    }
}