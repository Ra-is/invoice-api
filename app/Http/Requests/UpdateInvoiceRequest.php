<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class UpdateInvoiceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'issue_date' => 'date',
            'due_date' => 'date',
            'customer_id' => 'exists:customers,id',
            'items' => 'array',
            'items.*.invoice_item_id' => 'required|exists:items,invoice_item_id',
            'items.*.unit_price' => 'numeric',
            'items.*.quantity' => 'integer',
            'items.*.amount' => 'numeric',
            'items.*.description' => 'string',
        ];
    }


    /**
     * Handle a failed validation attempt.
     *
     * @param \Illuminate\Contracts\Validation\Validator $validator
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function failedValidation(Validator $validator)
    {
        $errors = (new ValidationException($validator))->errors();

        throw new HttpResponseException(
            response()->json(
                [
                 'errors'        => $errors
                ],
                JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
        );
    }
}
