<?php
namespace App\Services\Api\User;

use App\Models\Product;
use App\Models\Category;
use App\Models\Engine;
use App\Models\Make;
use App\Models\Models;
use App\Models\SubCategory;
use App\Models\Review;
use App\Models\Suitablefor;
use App\Models\VendorReview;
use App\Models\Year;
use App\Models\Type;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductService
{
    public function topDeals($limit)
    {
        try {
            $conditions = [['discount', '>', '0'], ['admin_approved', '1'], ['status', 1]];
            if($limit == 0) {
                $products = Product::where($conditions)->orderBy('created_at', 'desc')->get();
            } 
            else {
                $products = Product::where($conditions)->orderBy('created_at', 'desc')->take($limit)->get();
            }
            
            if ($products->count() > 0) {
                foreach ($products as $product) {
                    if ($product->main_image) {
                        $product->main_image = env('APP_URL') . '/storage/product/' . $product->main_image;
                    }
                }
            }
            $response['data'] = $products;
            $response['message'] = null;
            $response['errors'] = null;
            $response['status_code'] = 200;
            return response()->json($response, 200);
        } catch (\Exception $e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }

    public function featuredProducts($limit)
    {
        try {
            $conditions = [['status', '1'], ['admin_approved', '1']];
            if($limit == 0) {
                $products = Product::where($conditions)->orderBy('created_at', 'desc')->get();
            } 
            else {
                $products = Product::where($conditions)->orderBy('created_at', 'desc')->take($limit)->get();
            }
            
            if ($products->count() > 0) {
                foreach ($products as $product) {
                    if ($product->main_image) {
                        $product->main_image = env('APP_URL') . '/storage/product/' . $product->main_image;
                    }
                }
            }
            $response['data'] = $products;
            $response['message'] = null;
            $response['errors'] = null;
            $response['status_code'] = 200;
            return response()->json($response, 200);
        }
        catch (\Exception $e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        } 
    }
    
    public function addProductView($id)
    {
        $prodView = DB::table('product_views')->where('product_id', $id)->first();
        if ($prodView) {
            $cnt = $prodView->views + 1;
            DB::table('product_views')
                ->where('product_id', $id)
                ->update([
                    'views' => $cnt
                ]);
        } else {
            DB::table('product_views')->insert([
                'product_id' => $id,
                'views' => 1
            ]);
        }
    }

    public function productDetail($id)
    {
        try {
            $product_data = array();
            $product = Product::find($id);
            $product_suitable = array();
            $suitable_for = Suitablefor::where([['product_id', $product->id]])->get();

            if (count($suitable_for) > 0) {
                foreach ($suitable_for as $item) {
                    $make = Make::where('id', $item->make_id)->first();
                    $model = Models::where('id', $item->model_id)->first();
                    $year = Year::where('id', $item->year_id)->first();
                    $engine = Engine::where('id', $item->engine_id)->first();
                    $product_suitable[] = [
                        'make' => $make->name,
                        'model' => $model->name,
                        'year' => $year->name,
                        'engine' => $engine->name
                    ];

                }
            }

            $rate = VendorReview::where('vendor_id', $product->vendor_id)->sum('rating');
            $rate_count = VendorReview::where('vendor_id', $product->vendor_id)->count();
            if($rate_count > 0) {
                $average_rating = floor($rate / $rate_count);
            } 
            else {
                $average_rating = 0;
            }

            if ($product) {
                $product_data[] = [
                    'main_image' => env('APP_URL') . '/storage/product/' . $product->main_image,
                    'image_01' => env('APP_URL') . '/storage/product/' . $product->image_01,
                    'image_02' => env('APP_URL') . '/storage/product/' . $product->image_02,
                    'image_03' => env('APP_URL') . '/storage/product/' . $product->image_03,
                    'image_04' => env('APP_URL') . '/storage/product/' . $product->image_04,
                    'title' => $product->title,
                    'part_number' => $product->part_number,
                    'sku' => $product->sku,
                    'make' => $product->make->name,
                    'model' => $product->model->name,
                    'year' => $product->year->name,
                    'engine' => $product->engine->name,
                    'manufacturer' => $product->manufacturer,
                    'origin' => $product->origin,
                    'brand' => isset($product->brand_id) ? $product->brand->name : "",
                    'part_type' => $product->part_type,
                    'market' => $product->market,
                    'warranty' => $product->warranty,
                    'category' => $product->category->name,
                    'subcategory' => $product->subcategory->name,
                    'price' => $product->price,
                    'discount' => $product->discount,
                    'stock' => $product->stock,
                    'weight' => $product->weight,
                    'height' => $product->height,
                    'width' => $product->width,
                    'length' => $product->length,
                    'vendor_id' => $product->vendor_id,
                    'vendor_name' => $product->vendor->business_name,
                    'vendor_rating' => getRatingStar($average_rating),
                    'product_suitable_for' => $product_suitable
                ];

                $response['data'] = $product_data;
                $response['message'] = null;
                $response['errors'] = null;
                $response['status_code'] = 200;
                return response()->json($response, 200);
            } else {
                $response['data'] = false;
                $response['message'] = null;
                $response['errors'] = null;
                $response['status_code'] = 200;
                return response()->json($response, 200);
            }
        } catch (\Exception $e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }


















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
            $categories = Category::where([['status', 1], ['type', 'default']])->orderBy('order', 'asc')->get();
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
                'part_type' => $request['part_type'],
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
                    $product_data[] = [
                        'id' => $product->id,
                        'main_image' => env('APP_URL') . '/storage/product/' . $product->main_image,
                        'image_01' => env('APP_URL') . '/storage/product/' . $product->image_01,
                        'image_02' => env('APP_URL') . '/storage/product/' . $product->image_02,
                        'image_03' => env('APP_URL') . '/storage/product/' . $product->image_03,
                        'image_04' => env('APP_URL') . '/storage/product/' . $product->image_04,
                        'title' => $product->title,
                        'part_number' => $product->part_number,
                        'sku' => $product->sku,
                        'make' => $product->make->name,
                        'model' => '',
                        'year' => $product->year->name,
                        'engine' => $product->engine->name,
                        'manufacturer' => $product->manufacturer,
                        'origin' => $product->origin,
                        'brand' => $product->brand->name,
                        'part_type' => $product->part_type,
                        'market' => $product->market,
                        'warranty' => $product->warranty,
                        'category' => $product->category->name,
                        'subcategory' => $product->subcategory->name,
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

    public function listOtherCategories()
    {
        try {
            $categories = Category::where([['status', 1], ['type', 'other']])->orderBy('order', 'asc')->get();
            $response['data'] = $categories;
            $response['message'] = null;
            $response['errors'] = null;
            $response['status_code'] = 200;
            return response()->json($response, 200);
        } catch (\Exception $e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }

    public function listProductByOtherCategories($category_id)
    {
        try {
            $conditions = array(
                'category_id' => $category_id,
                'status' => 1,
                'admin_approved' => 1
            );
            $products = Product::where($conditions)->orderBy('created_at', 'desc')->get();
            if ($products->count() > 0) {
                foreach ($products as $product) {
                    if ($product['main_image']) {
                        $product->main_image = env('APP_URL') . '/storage/product/' . $product['main_image'];
                    }
                    if ($product['image_01']) {
                        $product->image_01 = env('APP_URL') . '/storage/product/' . $product['image_01'];
                    }
                    if ($product['image_02']) {
                        $product->image_02 = env('APP_URL') . '/storage/product/' . $product['image_02'];
                    }
                    if ($product['image_03']) {
                        $product->image_03 = env('APP_URL') . '/storage/product/' . $product['image_03'];
                    }
                    if ($product['image_04']) {
                        $product->image_04 = env('APP_URL') . '/storage/product/' . $product['image_04'];
                    }
                }
            }
            $response['data'] = $products;
            $response['message'] = null;
            $response['errors'] = null;
            $response['status_code'] = 200;
            return response()->json($response, 200);
        } catch (\Exception $e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }

}