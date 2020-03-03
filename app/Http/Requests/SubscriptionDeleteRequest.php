<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubscriptionDeleteRequest extends FormRequest
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
            'msisdn' => 'required|string|max:20|exists:subscriber,msisdn',
            'service' => 'required|string|max:255|exists:service,description',
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'msisdn.required' => 'El campo msisdn es obligatorio',
            'service.required' => 'El campo service es obligatorio',
        ];
    }
}
