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

    public function make()
    {
        try {
            $make_data = array();
            $makes = Make::where('status', 1)->orderBy('name', 'asc')->get();
            if ($makes->count() > 0) {
                foreach ($makes as $make) {
                    array_push($make_data, array('id' => $make->id, 'name' => $make->name, 'image' => Storage::disk('public')->url('make/' . $make->image)));
                }
            }
            $response['data'] = $make_data;
            $response['message'] = null;
            $response['errors'] = null;
            $response['status_code'] = 200;
            return response()->json($response, 200);
        } catch (\Exception$e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }

    public function model()
    {
        try {
            $model_data = array();
            $models = Models::where('status', 1)->orderBy('name', 'asc')->get();
            if ($models->count() > 0) {
                foreach ($models as $model) {
                    array_push($model_data, array('id' => $model->id, 'name' => $model->name, 'make_id' => $model->make_id));
                }
            }
            $response['data'] = $model_data;
            $response['message'] = null;
            $response['errors'] = null;
            $response['status_code'] = 200;
            return response()->json($response, 200);
        } catch (\Exception$e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }

    public function getModelsByMakeId($request) {
        try {
            $models = Models::where([['status', 1], ['make_id', $request['make_id']]])->orderBy('name', 'asc')->get();
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

    public function year()
    {
        try {
            $year_data = array();
            $years = Year::where('status', 1)->orderBy('name', 'asc')->get();
            if ($years->count() > 0) {
                foreach ($years as $year) {
                    array_push($year_data, array('id' => $year->id, 'name' => $year->name, 'make_id' => $year->make_id, 'model_id' => $year->model_id));
                }
            }
            $response['data'] = $year_data;
            $response['message'] = null;
            $response['errors'] = null;
            $response['status_code'] = 200;
            return response()->json($response, 200);
        } catch (\Exception$e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }

    public function engine()
    {
        try {
            $engine_data = array();
            $engines = Engine::where('status', 1)->orderBy('name', 'asc')->get();
            if ($engines->count() > 0) {
                foreach ($engines as $engine) {
                    array_push($engine_data, array('id' => $engine->id, 'name' => $engine->name, 'make_id' => $engine->make_id, 'model_id' => $engine->model_id, 'year_id' => $engine->year_id));
                }
            }
            $response['data'] = $engine_data;
            $response['message'] = null;
            $response['errors'] = null;
            $response['status_code'] = 200;
            return response()->json($response, 200);
        } catch (\Exception$e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }

    public function category()
    {
        try {
            $category_data = array();
            $categories = Category::where('status', 1)->orderBy('order', 'asc')->get();
            if ($categories->count() > 0) {
                foreach ($categories as $category) {
                    array_push($category_data, array('id' => $category->id, 'name' => $category->name));
                }
            }
            $response['data'] = $category_data;
            $response['message'] = null;
            $response['errors'] = null;
            $response['status_code'] = 200;
            return response()->json($response, 200);
        } catch (\Exception$e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }

    public function subcategory()
    {
        try {
            $subcategory_data = array();
            $subcategories = Subcategory::where('status', 1)->orderBy('order', 'asc')->get();
            if ($subcategories->count() > 0) {
                foreach ($subcategories as $subcategory) {
                    array_push($subcategory_data, array('id' => $subcategory->id, 'name' => $subcategory->name, 'category_id' => $subcategory->category_id));
                }
            }
            $response['data'] = $subcategory_data;
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
            $brand_data = array();
            $brands = Brand::where('status', 1)->orderBy('order', 'asc')->get();
            if ($brands->count() > 0) {
                foreach ($brands as $brand) {
                    array_push($brand_data, array('id' => $brand->id, 'name' => $brand->name));
                }
            }
            $response['data'] = $brand_data;
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
            $products = Product::where([['vendor_id', $vendor_id], ['admin_approved', 1]])->orderBy('id', 'asc')->get();
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
            } else {
                $id = 0;
                $product = new Product;
            }
            $product->vendor_id = Auth::guard('vendor-api')->user()->id;
            $product->main_image = isset($request['main_image']) ? $this->StoreImage($request['main_image'], '/product/') : null;
            $product->image_01 = isset($request['image_01']) ? $this->StoreImage($request['image_01'], '/product/') : null;
            $product->image_02 = isset($request['image_02']) ? $this->StoreImage($request['image_02'], '/product/') : null;
            $product->image_03 = isset($request['image_03']) ? $this->StoreImage($request['image_03'], '/product/') : null;
            $product->image_04 = isset($request['image_04']) ? $this->StoreImage($request['image_04'], '/product/') : null;
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
