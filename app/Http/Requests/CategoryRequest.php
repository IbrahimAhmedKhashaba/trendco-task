<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class CategoryRequest extends FormRequest
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
            'name' => 'required|array|unique:categories,name,' . $this->id,
            'name.*' => 'required|string|max:255',
            'description' => 'required|array|unique:categories,description,' . $this->id,
            'description.*' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status' => 'required|in:active,inactive',
        ];

        if(request()->isMethod('put')){
            $data['image'] = 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048';
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
