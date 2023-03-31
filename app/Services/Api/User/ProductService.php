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
use App\Models\Type;
use Illuminate\Support\Facades\DB;
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
        } catch (\Exception $e) {
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
        } catch (\Exception $e) {
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
        } catch (\Exception $e) {
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
        } catch (\Exception $e) {
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
        } catch (\Exception $e) {
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
        } catch (\Exception $e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }

    public function types()
    {
        try {
            $type_data = array();
            $types = Type::orderBy('created_at', 'desc')->get();
            if ($types->count() > 0) {
                foreach ($types as $type) {
                    $type_data[] = ['id' => $type->id, 'name' => $type->name
                    ];

                }
            }
            $response['data'] = $type_data;
            $response['message'] = null;
            $response['errors'] = null;
            $response['status_code'] = 200;
            return response()->json($response, 200);
        } catch (\Exception $e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }

    public function product($request)
    {
        try {
            $conditions = array(
                'make_id' => $request['make_id'],
                'model_id' => $request['model_id'],
                'year_id' => $request['year_id'],
                'engine_id' => $request['engine_id'],
                'category_id' => $request['category_id'],
                'subcategory_id' => $request['subcategory_id'],
                'type_id' => $request['type_id'],
                'status' => 1,
                'admin_approved' => 1
            );
            $product_data = array();
            $products = Product::where($conditions)->orderBy('created_at', 'desc')->get();
            if ($products->count() > 0) {
                foreach ($products as $product) {
//                    $matches = array();
//                    if (count($product->matches) > 0) {
//                        foreach ($product->matches as $match) {
//                            array_push($matches, array('id' => $match->id, 'name' => $match->make->name . ' / ' . $match->model->name . ' / ' . $match->year->name . ' / ' . $match->engine->name));
//                        }
//                    }
                    $reviews = array();
                    $rating = 0;
                    if (count($product->reviews) > 0) {
                        $total_rating = 0;
                        foreach ($product->reviews as $review) {
                            array_push($reviews, array('id' => $review->id, 'name' => $review->name, 'reviews' => $review->reviews, 'rating' => $review->rating));
                            $total_rating = $total_rating + $review->rating;
                        }
                        $rating = round(($total_rating / count($product->reviews)), 0);

                    }
                    $product_data[] = ['id' => $product->id,
                        'main_image' => env('APP_URL').'/storage/product/'.$product->main_image,
                        'image_01' => env('APP_URL').'/storage/product/'.$product->image_01,
                        'image_02' => env('APP_URL').'/storage/product/'.$product->image_02,
                        'image_03' => env('APP_URL').'/storage/product/'.$product->image_03,
                        'image_04' => env('APP_URL').'/storage/product/'.$product->image_04,
                        'title' => $product->title,
                        'part_number' => $product->part_number,
                        'sku' => $product->sku,
                        'make' => $product->make->name,
                        'model' => '',
                        'year' => $product->year->name,
                        'engine' => $product->engine->name,
                        'manufacturer' => $product->manufacturer,
                        'brand' => $product->brand->name,
                        'part_type' => $product->part_type,
                        'market' => $product->market,
                        'warranty' => $product->warranty,
                        'category' => $product->category->name,
                        'subcategory' => $product->subcategory->name,
                        'type' => $product->types->name,
                        'price' => $product->price,
                        'discount' => $product->discount,
                        'stock' => $product->stock,
                        'weight' => $product->weight,
                        'height' => $product->height,
                        'width' => $product->width,
                        'length' => $product->length,
//                        'matches' => $matches,
                        'reviews' => $reviews
                    ];

                }
            }
            $response['data'] = $product_data;
            $response['message'] = null;
            $response['errors'] = null;
            $response['status_code'] = 200;
            return response()->json($response, 200);
        } catch (\Exception $e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }

    public function productDetail($id)
    {
        try {
            $product_data = array();
            $product = Product::find($id);

            $product_data[] = [
                'main_image' => env('APP_URL').'/storage/product/'.$product->main_image,
                'image_01' => env('APP_URL').'/storage/product/'.$product->image_01,
                'image_02' => env('APP_URL').'/storage/product/'.$product->image_02,
                'image_03' => env('APP_URL').'/storage/product/'.$product->image_03,
                'image_04' => env('APP_URL').'/storage/product/'.$product->image_04,
                'title' => $product->title,
                'part_number' => $product->part_number,
                'sku' => $product->sku,
                'make' => $product->make->name,
                'model' => '',
                'year' => $product->year->name,
                'engine' => $product->engine->name,
                'manufacturer' => $product->manufacturer,
                'brand' => $product->brand->name,
                'part_type' => $product->part_type,
                'market' => $product->market,
                'warranty' => $product->warranty,
                'category' => $product->category->name,
                'subcategory' => $product->subcategory->name,
                'type' => $product->types->name,
                'price' => $product->price,
                'discount' => $product->discount,
                'stock' => $product->stock,
                'weight' => $product->weight,
                'height' => $product->height,
                'width' => $product->width,
                'length' => $product->length
            ];

            $response['data'] = $product_data;
            $response['message'] = null;
            $response['errors'] = null;
            $response['status_code'] = 200;
            return response()->json($response, 200);
        } catch (\Exception $e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }

    public function featuredProduct()
    {
        try {
            $conditions = ['admin_approved' => '1'];
            $product_data = array();
            $products = Product::where($conditions)->orderBy('created_at', 'desc')->take(9)->get();
            if ($products->count() > 0) {
                foreach ($products as $product) {
                    array_push($product_data, array('id' => $product->id, 'title' => $product->title, 'price' => $product->price, 'part_type' => $product->part_type, 'part_number' => $product->part_number,'main_image'=>env('APP_URL').'/storage/product/'.$product->main_image));
                }
            }
            $response['data'] = $product_data;
            $response['message'] = null;
            $response['errors'] = null;
            $response['status_code'] = 200;
            return response()->json($response, 200);
        } catch (\Exception $e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }


    public function landingPageProduct()
    {
        try {
            $product_data = array();
            $conditions_feature = ['admin_approved' => '1'];
            $conditions_top_deal = [['discount','>' ,'0'], ['admin_approved','1']];
            $feature_product_data = array();
            $feature_products = Product::where($conditions_feature)->orderBy('created_at', 'desc')->take(3)->get();
            if ($feature_products->count() > 0) {
                foreach ($feature_products as $feature_product) {
                    array_push($feature_product_data, array('id' => $feature_product->id, 'title' => $feature_product->title, 'price' => $feature_product->price, 'part_type' => $feature_product->part_type, 'part_number' => $feature_product->part_number,'main_image'=>env('APP_URL').'/storage/product/'.$feature_product->main_image));
                }
            }
            $top_deal_product_data = array();
            $top_deal_products = Product::where($conditions_top_deal)->orderBy('id', 'desc')->take(3)->get();

            if ($top_deal_products->count() > 0) {
                foreach ($top_deal_products as $top_deal_product) {
                    array_push($top_deal_product_data, array('id' => $top_deal_product->id, 'title' => $top_deal_product->title, 'price' => $top_deal_product->price, 'part_type' => $top_deal_product->part_type, 'part_number' => $top_deal_product->part_number, 'discount' => $top_deal_product->discount,'main_image'=>env('APP_URL').'/storage/product/'.$top_deal_product->main_image));
                }
            }
            $product_data[] = ['feature_product' => $feature_product_data, 'top_deal_product' => $top_deal_product_data];
            //$product_data = array_push($product_data,array('feature_product'=>$feature_product_data,'top_deal_product'=>$top_deal_product_data));
            $response['data'] = $product_data;
            $response['message'] = null;
            $response['errors'] = null;
            $response['status_code'] = 200;
            return response()->json($response, 200);
        } catch (\Exception $e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }

    public function addProductView($id) {
        $prodView = DB::table('product_views')->where('product_id', $id)->first();
        if($prodView) {
            $prodView->views = $prodView->views + 1;
            $prodView->save();
        } 
        else {
            DB::table('product_views')->insert([
                'product_id' => $id, 
                'views' => 1
            ]);
        }
    }

}