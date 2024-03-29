<?php
namespace App\Services\Vendor;

use App\Models\Product;
use App\Models\Subcategory;
use App\Models\Suitablefor;
use App\Traits\StoreImageTrait;
use Illuminate\Support\Facades\Auth;

class ProductService
{
    use StoreImageTrait;
    function list($per_page, $page, $q) {
        try {
            $vendor_id = Auth::guard('vendor')->id();
            $data['q'] = $q;
            $query = Product::select('*')->with('specifications')->with('make')->with('model')->with('year');
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
            $data['products'] = $query->where('vendor_id', $vendor_id)->orderBy('make_id', 'asc')->orderBy('model_id', 'asc')->orderBy('year_id', 'asc')->orderBy('id', 'desc')->paginate($per_page);
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

    public function store($request) {
        try {
            $vendor_id = Auth::guard('vendor')->id();

            if ($request['id']) {
                $id = $request['id'];
                $product = Product::findOrFail($id);
                $message = "Data Updated";
            } else {
                $id = 0;
                $product = new Product;
                $message = "Data Added";
            }
            $product->vendor_id = $vendor_id;

            if (preg_match('#^data:image.*?base64,#', $request['main_image'])) {
                $main_image = $this->StoreBase64Image($request['main_image'], '/product/');
            } else {
                $main_image = ($product) ? $product->main_image : '';
            }

            if (preg_match('#^data:image.*?base64,#', $request['image_01'])) {
                $image_01 = $this->StoreBase64Image($request['image_01'], '/product/');
            } else {
                $image_01 = ($product) ? $product->image_01 : '';
            }

            if (preg_match('#^data:image.*?base64,#', $request['image_02'])) {
                $image_02 = $this->StoreBase64Image($request['image_02'], '/product/');
            } else {
                $image_02 = ($product) ? $product->image_02 : '';
            }

            if (preg_match('#^data:image.*?base64,#', $request['image_03'])) {
                $image_03 = $this->StoreBase64Image($request['image_03'], '/product/');
            } else {
                $image_03 = ($product) ? $product->image_03 : '';
            }

            if (preg_match('#^data:image.*?base64,#', $request['image_04'])) {
                $image_04 = $this->StoreBase64Image($request['image_04'], '/product/');
            } else {
                $image_04 = ($product) ? $product->image_04 : '';
            }

            $product->main_image = $main_image;
            $product->image_01 = $image_01;
            $product->image_02 = $image_02;
            $product->image_03 = $image_03;
            $product->image_04 = $image_04;
            $product->title = isset($request['title']) ? $request['title'] : NULL;
            $product->part_number = isset($request['part_number']) ? $request['part_number'] : NULL;
            $product->sku = isset($request['sku']) ? $request['sku'] : NULL;
            $product->make_id = isset($request['make_id']) ? $request['make_id'] : NULL;
            $product->model_id = isset($request['model_id']) ? $request['model_id'] : NULL;
            $product->year_id = isset($request['year_id']) ? $request['year_id'] : NULL;
            $product->engine_id = isset($request['engine_id']) ? $request['engine_id'] : NULL;
            $product->manufacturer = isset($request['manufacturer']) ? $request['manufacturer'] : NULL;
            $product->origin = isset($request['origin']) ? $request['origin'] : NULL;
            $product->brand_id = isset($request['brand_id']) ? $request['brand_id'] : NULL;
            $product->part_type = isset($request['part_type']) ? $request['part_type'] : NULL;
            $product->market = isset($request['market']) ? $request['market'] : NULL;
            $product->warranty = isset($request['warranty']) ? $request['warranty'] : NULL;
            $product->category_id = isset($request['category_id']) ? $request['category_id'] : NULL;
            $product->subcategory_id = isset($request['subcategory_id']) ? $request['subcategory_id'] : NULL;
            $product->price = isset($request['price']) ? $request['price'] : NULL;
            $product->discount = isset($request['discount']) ? $request['discount'] : NULL;
            $product->stock = isset($request['stock']) ? $request['stock'] : NULL;
            $product->weight = isset($request['weight']) ? $request['weight'] : NULL;
            $product->height = isset($request['height']) ? $request['height'] : NULL;
            $product->width = isset($request['width']) ? $request['width'] : NULL;
            $product->length = isset($request['length']) ? $request['length'] : NULL;
            $product->save();
            $response['message'] = $message;
            $response['errors'] = false;
            $response['status_code'] = 201;
            return response()->json($response, 201);
        }
        catch (\Exception$e) {
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
            return 'success';
        } catch (\Exception$e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }
    

    public function delete($request)
    {
        try {
            $id = $request->id;
            Product::where('id', $id)->delete();
            return "success";
        } catch (\Exception$e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }

    public function addMatchAction($request) {
        try {
            $match = new Suitablefor;
            $match->product_id = $request['product_id'];
            $match->make_id = $request['make_id'];
            $match->model_id = $request['model_id'];
            $match->year_id = $request['year_id'];
            $match->engine_id = $request['engine_id'];
            $match->save();
            $response['message'] = "Data Added Successfully";
            $response['product_id'] = $request['product_id'];
            $response['errors'] = false;
            $response['status_code'] = 201;
            return response()->json($response, 201);
        }
        catch (\Exception$e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }

    public function deleteMatch($request)
    {
        try {
            $id = $request->id;
            Suitablefor::where('id', $id)->delete();
            return "success";
        } catch (\Exception$e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }

    public function getSubcategoryById($request) {
        try {
            $subcategory = Subcategory::select('name')->where('id',  $request->id)->first();
            $response['data'] = $subcategory;
            $response['errors'] = false;
            $response['status_code'] = 200;
            return response()->json($response, 200);
        }
        catch (\Exception$e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }
}
