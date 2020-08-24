<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\TransactionService;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    protected $transactionService;

    public function __construct(TransactionService $transactionService)
    {
        $this->transactionService = $transactionService;
    }

    public function transaction(Request $request)
    {
        $result = $this->transactionService->register($request->all());

        if(array_get($result, "success")){
            return response($result, 200);
        }

        return response($result, 406);
    }

}