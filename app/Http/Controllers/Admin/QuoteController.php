<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Quote;
use App\Models\QuoteItem;
use App\Services\Admin\QuoteService;
use Illuminate\Http\Request;

class QuoteController extends Controller
{
    protected $quote;

    public function __construct(QuoteService $QuoteService)
    {
        $this->quote = $QuoteService;
    }

    public function index(Request $request)
    {
        $nav = 'quote';
        $sub_nav = '';
        $per_page = 100;
        $page = ($request->has('page') && !empty($request->page)) ? $request->page : 1;
        $q = ($request->has('q') && !empty($request->q)) ? $request->q : '';
        $page_title = 'Quotes';
        $result = $this->quote->list($per_page, $page, $q);
        return view('admin.quote.index', compact('nav', 'sub_nav', 'page_title'), $result);
    }

    public function view(Request $request)
    {
        $nav = 'quote';
        $sub_nav = '';
        $id = ($request->id) ? $request->id : 0;
        $data['title'] = $page_title =($id == 0) ? "View Quote" : "View Quote";
        $data['row'] = $quote = Quote::where('id', $id)->first();
        $data['items'] = QuoteItem::where('quote_session_id', $quote->quote_id)->get();
        return view('admin.quote.view', compact('nav', 'sub_nav', 'page_title'), $data);
    }

    public function update(Request $request) {
        return $this->quote->update($request);
    }
}
