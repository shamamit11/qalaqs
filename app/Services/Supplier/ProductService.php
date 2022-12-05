<?php
namespace App\Services\Supplier;

use App\Models\Product;
use App\Models\ProductEngine;
use App\Models\ProductImage;
use App\Models\ProductMatch;
use App\Models\ProductSpecification;
use App\Traits\StoreImageTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductService
{
    use StoreImageTrait;

    function list($per_page, $page, $q) {
        try {
            $supplier_id = Auth::guard('supplier')->id();
            $data['q'] = $q;
            $query = Product::select('*')->with('specifications')->with('images')->with('matches')->with('make')->with('model')->with('year')->where('supplier_id', $supplier_id);
            if ($q) {
                $search_key = $q;
                $query->where(function ($qry) use ($search_key) {
                    $qry->where('name', 'LIKE', '%' . $search_key . '%');
                    $qry->orWhereHas('make', function ($qry1) use ($search_key) {
                        $qry1->where('name', 'LIKE', '%' . $search_key . '%');
                    });
                    $qry->orWhereHas('model', function ($qry2) use ($search_key) {
                        $qry2->where('name', 'LIKE', '%' . $search_key . '%');
                    });
                    $qry->orWhereHas('year', function ($qry3) use ($search_key) {
                        $qry3->where('name', 'LIKE', '%' . $search_key . '%');
                    });
                });
            }
            $data['products'] = $query->orderBy('product_make_id', 'asc')->orderBy('product_model_id', 'asc')->orderBy('product_year_id', 'asc')->orderBy('id', 'desc')->paginate($per_page);
            $data['products']->appends(array('q' => $q));
            if ($page != 1) {
                $data['total_data'] = $data['products']->total();
                $data['count'] = ($per_page * $page) - $per_page + 1;
                $data['from_data'] = $data['count'];
                $to_data = $page * $data['products']->count();
                $data['to_data'] = ($to_data > $data['from_data']) ? $to_data : $data['total_data'];
            } else {
                $data['total_data'] = $data['products']->total();
                $data['count'] = 1;
                $data['from_data'] = 1;
                $data['to_data'] = $data['products']->count();
            }
            return $data;
        } catch (\Exception$e) {
            return response()->json(['errors' => $e->getMessage()], 401);
        }
    }

    public function status($request)
    {
        try {
            Product::where('id', $request->id)
                ->update([
                    $request->field_name => $request->val,
                ]);
        } catch (\Exception$e) {
            return response()->json(['errors' => $e->getMessage()], 401);
        }
    }

    public function store($request)
    {
        try {
            if ($request['id']) {
                $id = $request['id'];
                $product = Product::findOrFail($id);
                $message = "Data updated";
            } else {
                $id = 0;
                $product = new Product;
                $message = "Data added";
            }
            if (preg_match('#^data:image.*?base64,#', $request['image'])) {
                $image = $this->StoreBase64Image($request['image'], '/product/');
            } else {
                $image = ($product) ? $product->image : '';
            }
            $product->supplier_id = Auth::guard('supplier')->id();
            $product->sku = $request['sku'];
            $product->part_type = $request['part_type'];
            $product->part_number = $request['part_number'];
            $product->manufacturer = $request['manufacturer'];
            $product->name = $request['name'];
            $product->image = $image;
            $product->product_category_id = $request['category_id'];
            $product->product_sub_category_id = $request['subcategory_id'];
            $product->product_brand_id = $request['brand_id'];
            $product->product_make_id = $request['make_id'];
            $product->product_model_id = $request['model_id'];
            $product->product_year_id = $request['year_id'];
            $product->product_engine_id = $request['engine_id'];
            $product->warranty = $request['warranty'];
            $product->price = $request['price'];
            $product->status = isset($request['status']) ? 1 : 0;
            $product->save();
            $response['message'] = $message;
            $response['errors'] = false;
            $response['status_code'] = 201;
            return response()->json($response, 201);
        } catch (\Exception$e) {
            return response()->json(['errors' => $e->getMessage()], 401);
        }
    }

    public function imageDelete($request)
    {
        try {
            $id = $request->id;
            $field_name = $request->field_name;
            $ras = Product::where('id', $id)->first();
            if ($ras) {
                Storage::disk('public')->delete('/product/' . $ras->$field_name);
                $ras->$field_name = '';
                $ras->save();
            }
            return "success";
        } catch (\Exception$e) {
            return response()->json(['errors' => $e->getMessage()], 401);
        }
    }

    public function addSpecification($request)
    {
        try {
            $product_id = $request['product_id'];
            ProductSpecification::where('product_id', $product_id)->delete();
            foreach ($request['specification_name'] as $key => $specification_name) {
                if ($specification_name && $request['specification_value'][$key]) {
                    $specification = new ProductSpecification;
                    $specification->product_id = $product_id;
                    $specification->specification_name = $specification_name;
                    $specification->specification_value = $request['specification_value'][$key];
                    $specification->save();
                }
            }
            return "Data updated";
        } catch (\Exception$e) {
            return response()->json(['errors' => $e->getMessage()], 401);
        }
    }

    public function addMatch($request)
    {
        try {
            $product_id = $request['product_id'];
            ProductMatch::where('product_id', $product_id)->delete();
            foreach ($request['engine_id'] as $engine_id) {
                if ($engine_id) {
                    $engine = ProductEngine::where('id', $engine_id)->first();
                    if($engine) {
                        $match = new ProductMatch;
                         $match->product_id = $product_id;
                        $match->product_make_id = $engine->product_make_id;
                        $match->product_model_id = $engine->product_model_id;
                        $match->product_year_id = $engine->product_year_id;
                        $match->product_engine_id = $engine_id;
                        $match->save();
                   }
                }
            }
            return "Data updated";
        } catch (\Exception$e) {
            return response()->json(['errors' => $e->getMessage()], 401);
        }
    }


    public function addImages($request)
    {
        try {
            $product_image  = new ProductImage;
            $product_image->product_id = $request['product_id'];
            $product_image->image = $this->StoreImage($request['image'], '/product/');
            $product_image->save();
            return "Data updated";
        } catch (\Exception$e) {
            return response()->json(['errors' => $e->getMessage()], 401);
        }
    }

    public function imagesDelete($request)
    {
        try {
            $id = $request->id;
            $ras = ProductImage::where('id', $id)->first();
            if ($ras) {
                Storage::disk('public')->delete('/product/' . $ras->image);
                ProductImage::where('id', $id)->delete();
            }
            return "success";
        } catch (\Exception$e) {
            return response()->json(['errors' => $e->getMessage()], 401);
        }
    }

    public function delete($request)
    {
        try {
            $supplier_id = Auth::guard('supplier')->id();
            $id = $request->id;
            Product::where('id', $id)->where('supplier_id', $supplier_id)->delete();
            return "success";
        } catch (\Exception$e) {
            return response()->json(['errors' => $e->getMessage()], 401);
        }
    }
}
