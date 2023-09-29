<?php

namespace App\Http\Controllers\Api\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\Quote\TempQuoteItemRequest;
use App\Services\Api\User\TempQuoteItemService;

use Illuminate\Http\Request;

class TempQuoteItemController extends Controller
{
    protected $quoteItem;

    public function __construct(TempQuoteItemService $TempQuoteItemService)
    {
        $this->quoteItem = $TempQuoteItemService;
    }

    public function list($quote_session_id) {
        return $this->quoteItem->list($quote_session_id);
    }

    public function addItem(TempQuoteItemRequest $request) {
        return $this->quoteItem->addItem($request);
    }

    public function deleteItem(Request $request) {
        return $this->quoteItem->deleteItem($request);
    }
}
