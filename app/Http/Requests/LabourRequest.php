<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LabourRequest extends FormRequest
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
            'name' => 'required',
            'phone' => 'required|unique:users',
            'address' => 'required',
            'category_id' => 'required',
            'cnic_no' => 'required|numeric',
            'cnic_front_img' => 'required',
            'cnic_back_img' => 'required',
            'status' => 'required',
            'accounts' => 'required|array|min:1', // Ensure accounts is an array with at least one item
            'accounts.*.type' => 'required|integer|exists:account_types,id', // Ensure type exists in the account_types table
            'accounts.*.number' => 'required|string|max:255', // Validate account number
            'accounts.*.title' => 'required|string|max:255', // Validate account title
        ];
    }
}
