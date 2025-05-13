<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $data = [
            //
            'name' => 'required|array',
            'name.*' => 'required|string|max:255',
            'description' => 'required|array',
            'description.*' => 'required|string|max:255',
            'images' => 'required|array',
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'categories' => 'required|array',
            'categories.*' => 'required|exists:categories,id',
            'price' => 'required|numeric',
            'discounted_price' => 'nullable|numeric',
            'quantity' => 'required|numeric',
            'status' => 'required|in:active,inactive',
        ];

        if(request()->isMethod('put')){
            $data['images'] = 'nullable|array';
            $data['categories'] = 'nullable|array';
        }

        return $data;
    }

    public function messages(): array
    {
        $data = [
            'name.required' => 'Name is required',
            'name.array' => 'Name must be an array',
            'name.unique' => 'Name must be unique',
            'name.*.required' => 'Name is required',
            'status' => 'required|in:active,inactive',
        ];

        return $data;
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->apiErrorResponse('Validation errors' , 422 , [
            'errors' => $validator->errors(),
        ]));
    }
}
