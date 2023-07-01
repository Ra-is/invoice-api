<?php

namespace App\Http\Responses;
use Illuminate\Contracts\Support\Responsable;

class ErrorResponse implements Responsable
{
    /**
     * @var string|null
     */
    protected $message;

    /**
     * @param string|null $message
     */
    public function __construct(string $message = null)
    {
        $this->message = !empty($message) ? $message : 'Sorry, we can not submit your request';
    }

    public function toResponse($request)
    {
        return response()->json([
            'success' => false,
            'errors'  => [],
            'message' => $this->message
        ],500);
    }
}

