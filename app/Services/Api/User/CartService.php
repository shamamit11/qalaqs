<?php
namespace App\Services\Api\User;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\Promocode;
use App\Models\Tax;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CartService
{ 
    public function listCart($cart_session_id) {
        try {
            $user_id = Auth::guard('user-api')->id();
            $cart_data = Cart::where([['user_id', $user_id], ['session_id', $cart_session_id]])->first(['id', 'session_id', 'item_count', 'promo_code', 'sub_total']);
            if($cart_data) {
                $cart = [];

                $cart_items = DB::table('cart_items')
                    ->leftJoin('products', 'products.id', '=', 'cart_items.product_id')
                    ->select('cart_items.id as cart_item_id', 'cart_items.cart_session_id','cart_items.product_id', 'cart_items.item_count as qty', 'cart_items.sub_total', 'products.part_type', 'products.market', 'products.title', 'products.main_image')
                    ->where('cart_items.cart_session_id', $cart_session_id)
                    ->get();
                
                if(count($cart_items) > 0) {
                    foreach($cart_items as $item) {
                        if($item->main_image) {
                            $item->main_image = env('APP_URL').'/storage/product/'.$item->main_image;
                        }
                    }
                    $cart['cart'] = $cart_data;
                    $cart['cart_items'] = $cart_items;
                }
                $response['data'] = $cart;
                $response['message'] = null;
                $response['errors'] = null;
                $response['status_code'] = 200;
                return response()->json($response, 200);
            }
            else {
                $response['message'] = 'Cart is Empty !!';
                $response['errors'] = null;
                $response['status_code'] = 200;
                return response()->json($response, 200);
            }
        } catch (\Exception$e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }

    public function addItem($request) {
        try {
            $cart_session_id =  $request['cart_session_id'];
            $product_id =  $request['product_id'];
            $item_count =  $request['item_count'];

            $user_id = Auth::guard('user-api')->id();

            $cart = Cart::where([['user_id', $user_id], ['session_id', $cart_session_id]])->first();

            if(!$cart) {
                $cartData = new Cart;
                $cartData->session_id = $cart_session_id;
                $cartData->user_id = $user_id;
                $cartData->save();
            }

            $cartItem = CartItem::where([['cart_session_id', $cart_session_id], ['product_id', $product_id]])->first();

            if(!$cartItem) {
                $cartItem = new CartItem;
                $cartItem->cart_session_id = $cart_session_id;
                $cartItem->product_id = $product_id;
            }

            $cartItem->item_count = $item_count;

            $productData = Product::where('id', $product_id)->first();
            $prod_price = $productData->price;
            $prod_discount = $productData->discount ? $productData->discount : 0;
            $vendor_id = $productData->vendor_id;

            if($prod_discount > 0) {
                $sub_total = ($prod_price - ($prod_price * $prod_discount / 100)) * $item_count;
            } else {
                $sub_total = $prod_price * $item_count;
            }
            
            $cartItem->sub_total = $sub_total;

            $cartItem->vendor_id = $vendor_id;
            $cartItem->save();

            //update cart table
            $allItems = CartItem::where('cart_session_id', $cart_session_id)->get();

            $cart_item_count = 0;
            $promo_code = '';
            $promo_type = '';
            $promo_value = 0.00;
            $cart_sub_total = 0.00;

            foreach($allItems as $item) {
                $cart_item_count = $cart_item_count + $item->item_count;
                $cart_sub_total = $cart_sub_total + $item->sub_total;
            }

            $cartFinalData = Cart::where([['user_id', $user_id], ['session_id', $cart_session_id]])->first();
            $cartFinalData->item_count = $cart_item_count;
            $cartFinalData->promo_code = $promo_code;
            $cartFinalData->promo_type = $promo_type;
            $cartFinalData->promo_value = $promo_value;
            $cartFinalData->sub_total = $cart_sub_total;
            $cartFinalData->save();

            $response['message'] = "success";
            $response['errors'] = null;
            $response['status_code'] = 200;
            return response()->json($response, 200);
            
        } catch (\Exception$e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }

    public function updateQty($request) {
        try {
            $cart_session_id = $request['cart_session_id'];
            $product_id = $request['product_id'];
            $item_count = $request['item_count'];

            $user_id = Auth::guard('user-api')->id();
            
            $cartItem = CartItem::where([['cart_session_id', $cart_session_id], ['product_id', $product_id]])->first();
            $cartItem->item_count = $item_count;

            $productData = Product::where('id', $product_id)->first();
            $prod_price = $productData->price;
            $prod_discount = $productData->discount ? $productData->discount : 0;

            if($prod_discount > 0) {
                $sub_total = ($prod_price - ($prod_price * $prod_discount / 100)) * $item_count;
            } else {
                $sub_total = $prod_price * $item_count;
            }

            $cartItem->sub_total = $sub_total;

            $cartItem->save();

            //update cart table
            $allItems = CartItem::where('cart_session_id', $cart_session_id)->get();

            $cart_item_count = 0;
            $promo_code = '';
            $promo_type = '';
            $promo_value = 0.00;
            $cart_sub_total = 0.00;

            foreach($allItems as $item) {
                $cart_item_count = $cart_item_count + $item->item_count;
                $cart_sub_total = $cart_sub_total + $item->sub_total;
            }

            $cartData = Cart::where([['user_id', $user_id], ['session_id', $cart_session_id]])->first();
            $cartData->item_count = $cart_item_count;
            $cartData->promo_code = $promo_code;
            $cartData->promo_type = $promo_type;
            $cartData->promo_value = $promo_value;
            $cartData->sub_total = $cart_sub_total;
            $cartData->save();

            $response['message'] = "success";
            $response['errors'] = null;
            $response['status_code'] = 200;
            return response()->json($response, 200);

        } catch (\Exception$e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }

    public function deleteItem($request) {
        try {
            $cart_session_id = $request['cart_session_id'];
            $product_id = $request['product_id'];

            $user_id = Auth::guard('user-api')->id();

            CartItem::where([['product_id', $product_id], ['cart_session_id', $cart_session_id]])->delete();

            //update cart table
            $allItems = CartItem::where('cart_session_id', $cart_session_id)->get();

            $cart_item_count = 0;
            $promo_code = '';
            $promo_type = '';
            $promo_value = 0.00;
            $cart_sub_total = 0.00;

            foreach($allItems as $item) {
                $cart_item_count = $cart_item_count + $item->item_count;
                $cart_sub_total = $cart_sub_total + $item->sub_total;
            }

            $cartData = Cart::where([['user_id', $user_id], ['session_id', $cart_session_id]])->first();
            $cartData->item_count = $cart_item_count;
            $cartData->promo_code = $promo_code;
            $cartData->promo_type = $promo_type;
            $cartData->promo_value = $promo_value;
            $cartData->sub_total = $cart_sub_total;
            $cartData->save();
            
            $countItems = CartItem::where('cart_session_id', $cart_session_id)->get();
            if(count($countItems) == 0 || $countItems == "") {
                Cart::where([['user_id', $user_id], ['session_id', $cart_session_id]])->delete(); 
            }

            $response['message'] = "success";
            $response['errors'] = null;
            $response['status_code'] = 200;
            return response()->json($response, 200);

        } catch (\Exception$e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }

    public function itemCount($cart_session_id) {
        try {
            $user_id = Auth::guard('user-api')->id();
            $cart_data = Cart::where([['user_id', $user_id], ['session_id', $cart_session_id]])->first(['item_count']);
            if($cart_data) {
                $items = $cart_data->item_count;
            } else {
                $items = 0; 
            }
            $response['items'] = $items;
            $response['errors'] = null;
            $response['status_code'] = 200;
            return response()->json($response, 200);
        } catch (\Exception$e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }

    public function applyPromocode($request) {
        try {
            $code = $request['code'];
            $cart_session_id = $request['cart_session_id'];
            $promoData = Promocode::where('code', $code)->first();

            if($promoData) {
                $user_id = Auth::guard('user-api')->id();
                $usage = DB::table('promocode_users')->where([['user_id', $user_id], ['promocode_id', $promoData->id]])->first();

                if($usage) {
                    $client_usuage = $usage->num_of_usuage;
                } else {
                    $client_usuage = 0; 
                }
                
                $max_num_per_user = $promoData->max_num_per_user;

                if($client_usuage < $max_num_per_user) {
                    $cart = Cart::where([['user_id', $user_id], ['session_id', $cart_session_id]])->first();
                    $cart->promo_code = $code;
                    $cart->promo_type = $promoData->discount_type;
                    $cart->promo_value = $promoData->value;
                    $cart->save();

                    if($usage) {
                        $usage->num_of_usuage = $client_usuage + 1;
                        $usage->save();
                    } 
                    else {
                        DB::table('promocode_users')->insert([
                            'promocode_id' => $promoData->id,
                            'user_id' => $user_id,
                            'num_of_usuage' => $client_usuage + 1
                        ]);
                    }

                    $response['message'] = 'Promotion Applied !';
                    $response['errors'] = false;
                    $response['status_code'] = 200;
                    return response()->json($response, 200);
                } 
                else {
                    $response['message'] = 'Maximum Number of Usuage Reached !';
                    $response['errors'] = true;
                    $response['status_code'] = 401;
                    return response()->json($response, 401);
                }
            } 
            else {
                $response['message'] = 'Promocode is Wrong or Expired !';
                $response['errors'] = true;
                $response['status_code'] = 400;
                return response()->json($response, 400);
            }
        } catch (\Exception$e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }

    public function cartSummary($cart_session_id) {
        try {
            $user_id = Auth::guard('user-api')->id();
            $cartData = Cart::where([['user_id', $user_id], ['session_id', $cart_session_id]])->first();

            if($cartData) {
                $item_count = $cartData->item_count;
                $promo_type = $cartData->promo_type;
                $promo_value = $cartData->promo_value;
                $sub_total = $cartData->sub_total;
    
                $promo_discount = 0.00;
                
                if($promo_type) {
                    switch($promo_type) {
                        case 'P':
                            $promo_discount = $sub_total * $promo_value / 100;
                            break;
                        case 'A':
                            $promo_discount = $sub_total - $promo_value;
                            break;
                        default:
                            $promo_discount = 0.00;
                    }
                }
    
                $tax = Tax::findOrFail(1);
                $tax_amount = $sub_total * $tax->percentage / 100;
               
                //calculate shipping
                if($sub_total >= 500) {
                    $shipping_charge = 5.00;
                }
                else if($sub_total >= 200) {
                    $shipping_charge = 10.00;
                }
                else {
                    $shipping_charge = 15.00;
                }
    
                $grand_total = $sub_total - $promo_discount + $tax_amount + $shipping_charge;
    
                $summary = [];
                $summary['cart_session_id'] = $cart_session_id;
                $summary['total_items'] = $item_count;
                $summary['sub_total'] = $sub_total;
                $summary['promo_discount'] = $promo_discount;
                $summary['tax_name'] = $tax->name;
                $summary['tax_percent'] = $tax->percentage;
                $summary['tax_amount'] = $tax_amount;
                $summary['shipping_charge'] = $shipping_charge;
                $summary['grand_total'] = $grand_total;
    
                $response['data'] = $summary;
                $response['errors'] = false;
                $response['status_code'] = 200;
                return response()->json($response, 200);
            } 
            else {
                $response['message'] = 'Empty Cart';
                $response['errors'] = true;
                $response['status_code'] = 400;
                return response()->json($response, 400);
            }
            
        } catch (\Exception$e) {
            return response()->json(['errors' => $e->getMessage()], 400);
        }
    }
}