<?php

namespace App\Http\Controllers\Api\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\Quote\QuoteRequest;
use App\Services\Api\User\QuoteService;
use Illuminate\Http\Request;

class QuoteController extends Controller
{
    protected $quote;

    public function __construct(QuoteService $QuoteService)
    {
        $this->quote = $QuoteService;
    }

    public function createQuote(QuoteRequest $request) {
        return $this->quote->create($request);
    }

    public function list() {
        return $this->quote->list();
    }

    public function getQuoteDetails($quote_id) {
        return $this->quote->getQuoteDetails($quote_id);
    }
}
