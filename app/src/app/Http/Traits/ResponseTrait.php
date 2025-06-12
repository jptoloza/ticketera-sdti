<?php

namespace App\Http\Traits;

use Illuminate\Http\Request;

trait ResponseTrait
{
    /**
     * @param Request $request
     * @return $this|false|string
     */
    public function responseErrorValidattion(Request $request, $requestErrors = [])
    {
        $errors = [];
        foreach ($requestErrors as $error) {
            foreach ($error as $value) {
                $errors[] = $value;
            }
        }
        $message = implode("<br />", $errors);
        return response()->json([
            'success' => 'error',
            'message' => $message,
            'data' => $requestErrors
        ], 422);
    }
}
