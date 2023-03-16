<?php
namespace App\Services\Api\User;

use App\Models\Product;
use App\Models\Category;
use App\Models\Engine;
use App\Models\Make;
use App\Models\Models;
use App\Models\SubCategory;
use App\Models\Review;
use App\Models\Year;
use Illuminate\Support\Facades\Storage;

class ProductService
{
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

    public function product($request)
    {
        try {
            $conditions = array('type' => $request['type'],
                'category_id' => $request['category_id'],
                'subcategory_id' => $request['subcategory_id'],
                'make_id' => $request['make_id'],
                'model_id' => $request['model_id'],
                'year_id' => $request['year_id'],
                'engine_id' => $request['engine_id'],
                'status' => 1,
                'admin_approved' => 1);
            $product_data = array();
            $products = Product::where($conditions)->orderBy('name', 'asc')->get();
            if ($products->count() > 0) {
                foreach ($products as $product) {
                    $matches = array();
                    if(count($product->matches) > 0) {
                        foreach($product->matches as $match) {
                            array_push($matches, array('id' => $match->id,  'name' =>  $match->make->name.' / '.$match->model->name.' / '.$match->year->name.' / '.$match->engine->name));
                        }
                    }
                    $reviews = array();
                    $rating = 0;
                    if(count($product->reviews) > 0) {
                        $total_rating = 0;
                        foreach($product->reviews as $review) {
                            array_push($reviews, array('id' => $review->id, 'name' =>  $review->name, 'reviews' =>  $review->reviews, 'rating' =>  $review->rating));
                            $total_rating = $total_rating + $review->rating;
                        }
                        $rating = round(($total_rating / count($product->reviews)),0);

                    }
                    $data = array('id' => $product->id,
                        'sku' => $product->sku,
                        'part_type' => $product->part_type,
                        'part_number' => $product->part_number,
                        'type' => $product->type,
                        'manufacturer' => $product->manufacturer,
                        'rating' => $rating,
                        'name' => $product->name,
                        'category' => $product->category->name,
                        'subcategory' => $product->subcategory->name,
                        'brand' => $product->brand->name,
                        'make' => $product->make->name,
                        'model' => $product->model->name,
                        'year' => $product->year->name,
                        'engine' => $product->engine->name,
                        'warranty' => $product->warranty,
                        'price' => $product->price,
                        'stock' => $product->stock,
                        'specifications' => $product->specifications,
                        'matches' => $matches,
                        'image' => Storage::disk('public')->url('product/' . $product->folder . '/' . $product->image[0]->image),
                        'images' => $product->images,
                        'reviews' => $reviews);
                    array_push($product_data, $data);
                }
            }
            $response['data'] = $product_data;
            $response['message'] = null;
            $response['errors'] = null;
            $response['status_code'] = 200;
            return response()->json($response, 200);
        } catch (\Exception$e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }

}