<?php

namespace App\Traits;

use Illuminate\Http\Response;

trait ResponseWithHttp
{
    public function success($message,$data = null, $status = Response::HTTP_ACCEPTED)
    {
        return response()->json([
            "success" => true,
            "message" => $message,
            "status" => $status,
            "data" => $data
        ]);
    }
    public function failure($message, $status = Response::HTTP_UNAUTHORIZED)
    {
        return response()->json([
            "success" => false,
            "message" => $message,
            "status" => $status
        ]);
    }
}
