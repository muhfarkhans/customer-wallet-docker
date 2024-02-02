<?php

namespace App\Http\Controllers\Api;

use App\Models\Transaction;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;

class TransactionController extends Controller
{
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "order_id" => 'required',
            "amount" => 'required',
            "timestamp" => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $randomNumber = random_int(1, 9);
        $status = 1;

        if ($randomNumber % 2 == 0) {
            $status = 0;
        }

        return response()->json([
            'order_id' => $request->order_id,
            'amount' => $request->amount,
            'status' => $status
        ]);
    }
}
