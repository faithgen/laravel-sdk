<?php


namespace FaithGen\SDK\Traits;


trait APIResponses
{
    function successResponse($message, array $data = [])
    {
        return response()->json(array_merge([
            'success' => true,
            'message' => $message
        ], $data));
    }
}
