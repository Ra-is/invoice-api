<?php

namespace App\Http\Responses;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Request;

class FormSubmitSuccess implements Responsable
{
    /** @var Request */
    protected $request;

    /** @var string|null */
    protected $message;

    /**
     * ValuationSendError constructor.
     * @param Request $request
     * @param string|null $message
     */
    public function __construct(Request $request, string $message = null)
    {
        $this->request = $request;
        $this->message = $message;
    }

    public function toResponse($request)
    {
        return redirect()->back()->with([
            'success' => $this->getMessage(),
        ]);
    }

    public function getMessage(): string
    {
        return $this->message ?? 'Submitted successfully!';
    }
}
