<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateItemRequest extends FormRequest
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
        return [
            'name' => ['string' ,'max:255'],
            'name_ar' => ['string' ,'max:255'],
            'description' => ['sometimes' , 'string'],
            'description_ar' => ['sometimes' , 'string'],
            'price' => ['gte:0' ,'numeric'],
            'estimated_time' => ['sometimes','date_format:G:i'],
        ];
    }
}
