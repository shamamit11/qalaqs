<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AuctionRequest;
use App\Services\Admin\AuctionService;
use Illuminate\Http\Request;
use App\Models\Auction;

class AuctionController extends Controller
{
    protected $auction;

    public function __construct(AuctionService $AuctionService)
    {
        $this->auction = $AuctionService;
    }

    public function index(Request $request)
    {
        $user_type = checkIfUserIsStandardUser();
        if($user_type) {
            return redirect()->route('admin-dashboard');
        }

        $nav = 'auction';
        $sub_nav = '';
        $per_page = 100;
        $page = ($request->has('page') && !empty($request->page)) ? $request->page : 1;
        $q = ($request->has('q') && !empty($request->q)) ? $request->q : '';
        $page_title = 'Garages';
        $result = $this->auction->list($per_page, $page, $q);
        return view('admin.auction.index', compact('nav', 'sub_nav', 'page_title'), $result);
    }

    public function status(Request $request)
    {
        $this->auction->status($request);
    }

    public function addEdit(Request $request)
    {
        $user_type = checkIfUserIsStandardUser();
        if($user_type) {
            return redirect()->route('admin-dashboard');
        }

        $nav = 'auction';
        $sub_nav = '';
        $id = ($request->id) ? $request->id : 0;
        $data['title'] = $page_title = ($id == 0) ? "Add Auction" : "Edit Auction";
        $data['action'] = route('admin-auction-addaction');
        $data['row'] = Auction::where('id', $id)->first();
        return view('admin.auction.add', compact('nav', 'sub_nav', 'page_title'), $data);
    }

    public function addAction(AuctionRequest $request)
    {
        return $this->auction->store($request->validated());
    }

    public function delete(Request $request)
    {
        echo $this->auction->delete($request);
    }
}
