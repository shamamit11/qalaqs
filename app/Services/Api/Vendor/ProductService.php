<?php
namespace App\Services\Api\Vendor;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Engine;
use App\Models\Make;
use App\Models\Models;
use App\Models\Subcategory;
use App\Models\Year;
use App\Models\Product;
use App\Models\Suitablefor;
use App\Traits\StoreImageTrait;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ProductService
{
    use StoreImageTrait;

    public function getMakes()
    {
        try {
            $makes = Make::where('status', 1)->orderBy('name', 'asc')->get();
            $response['data'] = $makes;
            $response['message'] = null;
            $response['errors'] = null;
            $response['status_code'] = 200;
            return response()->json($response, 200);
        } catch (\Exception$e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }

    public function getModels($make_id) {
        try {
            $models = Models::where([['status', 1], ['make_id', $make_id]])->orderBy('name', 'asc')->get();
            $response['data'] = $models;
            $response['message'] = false;
            $response['errors'] = false;
            $response['status_code'] = 200;
            return response()->json($response, 200);
        }
        catch (\Exception$e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }

    public function getYears($make_id, $model_id) {
        try {
            $years = Year::where([
                ['status', 1], 
                ['make_id', $make_id],
                ['model_id', $model_id]
            ])->orderBy('name', 'asc')->get();

            $response['data'] = $years;
            $response['message'] = false;
            $response['errors'] = false;
            $response['status_code'] = 200;
            return response()->json($response, 200);
        }
        catch (\Exception$e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }

    public function getEngines($make_id, $model_id, $year_id) {
        try {
            $engines = Engine::where([
                ['status', 1], 
                ['make_id', $make_id],
                ['model_id', $model_id],
                ['year_id', $year_id]
            ])->orderBy('name', 'asc')->get();

            $response['data'] = $engines;
            $response['message'] = false;
            $response['errors'] = false;
            $response['status_code'] = 200;
            return response()->json($response, 200);
        }
        catch (\Exception$e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }
    public function category()
    {
        try {
            $categories = Category::where('status', 1)->orderBy('order', 'asc')->get();
            $response['data'] = $categories;
            $response['message'] = null;
            $response['errors'] = null;
            $response['status_code'] = 200;
            return response()->json($response, 200);
        } catch (\Exception$e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }

    public function getSubcategory($category_id)
    {
        try {
            $subcategories = Subcategory::where([['status', 1], ['category_id',$category_id]])->orderBy('order', 'asc')->get();
            $response['data'] = $subcategories;
            $response['message'] = null;
            $response['errors'] = null;
            $response['status_code'] = 200;
            return response()->json($response, 200);
        } catch (\Exception$e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }

    public function brand()
    {
        try {
            $brands = Brand::where('status', 1)->orderBy('order', 'asc')->get();
            $response['data'] = $brands;
            $response['message'] = null;
            $response['errors'] = null;
            $response['status_code'] = 200;
            return response()->json($response, 200);
        } catch (\Exception$e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }


    public function listProducts() {
        try {
            $vendor_id = Auth::guard('vendor-api')->user()->id;
            $products = Product::where([['vendor_id', $vendor_id], ['admin_approved', 1]])->orderBy('id', 'desc')->get()->makeHidden(['make', 'model', 'year', 'engine', 'category', 'brand']);
            if($products->count() > 0) {
                foreach ($products as $product) {
                    if($product['main_image']) {
                        $product->main_image = env('APP_URL').'/storage/product/'.$product['main_image'];
                    }
                    if($product['image_01']) {
                        $product->image_01 = env('APP_URL').'/storage/product/'.$product['image_01'];
                    }
                    if($product['image_02']) {
                        $product->image_02 = env('APP_URL').'/storage/product/'.$product['image_02'];
                    }
                    if($product['image_03']) {
                        $product->image_03 = env('APP_URL').'/storage/product/'.$product['image_03'];
                    }
                    if($product['image_04']) {
                        $product->image_04 = env('APP_URL').'/storage/product/'.$product['image_04'];
                    }
                    $product->make_data = array("label" => $product->make->name, "value" => $product->make->id);
                    $product->model_data = array("label" => $product->model->name, "value" => $product->model->id);
                    $product->year_data = array("label" => $product->year->name, "value" => $product->year->id);
                    $product->engine_data = array("label" => $product->engine->name, "value" => $product->engine->id);
                    if($product->category_id) {
                        $product->category_data = array("label" => $product->category->name, "value" => $product->category->id);
                    }
                    if($product->brand_id){
                        $product->brand_data = array("label" => $product->brand->name, "value" => $product->brand->id);
                    }
                }
            
            }
            $response['data'] = $products;
            $response['message'] = null;
            $response['errors'] = null;
            $response['status_code'] = 200;
            return response()->json($response, 200);
        } catch (\Exception$e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }

    public function store($request) {
        try {
            if ($request['id']) {
                $id = $request['id'];
                $product = Product::findOrFail($id);
                $product->main_image = isset($request['main_image']) ? $this->StoreImage($request['main_image'], '/product/') : $product->main_image;
                $product->image_01 = isset($request['image_01']) ? $this->StoreImage($request['image_01'], '/product/') : $product->image_01;
                $product->image_02 = isset($request['image_02']) ? $this->StoreImage($request['image_02'], '/product/') : $product->image_02;
                $product->image_03 = isset($request['image_03']) ? $this->StoreImage($request['image_03'], '/product/') : $product->image_03;
                $product->image_04 = isset($request['image_04']) ? $this->StoreImage($request['image_04'], '/product/') : $product->image_03;
                   
            } else {
                $id = 0;
                $product = new Product;
                $product->main_image = isset($request['main_image']) ? $this->StoreImage($request['main_image'], '/product/') : null;
                $product->image_01 = isset($request['image_01']) ? $this->StoreImage($request['image_01'], '/product/') : null;
                $product->image_02 = isset($request['image_02']) ? $this->StoreImage($request['image_02'], '/product/') : null;
                $product->image_03 = isset($request['image_03']) ? $this->StoreImage($request['image_03'], '/product/') : null;
                $product->image_04 = isset($request['image_04']) ? $this->StoreImage($request['image_04'], '/product/') : null;
            }
            $product->vendor_id = Auth::guard('vendor-api')->user()->id;
            $product->title = $request['title'];
            $product->part_number = $request['part_number'];
            $product->sku = $request['sku'];
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
            $response['data'] = $product;
            $response['message'] = null;
            $response['errors'] = null;
            $response['status_code'] = 201;
            return response()->json($response, 201);
        } catch (\Exception$e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
        
    }

    public function productDetail($id) {
        try {
            $vendor_id = Auth::guard('vendor-api')->user()->id;
            $product = Product::where([['vendor_id', $vendor_id], ['id', $id]])->first();
            $suitable_for = Suitablefor::where([['product_id', $product->id]])->get()->makeHidden(['product_id', 'created_at', 'updated_at']);

            foreach($suitable_for as $item) {
                $make = Make::where('id', $item->make_id)->first();
                $model = Models::where('id', $item->model_id)->first();
                $year = Year::where('id', $item->year_id)->first();
                $engine = Engine::where('id', $item->engine_id)->first();
                $item->make = $make->name;
                $item->model = $model->name;
                $item->year = $year->name;
                $item->engine = $engine->name;
            }

            if($product->main_image) {
                $product->main_image = env('APP_URL').'/storage/product/'.$product->main_image;
            }
            if($product->image_01) {
                $product->image_01 = env('APP_URL').'/storage/product/'.$product->image_01;
            }
            if($product->image_02) {
                $product->image_02 = env('APP_URL').'/storage/product/'.$product->image_02;
            }
            if($product->image_03) {
                $product->image_03 = env('APP_URL').'/storage/product/'.$product->image_03;
            }
            if($product->image_04) {
                $product->image_04 = env('APP_URL').'/storage/product/'.$product->image_04;
            }
            $product->suitable_for = $suitable_for;

            $response['data'] = $product;
            $response['message'] = null;
            $response['errors'] = null;
            $response['status_code'] = 200;
            return response()->json($response, 200);

        } catch (\Exception$e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }

    }

    public function deleteProduct($id) {
        try {
            $vendor_id = Auth::guard('vendor-api')->user()->id;
            $product = Product::where([['vendor_id', $vendor_id], ['id', $id]])->first();
            if($product) {
                Storage::disk('public')->delete('/product/' . $product->main_image);
                Storage::disk('public')->delete('/product/' . $product->image_01);
                Storage::disk('public')->delete('/product/' . $product->image_02);
                Storage::disk('public')->delete('/product/' . $product->image_03);
                Storage::disk('public')->delete('/product/' . $product->image_04);
                $product->delete();
                $response['message'] = "success";
                $response['errors'] = null;
                $response['status_code'] = 200;
                return response()->json($response, 200);
            }
        } catch (\Exception$e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }

    public function productSuitable($prod_id) {
        try {
            $matches = Suitablefor::where([['product_id', $prod_id]])->get(['id', 'make_id', 'model_id', 'year_id', 'engine_id']);
            foreach($matches as $item) {
                $make = Make::where('id', $item->make_id)->first();
                $model = Models::where('id', $item->model_id)->first();
                $year = Year::where('id', $item->year_id)->first();
                $engine = Engine::where('id', $item->engine_id)->first();
                $item->make = $make->name;
                $item->model = $model->name;
                $item->year = $year->name;
                $item->engine = $engine->name;
            }
            $response['data'] = $matches;
            $response['message'] = null;
            $response['errors'] = null;
            $response['status_code'] = 201;
            return response()->json($response, 201);

        } catch (\Exception$e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }

    }

    public function addSuitable($request) {
        try {
            $suitable_product = new Suitablefor;
            $suitable_product->product_id = $request['product_id'];
            $suitable_product->make_id = $request['make_id'];
            $suitable_product->model_id = $request['model_id'];
            $suitable_product->year_id = $request['year_id'];
            $suitable_product->engine_id = $request['engine_id'];
            $suitable_product->save();
            $response['data'] = $suitable_product;
            $response['message'] = null;
            $response['errors'] = null;
            $response['status_code'] = 200;
            return response()->json($response, 200);

        } catch (\Exception$e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }

    }

    public function deleteSuitable($suitable_id) {
        try {
            Suitablefor::where('id', $suitable_id)->delete();
            $response['message'] = "success";
            $response['errors'] = null;
            $response['status_code'] = 200;
            return response()->json($response, 200);
        } catch (\Exception$e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }
}
