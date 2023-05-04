<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BannerRequest;
use App\Services\Admin\BannerService;
use Illuminate\Http\Request;

use App\Models\Banner;

class BannerController extends Controller
{
    protected $banner;

    public function __construct(BannerService $BannerService)
    {
        $this->banner = $BannerService;
    }

    public function index(Request $request)
    {
        $user_type = checkIfUserIsStandardUser();
        if($user_type) {
            return redirect()->route('admin-dashboard');
        }

        $nav = 'banner';
        $sub_nav = '';
        $per_page = 100;
        $page = ($request->has('page') && !empty($request->page)) ? $request->page : 1;
        $q = ($request->has('q') && !empty($request->q)) ? $request->q : '';
        $page_title = ' Banner';
        $result = $this->banner->list($per_page, $page, $q);
        return view('admin.banner.index', compact('nav', 'sub_nav', 'page_title'), $result);
    }

    public function status(Request $request)
    {
        $this->banner->status($request);
    }

    public function addEdit(Request $request)
    {
        $user_type = checkIfUserIsStandardUser();
        if($user_type) {
            return redirect()->route('admin-dashboard');
        }

        $nav = 'banner';
        $sub_nav = '';
        $id = ($request->id) ? $request->id : 0;
        $data['title'] = $page_title = ($id == 0) ? "Add Banner" : "Edit Banner";
        $data['action'] = route('admin-banner-addaction');
        $data['order'] = getMax('banners', 'order');
        $data['row'] = Banner::where('id', $id)->first();
        return view('admin.banner.add', compact('nav', 'sub_nav', 'page_title'), $data);
    }

    public function addAction(BannerRequest $request)
    {
        return $this->banner->store($request->validated());
    }

    public function delete(Request $request)
    {
        echo $this->banner->delete($request);
    }
    
    public function imageDelete(Request $request)
    {
        echo $this->banner->imageDelete($request);
    }
}
