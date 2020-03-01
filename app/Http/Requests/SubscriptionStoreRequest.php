<?php

namespace App\Http\Requests;

use App\Service;
use Illuminate\Foundation\Http\FormRequest;
use phpDocumentor\Reflection\Types\Boolean;

class SubscriptionStoreRequest extends FormRequest
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
            'msisdn' => 'required|string|max:12|exists:subscriber,msisdn',
            'service' => 'required|string|max:255|exists:service,description',
            'insert_date' => 'required|date|date_format:"Y-m-d"'
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
            'insert_date.required' => 'La fecha de alta es obligatoria'
        ];
    }

    /**
     * @param \Illuminate\Validation\Validator $validator
     */
    public function withValidator($validator)
    {

        $validator->after(function ($validator) {

            if ($this->alreadySubscribed()) {
                $validator->errors()->add('subscription','El usuario ya se encuentra subscripto al servicio dado');
            } else {
                if ($this->disabledService()) {
                    $validator->errors()->add('service', 'El servicio se encuentra deshabilitado para su subscripcion');
                }
                if ($this->blockedUser()) {
                    $validator->errors()->add('msisdn', 'El numero se encuentra bloqueado');
                }
            }
        });
    }

    public function alreadySubscribed()
    {
        $subscription = \App\Subscription::query()
            ->where(
                'subscriber_id',
                \App\Subscriber::query()->where('msisdn',$this->get('msisdn'))->pluck('id')->first()
            )
            ->where(
                'service_id',
                \App\Service::query()->where('description',$this->get('service'))->pluck('id')->first()
            );
        return $subscription->first();

    }

    /**
     * @return bool
     */
    public function blockedUser()
    {
        $msisdn = $this->get('msisdn');
        $subscriber = \App\Subscriber::query()->where('msisdn','=',$msisdn)->first();
        return ($subscriber && $subscriber->blocked);
    }

    /**
     * @return bool
     */
    public function disabledService()
    {
        $serviceName = $this->get('service');
        $service =  \App\Service::query()->where('description','=', $serviceName)->first();
        return ($service && $service->is_disabled);
    }
}
