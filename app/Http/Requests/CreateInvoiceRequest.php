<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;


class CreateInvoiceRequest extends FormRequest
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
            'issue_date' => 'required|date',
            'due_date' => 'required|date',
            'customer_id' => 'required|exists:customers,id',
            'items' => 'required|array',
            'items.*.item_id' => 'required|numeric',
            'items.*.unit_price' => 'required|numeric',
            'items.*.quantity' => 'required|integer',
            'items.*.amount' => 'required|numeric',
            'items.*.description' => 'required|string',
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