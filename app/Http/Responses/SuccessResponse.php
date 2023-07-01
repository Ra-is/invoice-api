<?php

namespace App\Http\Responses;

class SuccessResponse extends FormSubmitSuccess
{
    public function toResponse($request)
    {
        return response()->json(
            [
                'success'        => true,
                'data' => $request->data,
                'message'=> $request->message ?? 'No Message Set'
            ],
            200
        );
    }

}

