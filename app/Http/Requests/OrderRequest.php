<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $data = [
            'city_name' => ['required', 'string', 'max:255'],
            'address_name' => ['required', 'string', 'max:255'],
            'building_number' => ['required', 'string', 'max:50'],
            'payment_method' => ['required', 'in:stripe,paypal,delivery'],
        ];

        if(request()->isMethod('put')){
            $data = [];
            $data['order_status'] = ['required', 'in:pending, shipped, delivered'];
        }
        return $data;
    }
}
