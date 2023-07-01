<?php

namespace App\Http\Responses;
use Exception;
use Illuminate\Contracts\Support\Responsable;

class FailResponse implements Responsable
{
    /**
     * @var Exception
     */
    protected $exception;

    /**
     * @param Exception $exception
     */
    public function __construct(Exception $exception)
    {
        $this->exception = $exception;
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function toResponse($request)
    {
        return response()->json([
            'success' => false,
            'errors'  => [],
            'message' => $this->exception->getMessage() ?? "An exception occurred"
        ]);
    }
}
