<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContractorRequest extends FormRequest
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
        $contractorId = $this->input('contractor_id'); // Retrieve the user_id from the form

        return [
            'name' => 'required',
            // 'phone' => 'required|unique:users',
            'phone'             => 'required|unique:users,phone,' . $contractorId,
            'address'           => 'required',
            'cnic_no'           => 'required|numeric',
            'cnic_front_img'    => $contractorId ? 'nullable' : 'required', // Image is not required if userId is present
            'cnic_back_img'     => $contractorId ? 'nullable' : 'required', // Image is not required if userId is present
            'status'            => $contractorId ? 'nullable' : 'required', // Image is not required if userId is present

            'accounts'          => 'required|array|min:1', // Ensure accounts is an array with at least one item
            'accounts.*.type'   => 'required|integer|exists:account_types,id', // Ensure type exists in the account_types table
            'accounts.*.number' => 'required|string|max:255', // Validate account number
            'accounts.*.title'  => 'required|string|max:255', // Validate account title
        ];
    }
}
