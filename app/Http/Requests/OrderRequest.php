<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class OrderRequest extends FormRequest
{
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
        ];

        if(request()->isMethod('put')){
            $data = [];
            $data['order_status'] = ['required', 'in:pending, shipped, delivered'];
        }
        return $data;
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->apiErrorResponse('Validation errors' , 422 , [
            'errors' => $validator->errors(),
        ]));
    }
}
