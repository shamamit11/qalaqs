<?php
namespace App\Services\Api\Vendor;

use App\Models\Category;
use App\Models\Engine;
use App\Models\Make;
use App\Models\Models;
use App\Models\SubCategory;
use App\Models\Year;
use App\Models\Product;
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

    public function listProducts() {
        try {
            $product_data = array();
            $vendor_id = Auth::guard('vendor-api')->user()->id;
            $products = Product::where('vendor_id', $vendor_id)->orderBy('id', 'asc')->get();
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
                    array_push($product_data, $product);
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
            $product->brand_id = $request['brand_id'];
            $product->part_type = $request['part_type'];
            $product->market = $request['market'];
            $product->warranty = $request['warranty'];
            $product->category_id = $request['category_id'];
            $product->subcategory_id = $request['subcategory_id'];
            $product->price = $request['price'];
            $product->discount = $request['discount'];
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

    // function list($per_page, $page, $q) {
    //     try {
    //         $supplier_id = Auth::guard('supplier')->id();
    //         $data['q'] = $q;
    //         $query = Product::select('*')->with('specifications')->with('images')->with('matches')->with('make')->with('model')->with('year')->where('supplier_id', $supplier_id);
    //         if ($q) {
    //             $search_key = $q;
    //             $query->where(function ($qry) use ($search_key) {
    //                 $qry->where('name', 'LIKE', '%' . $search_key . '%');
    //                 $qry->orWhereHas('make', function ($qry1) use ($search_key) {
    //                     $qry1->where('name', 'LIKE', '%' . $search_key . '%');
    //                 });
    //                 $qry->orWhereHas('model', function ($qry2) use ($search_key) {
    //                     $qry2->where('name', 'LIKE', '%' . $search_key . '%');
    //                 });
    //                 $qry->orWhereHas('year', function ($qry3) use ($search_key) {
    //                     $qry3->where('name', 'LIKE', '%' . $search_key . '%');
    //                 });
    //             });
    //         }
    //         $data['products'] = $query->orderBy('product_make_id', 'asc')->orderBy('product_model_id', 'asc')->orderBy('product_year_id', 'asc')->orderBy('id', 'desc')->paginate($per_page);
    //         $data['products']->appends(array('q' => $q));
    //         if ($page != 1) {
    //             $data['total_data'] = $data['products']->total();
    //             $data['count'] = ($per_page * $page) - $per_page + 1;
    //             $data['from_data'] = $data['count'];
    //             $to_data = $page * $data['products']->count();
    //             $data['to_data'] = ($to_data > $data['from_data']) ? $to_data : $data['total_data'];
    //         } else {
    //             $data['total_data'] = $data['products']->total();
    //             $data['count'] = 1;
    //             $data['from_data'] = 1;
    //             $data['to_data'] = $data['products']->count();
    //         }
    //         return $data;
    //     } catch (\Exception$e) {
    //         return response()->json(['errors' => $e->getMessage()], 400);
    //     }
    // }

    // public function status($request)
    // {
    //     try {
    //         Product::where('id', $request->id)
    //             ->update([
    //                 $request->field_name => $request->val,
    //             ]);
    //     } catch (\Exception$e) {
    //         return response()->json(['errors' => $e->getMessage()], 400);
    //     }
    // }

    // public function store($request)
    // {
    //     try {
    //         if ($request['id']) {
    //             $id = $request['id'];
    //             $product = Product::findOrFail($id);
    //             $message = "Data updated";
    //         } else {
    //             $id = 0;
    //             $product = new Product;
    //             $message = "Data added";
    //         }
    //         $folder = ($request['folder']) ? $request['folder'] : getSlug("products", "folder", $request['name'], $id);
    //         $directory = 'product/' . $folder;
    //         if ($id == 0) {
    //             Storage::disk('public')->makeDirectory($directory);
    //         }
    //         $product->supplier_id = Auth::guard('supplier')->id();
    //         $product->sku = $request['sku'];
    //         $product->part_type = $request['part_type'];
    //         $product->part_number = $request['part_number'];
    //         $product->manufacturer = $request['manufacturer'];
    //         $product->product_type = $request['product_type'];
    //         $product->name = $request['name'];
    //         $product->folder = $folder;
    //         $product->product_category_id = $request['category_id'];
    //         $product->product_sub_category_id = $request['subcategory_id'];
    //         $product->product_brand_id = $request['brand_id'];
    //         $product->product_make_id = $request['make_id'];
    //         $product->product_model_id = $request['model_id'];
    //         $product->product_year_id = $request['year_id'];
    //         $product->product_engine_id = $request['engine_id'];
    //         $product->warranty = $request['warranty'];
    //         $product->stock = $request['stock'];
    //         $product->price = $request['price'];
    //         $product->status = isset($request['status']) ? 1 : 0;
    //         $product->save();
    //         $response['message'] = $message;
    //         $response['errors'] = false;
    //         $response['status_code'] = 201;
    //         return response()->json($response, 201);
    //     } catch (\Exception$e) {
    //         return response()->json(['errors' => $e->getMessage()], 400);
    //     }
    // }

    // public function addSpecification($request)
    // {
    //     try {
    //         foreach ($request['specification_id'] as $key => $specification_id) {
    //             if ($request['specification_name'][$key] && $request['specification_value'][$key]) {
    //                 if ($specification_id > 0) {
    //                     $specification = ProductSpecification::where('id', $specification_id)->first();
    //                 } else {
    //                     $specification = new ProductSpecification;
    //                 }
    //                 $specification->product_id = $request['product_id'];
    //                 $specification->specification_name = $request['specification_name'][$key];
    //                 $specification->specification_value = $request['specification_value'][$key];
    //                 $specification->save();
    //             }
    //         }
    //         $response['message'] = 'Specification added.';
    //         $response['errors'] = false;
    //         $response['status_code'] = 201;
    //         return response()->json($response, 201);
    //     } catch (\Exception$e) {
    //         return response()->json(['errors' => $e->getMessage()], 400);
    //     }
    // }

    // public function deleteSpecification($request)
    // {
    //     try {
    //         $id = $request->specification_id;
    //         ProductSpecification::where('id', $id)->delete();
    //         return "success";
    //     } catch (\Exception$e) {
    //         return response()->json(['errors' => $e->getMessage()], 400);
    //     }
    // }

    // public function addMatch($request)
    // {
    //     try {
    //         foreach ($request['match_id'] as $key => $match_id) {
    //             $engine_id = $request['engine_id'][$key];
    //             $engine = ProductEngine::where('id', $engine_id)->first();
    //             if ($engine) {
    //                 if ($match_id > 0) {
    //                     $match = ProductMatch::where('id', $match_id)->first();
    //                 } else {
    //                     $match = new ProductMatch;
    //                 }
    //                 $match->product_id = $request['product_id'];
    //                 $match->product_make_id = $engine->product_make_id;
    //                 $match->product_model_id = $engine->product_model_id;
    //                 $match->product_year_id = $engine->product_year_id;
    //                 $match->product_engine_id = $engine_id;
    //                 $match->save();
    //             }
    //         }
    //         $response['message'] = 'Matches added.';
    //         $response['errors'] = false;
    //         $response['status_code'] = 201;
    //         return response()->json($response, 201);
    //     } catch (\Exception$e) {
    //         return response()->json(['errors' => $e->getMessage()], 400);
    //     }
    // }

    // public function deleteMatch($request)
    // {
    //     try {
    //         $id = $request->match_id;
    //         ProductMatch::where('id', $id)->delete();
    //         return "success";
    //     } catch (\Exception$e) {
    //         return response()->json(['errors' => $e->getMessage()], 400);
    //     }
    // }

    // public function delete($request)
    // {
    //     try {
    //         $supplier_id = Auth::guard('supplier')->id();
    //         $id = $request->id;
    //         $product = Product::where('id', $id)->where('supplier_id', $supplier_id)->first();
    //         if ($product) {
    //             Storage::disk('public')->deleteDirectory('product/' . $product->folder);
    //             Product::where('id', $id)->where('supplier_id', $supplier_id)->delete();
    //             return "success";
    //         } else {
    //             return "fail";
    //         }
    //     } catch (\Exception$e) {
    //         return response()->json(['errors' => $e->getMessage()], 400);
    //     }
    // }

    // public function saveImage($request)
    // {
    //     try {
    //         $product_id = $request['product_id'];
    //         $product = Product::with('image')->where('id', $product_id)->first();
    //         $is_primary = (count($product->image) > 0) ? 0 : 1;
    //         if (preg_match('#^data:image.*?base64,#', $request['image'])) {
    //             $image = $this->StoreBase64Image($request['image'], '/product/' . $product->folder . '/');
    //         } else {
    //             $image = '';
    //         }
    //         $product_image = new ProductImage;
    //         $product_image->product_id = $product_id;
    //         $product_image->is_primary = $is_primary;
    //         $product_image->image = $image;
    //         $product_image->order = getMax('product_images', 'order');
    //         $product_image->save();
    //         $response['message'] = 'Image added.';
    //         $response['errors'] = false;
    //         $response['status_code'] = 201;
    //         return response()->json($response, 201);
    //     } catch (\Exception$e) {
    //         return response()->json(['errors' => $e->getMessage()], 400);
    //     }
    // }

    // public function orderImage($request)
    // {
    //     try {
    //         $cnt = 1;
    //         foreach ($request['id'] as $id) {
    //             ProductImage::where('id', $id)
    //                 ->update([
    //                     'order' => $cnt,
    //                 ]);
    //             $cnt++;
    //         }
    //         $response['message'] = 'Order updated.';
    //         $response['errors'] = false;
    //         $response['status_code'] = 201;
    //         return response()->json($response, 201);
    //     } catch (\Exception$e) {
    //         return response()->json(['errors' => $e->getMessage()], 400);
    //     }
    // }

    // public function imageStatus($request)
    // {
    //     try {
    //         if ($request->val == 1) {
    //             ProductImage::where('product_id', $request->product_id)
    //                 ->update(['is_primary' => 0]);
    //             ProductImage::where('id', $request->id)
    //                 ->update(['is_primary' => 1]);
    //         } else {
    //             $product_image = ProductImage::where('id', $request->id)->first();
    //             if ($product_image->is_primary == 1) {
    //                 ProductImage::where('product_id', $request->product_id)
    //                     ->update(['is_primary' => 0]);
    //                 $product_images = ProductImage::where('product_id', $request->product_id)->where('id', '<>', $request->id)->first();
    //                 ProductImage::where('id', $product_images->id)
    //                     ->update(['is_primary' => 1]);
    //             } else {
    //                 ProductImage::where('id', $request->id)
    //                     ->update(['is_primary' => 0]);
    //             }
    //         }

    //     } catch (\Exception$e) {
    //         return response()->json(['errors' => $e->getMessage()], 400);
    //     }
    // }

    // public function imageDelete($request)
    // {
    //     try {
    //         $id = $request->id;
    //         $ras = ProductImage::with('product')->where('id', $id)->first();
    //         if ($ras->is_primary == 1) {
    //             $product_images = ProductImage::where('product_id', $ras->product_id)->where('id', '<>', $id)->first();
    //             ProductImage::where('id', $product_images->id)
    //                 ->update(['is_primary' => 1]);
    //         }
    //         Storage::disk('public')->delete('/product/' . $ras->product->folder . '/' . $ras->image);
    //         ProductImage::where('id', $id)->delete();
    //         return "success";
    //     } catch (\Exception$e) {
    //         return response()->json(['errors' => $e->getMessage()], 401);
    //     }
    // }
}
