<?php
use App\Models\Product;
use Illuminate\Support\Facades\DB;

if (!function_exists('time_elapsed_string')) {
    function time_elapsed_string($datetime, $full = false)
    {
        $now = new DateTime;
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);
        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;
        $string = array(
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'minute',
            's' => 'second',
        );
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
            } else {
                unset($string[$k]);
            }
        }
        if (!$full) {
            $string = array_slice($string, 0, 1);
        }
        return $string ? implode(', ', $string) . ' ago' : 'just now';
    }
}

if (!function_exists('youtube')) {
    function youtube($video)
    {
        $pattern = '#^(?:https?://)?(?:www\.)?(?:youtu\.be/|youtube\.com(?:/embed/|/v/|/watch\?v=|/watch\?.+&v=))([\w-]{11})(?:.+)?$#x';
        preg_match($pattern, $video, $matches);
        return (isset($matches[1])) ? $matches[1] : '';
    }
}

if (!function_exists('getMax')) {
    function getMax($table_name, $field_name)
    {
        return DB::table($table_name)->max($field_name) + 1;
    }
}

if (!function_exists('getSlug')) {
    function getSlug($table_name, $field_name, $title, $id = 0, $id_name = 'id')
    {
        $slug_name = Str::slug($title);
        $slug_name = ($slug_name) ? $slug_name : time();
        $ras = DB::table($table_name)->where($id_name, '<>', $id)->where($field_name, $slug_name)->first();
        $slug = ($ras) ? $slug_name . "-" . time() : $slug_name;
        return $slug;
    }
}

if (!function_exists('generateOrderID')) {
    function generateOrderID()
    {
        $date = date_create();
        $order_id = "QLS-".date_timestamp_get($date);
        return $order_id;
    }
}

function getRatingStar($num) {
    switch($num) {
        case 1:
            $star = "★☆☆☆☆";
            break;
        case 2:
            $star = "★★☆☆☆";
            break;
        case 3:
            $star = "★★★☆☆";
            break;
        case 4:
            $star = "★★★★☆";
            break;
        case 5:
            $star = "★★★★★";
            break;
        default:
            $star = "☆☆☆☆☆";
    }
    return $star;
}

function getNewProductsCount() {
    $products = Product::where('admin_approved', 0)->count();
    return $products;
}