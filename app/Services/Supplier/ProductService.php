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
            return response()->json(['errors' => $e->getMessage()], 400);
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
            return response()->json(['errors' => $e->getMessage()], 400);
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
            $folder = ($request['folder']) ? $request['folder'] : getSlug("products", "folder", $request['name'], $id);
            $directory = 'product/' . $folder;
            if ($id == 0) {
                Storage::disk('public')->makeDirectory($directory);
            }
            $product->supplier_id = Auth::guard('supplier')->id();
            $product->sku = $request['sku'];
            $product->part_type = $request['part_type'];
            $product->part_number = $request['part_number'];
            $product->manufacturer = $request['manufacturer'];
            $product->product_type = $request['product_type'];
            $product->name = $request['name'];
            $product->folder = $folder;
            $product->product_category_id = $request['category_id'];
            $product->product_sub_category_id = $request['subcategory_id'];
            $product->product_brand_id = $request['brand_id'];
            $product->product_make_id = $request['make_id'];
            $product->product_model_id = $request['model_id'];
            $product->product_year_id = $request['year_id'];
            $product->product_engine_id = $request['engine_id'];
            $product->warranty = $request['warranty'];
            $product->stock = $request['stock'];
            $product->price = $request['price'];
            $product->status = isset($request['status']) ? 1 : 0;
            $product->save();
            $response['message'] = $message;
            $response['errors'] = false;
            $response['status_code'] = 201;
            return response()->json($response, 201);
        } catch (\Exception$e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }

    public function addSpecification($request)
    {
        try {
            foreach ($request['specification_id'] as $key => $specification_id) {
                if ($request['specification_name'][$key] && $request['specification_value'][$key]) {
                    if ($specification_id > 0) {
                        $specification = ProductSpecification::where('id', $specification_id)->first();
                    } else {
                        $specification = new ProductSpecification;
                    }
                    $specification->product_id = $request['product_id'];
                    $specification->specification_name = $request['specification_name'][$key];
                    $specification->specification_value = $request['specification_value'][$key];
                    $specification->save();
                }
            }
            $response['message'] = 'Specification added.';
            $response['errors'] = false;
            $response['status_code'] = 201;
            return response()->json($response, 201);
        } catch (\Exception$e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }

    public function deleteSpecification($request)
    {
        try {
            $id = $request->specification_id;
            ProductSpecification::where('id', $id)->delete();
            return "success";
        } catch (\Exception$e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }

    public function addMatch($request)
    {
        try {
            foreach ($request['match_id'] as $key => $match_id) {
                $engine_id = $request['engine_id'][$key];
                $engine = ProductEngine::where('id', $engine_id)->first();
                if ($engine) {
                    if ($match_id > 0) {
                        $match = ProductMatch::where('id', $match_id)->first();
                    } else {
                        $match = new ProductMatch;
                    }
                    $match->product_id = $request['product_id'];
                    $match->product_make_id = $engine->product_make_id;
                    $match->product_model_id = $engine->product_model_id;
                    $match->product_year_id = $engine->product_year_id;
                    $match->product_engine_id = $engine_id;
                    $match->save();
                }
            }
            $response['message'] = 'Matches added.';
            $response['errors'] = false;
            $response['status_code'] = 201;
            return response()->json($response, 201);
        } catch (\Exception$e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }

    public function deleteMatch($request)
    {
        try {
            $id = $request->match_id;
            ProductMatch::where('id', $id)->delete();
            return "success";
        } catch (\Exception$e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }

    public function delete($request)
    {
        try {
            $supplier_id = Auth::guard('supplier')->id();
            $id = $request->id;
            $product = Product::where('id', $id)->where('supplier_id', $supplier_id)->first();
            if ($product) {
                Storage::disk('public')->deleteDirectory('product/' . $product->folder);
                Product::where('id', $id)->where('supplier_id', $supplier_id)->delete();
                return "success";
            } else {
                return "fail";
            }
        } catch (\Exception$e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }

    public function saveImage($request)
    {
        try {
            $product_id = $request['product_id'];
            $product = Product::with('image')->where('id', $product_id)->first();
            $is_primary = (count($product->image) > 0) ? 0 : 1;
            if (preg_match('#^data:image.*?base64,#', $request['image'])) {
                $image = $this->StoreBase64Image($request['image'], '/product/' . $product->folder . '/');
            } else {
                $image = '';
            }
            $product_image = new ProductImage;
            $product_image->product_id = $product_id;
            $product_image->is_primary = $is_primary;
            $product_image->image = $image;
            $product_image->order = getMax('product_images', 'order');
            $product_image->save();
            $response['message'] = 'Image added.';
            $response['errors'] = false;
            $response['status_code'] = 201;
            return response()->json($response, 201);
        } catch (\Exception$e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }

    public function orderImage($request)
    {
        try {
            $cnt = 1;
            foreach ($request['id'] as $id) {
                ProductImage::where('id', $id)
                    ->update([
                        'order' => $cnt,
                    ]);
                $cnt++;
            }
            $response['message'] = 'Order updated.';
            $response['errors'] = false;
            $response['status_code'] = 201;
            return response()->json($response, 201);
        } catch (\Exception$e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }

    public function imageStatus($request)
    {
        try {
            if ($request->val == 1) {
                ProductImage::where('product_id', $request->product_id)
                    ->update(['is_primary' => 0]);
                ProductImage::where('id', $request->id)
                    ->update(['is_primary' => 1]);
            } else {
                $product_image = ProductImage::where('id', $request->id)->first();
                if ($product_image->is_primary == 1) {
                    ProductImage::where('product_id', $request->product_id)
                        ->update(['is_primary' => 0]);
                    $product_images = ProductImage::where('product_id', $request->product_id)->where('id', '<>', $request->id)->first();
                    ProductImage::where('id', $product_images->id)
                        ->update(['is_primary' => 1]);
                } else {
                    ProductImage::where('id', $request->id)
                        ->update(['is_primary' => 0]);
                }
            }

        } catch (\Exception$e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }

    public function imageDelete($request)
    {
        try {
            $id = $request->id;
            $ras = ProductImage::with('product')->where('id', $id)->first();
            if ($ras->is_primary == 1) {
                $product_images = ProductImage::where('product_id', $ras->product_id)->where('id', '<>', $id)->first();
                ProductImage::where('id', $product_images->id)
                    ->update(['is_primary' => 1]);
            }
            Storage::disk('public')->delete('/product/' . $ras->product->folder . '/' . $ras->image);
            ProductImage::where('id', $id)->delete();
            return "success";
        } catch (\Exception$e) {
            return response()->json(['errors' => $e->getMessage()], 401);
        }
    }
}
