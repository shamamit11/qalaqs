<?php
namespace App\Services\Api\User;

use App\Models\Product;
use App\Models\Category;
use App\Models\Engine;
use App\Models\Make;
use App\Models\Models;
use App\Models\Subcategory;
use App\Models\Review;
use App\Models\Suitablefor;
use App\Models\VendorDiscount;
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
            if ($limit == 0) {
                $products = Product::where($conditions)->orderBy('created_at', 'desc')->get();
            } else {
                $products = Product::where($conditions)->orderBy('created_at', 'desc')->take($limit)->get();
            }

            if ($products->count() > 0) {
                foreach ($products as $product) {
                    $prodSubcategory = Subcategory::where('id', $product->subcategory->id)->first();
                    $product->main_image = $prodSubcategory->icon;

                    $vendorDiscountObj = VendorDiscount::where('vendor_id', $product->vendor_id)->first();
                    $discountType = $vendorDiscountObj->type;
                    $discountValue = $vendorDiscountObj->value;

                    if ($discountType == 'Topup') {
                        $topupAmount = $product->price * ($discountValue / 100);
                        $product->price = $product->price + $topupAmount;
                    } else if ($discountType == 'Discount') {
                        $productPrice = $product->price;
                        $product->price = $productPrice;
                    } else {
                        $productPrice = $product->price;
                        $product->price = $productPrice;
                    }

                    // if ($product->main_image) {
                    //     $product->main_image = env('APP_URL') . '/storage/product/' . $product->main_image;
                    // }
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
        //$perPage = $request->per_page;

        try {
            $conditions = [['status', '1'], ['admin_approved', '1'], ['part_type', 'New']];
            $products = Product::where($conditions)->orderBy('id', 'desc')->paginate($limit)->get();
            //$products = Product::where($conditions)->orderBy('id', 'desc')->take($limit)->get();

            if ($products->count() > 0) {
                foreach ($products as $product) {
                    $prodSubcategory = Subcategory::where('id', $product->subcategory->id)->first();
                    $product->main_image = $prodSubcategory->icon;

                    $vendorDiscountObj = VendorDiscount::where('vendor_id', $product->vendor_id)->first();
                    $discountType = @$vendorDiscountObj->type;
                    $discountValue = @$vendorDiscountObj->value;

                    if ($discountType == 'Topup') {
                        $topupAmount = $product->price * ($discountValue / 100);
                        $product->price = $product->price + $topupAmount;
                    } else if ($discountType == 'Discount') {
                        $productPrice = $product->price;
                        $product->price = $productPrice;
                    } else {
                        $productPrice = $product->price;
                        $product->price = $productPrice;
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

    public function productDetail($id)
    {
        try {
            $product = Product::find($id)->makeHidden(['make', 'model', 'year', 'engine', 'category', 'subcategory', 'brand', 'vendor']);

            $rate = VendorReview::where('vendor_id', $product->vendor_id)->sum('rating');
            $rate_count = VendorReview::where('vendor_id', $product->vendor_id)->count();
            if ($rate_count > 0) {
                $average_rating = floor($rate / $rate_count);
            } else {
                $average_rating = 0;
            }

            if ($product) {
                $prodSubcategory = Subcategory::where('id', $product->subcategory->id)->first();
                $product->main_image = $prodSubcategory->icon;

                // $product->main_image = env('APP_URL') . '/storage/product/' . $product->main_image;
                // $product->image_01 = env('APP_URL') . '/storage/product/' . $product->image_01;
                // $product->image_02 = env('APP_URL') . '/storage/product/' . $product->image_02;
                // $product->image_03 = env('APP_URL') . '/storage/product/' . $product->image_03;
                // $product->image_04 = env('APP_URL') . '/storage/product/' . $product->image_04;

                $vendorDiscountObj = VendorDiscount::where('vendor_id', $product->vendor_id)->first();
                $discountType = $vendorDiscountObj->type;
                $discountValue = $vendorDiscountObj->value;

                if ($discountType == 'Topup') {
                    $topupAmount = $product->price * ($discountValue / 100);
                    $product->price = $product->price + $topupAmount;
                } else if ($discountType == 'Discount') {
                    $productPrice = $product->price;
                    $product->price = $productPrice;
                } else {
                    $productPrice = $product->price;
                    $product->price = $productPrice;
                }

                $product->make_name = isset($product->make_id) ? $product->make->name : "";
                $product->model_name = isset($product->model_id) ? $product->model->name : "";
                $product->year_name = isset($product->year_id) ? $product->year->name : "";
                $product->engine_name = isset($product->engine_id) ? $product->engine->name : "";
                $product->brand_name = isset($product->brand_id) ? $product->brand->name : "";
                $product->category_type = $product->category->type;
                $product->category_name = isset($product->category_id) ? $product->category->name : "";
                $product->subcategory_name = isset($product->subcategory_id) ? $product->subcategory->name : "";
                $product->vendor_name = $product->vendor->business_name;
                $product->vendor_rating = getRatingStar($average_rating);
                $response['data'] = $product;
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
            $conditions = [['status', '1'], ['admin_approved', '1'], ['category_id', $category_id]];
            $products = Product::where($conditions)->orderBy('created_at', 'desc')->get();

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

    public function getMakes()
    {
        try {
            $makes = Make::where('status', 1)->orderBy('name', 'asc')->get();
            $response['data'] = $makes;
            $response['message'] = null;
            $response['errors'] = null;
            $response['status_code'] = 200;
            return response()->json($response, 200);
        } catch (\Exception $e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }

    public function getModels($make_id)
    {
        try {
            $models = Models::where([['status', 1], ['make_id', $make_id]])->orderBy('name', 'asc')->get();
            $response['data'] = $models;
            $response['message'] = false;
            $response['errors'] = false;
            $response['status_code'] = 200;
            return response()->json($response, 200);
        } catch (\Exception $e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }

    public function getYears()
    {
        try {
            $years = Year::where([
                ['status', 1]
            ])->orderBy('name', 'asc')->get();

            $response['data'] = $years;
            $response['message'] = false;
            $response['errors'] = false;
            $response['status_code'] = 200;
            return response()->json($response, 200);
        } catch (\Exception $e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }

    public function getCategories()
    {
        try {
            $categories = Category::where([['status', 1], ['type', 'default']])->orderBy('order', 'asc')->get();
            $response['data'] = $categories;
            $response['message'] = null;
            $response['errors'] = null;
            $response['status_code'] = 200;
            return response()->json($response, 200);
        } catch (\Exception $e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }

    public function getSubcategories($category_id)
    {
        try {
            $subcategories = Subcategory::where([['status', 1], ['category_id', $category_id]])->orderBy('order', 'asc')->get();
            $response['data'] = $subcategories;
            $response['message'] = null;
            $response['errors'] = null;
            $response['status_code'] = 200;
            return response()->json($response, 200);
        } catch (\Exception $e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }

    public function searchResult($request)
    {
        try {
            $conditions = array(
                'category_id' => $request['category_id'],
                'subcategory_id' => $request['subcategory_id'],
                'make_id' => $request['make_id'],
                'model_id' => $request['model_id'],
                'year_id' => $request['year_id'],
                'part_type' => 'Used',
                'status' => 1,
                'admin_approved' => 1
            );
            $products = Product::where($conditions)->orderBy('created_at', 'desc')->get();

            if ($products->count() > 0) {
                foreach ($products as $product) {
                    $prodSubcategory = Subcategory::where('id', $product->subcategory->id)->first();
                    $product->main_image = $prodSubcategory->icon;
                    // if ($product->main_image) {
                    //     $product->main_image = env('APP_URL') . '/storage/product/' . $product->main_image;
                    // }
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

    //     public function product($request)
//     {
//         try {
//             $conditions = array(
//                 'make_id' => $request['make_id'],
//                 'model_id' => $request['model_id'],
//                 'year_id' => $request['year_id'],
//                 'engine_id' => $request['engine_id'],
//                 'category_id' => $request['category_id'],
//                 'subcategory_id' => $request['subcategory_id'],
//                 'part_type' => $request['part_type'],
//                 'status' => 1,
//                 'admin_approved' => 1
//             );
//             $product_data = array();
//             $products = Product::where($conditions)->orderBy('created_at', 'desc')->get();
//             if ($products->count() > 0) {
//                 foreach ($products as $product) {
//                     //                    $matches = array();
// //                    if (count($product->matches) > 0) {
// //                        foreach ($product->matches as $match) {
// //                            array_push($matches, array('id' => $match->id, 'name' => $match->make->name . ' / ' . $match->model->name . ' / ' . $match->year->name . ' / ' . $match->engine->name));
// //                        }
// //                    }
//                     $reviews = array();
//                     $rating = 0;
//                     if (count($product->reviews) > 0) {
//                         $total_rating = 0;
//                         foreach ($product->reviews as $review) {
//                             array_push($reviews, array('id' => $review->id, 'name' => $review->name, 'reviews' => $review->reviews, 'rating' => $review->rating));
//                             $total_rating = $total_rating + $review->rating;
//                         }
//                         $rating = round(($total_rating / count($product->reviews)), 0);

    //                     }
//                     $product_data[] = [
//                         'id' => $product->id,
//                         'main_image' => env('APP_URL') . '/storage/product/' . $product->main_image,
//                         'image_01' => env('APP_URL') . '/storage/product/' . $product->image_01,
//                         'image_02' => env('APP_URL') . '/storage/product/' . $product->image_02,
//                         'image_03' => env('APP_URL') . '/storage/product/' . $product->image_03,
//                         'image_04' => env('APP_URL') . '/storage/product/' . $product->image_04,
//                         'title' => $product->title,
//                         'part_number' => $product->part_number,
//                         'sku' => $product->sku,
//                         'make' => $product->make->name,
//                         'model' => '',
//                         'year' => $product->year->name,
//                         'engine' => $product->engine->name,
//                         'manufacturer' => $product->manufacturer,
//                         'origin' => $product->origin,
//                         'brand' => $product->brand->name,
//                         'part_type' => $product->part_type,
//                         'market' => $product->market,
//                         'warranty' => $product->warranty,
//                         'category' => $product->category->name,
//                         'subcategory' => $product->subcategory->name,
//                         'price' => $product->price,
//                         'discount' => $product->discount,
//                         'stock' => $product->stock,
//                         'weight' => $product->weight,
//                         'height' => $product->height,
//                         'width' => $product->width,
//                         'length' => $product->length,
//                         //                        'matches' => $matches,
//                         'reviews' => $reviews
//                     ];

    //                 }
//             }
//             $response['data'] = $product_data;
//             $response['message'] = null;
//             $response['errors'] = null;
//             $response['status_code'] = 200;
//             return response()->json($response, 200);
//         } catch (\Exception $e) {
//             return response()->json(['errors' => $e->getMessage()], 400);
//         }
//     }

}