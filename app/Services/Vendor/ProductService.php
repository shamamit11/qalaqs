<?php
namespace App\Services\Vendor;

use App\Models\Product;
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
            $query = Product::select('*')->with('specifications')->with('images')->with('make')->with('model')->with('year');
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
            $product->title = $request['title'];
            $product->part_number = $request['part_number'];
            $product->sku = $request['sku'];
            $product->title = $request['title'];
            $product->make_id = $request['make_id'];
            $product->model_id = $request['model_id'];
            $product->year_id = $request['year_id'];
            $product->engine_id = $request['engine_id'];
            $product->manufacturer = $request['manufacturer'];
            $product->origin = $request['origin'];
            $product->brand_id = $request['brand_id'];
            $product->part_type = $request['part_type'];
            $product->market = $request['market'];
            $product->warranty = $request['warranty'];
            $product->category_id = $request['category_id'];
            $product->subcategory_id = $request['subcategory_id'];
            $product->price = $request['price'];
            $product->discount = isset($request['discount']) ? $request['discount'] : 0;
            $product->stock = $request['stock'];
            $product->weight = $request['weight'];
            $product->height = $request['height'];
            $product->width = $request['width'];
            $product->length = $request['length'];
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
}