<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientRequest extends FormRequest
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
        $clientId = $this->input('client_id'); 

        return [
            'name' => 'required',
            'phone' => 'required|unique:users,phone,' . $clientId, // Exclude the current client's phone
            'address' => 'required',
            'cnic_no' => 'required|numeric',
            'cnic_front_img' => $clientId ? 'nullable' : 'required', // Image is not required if userId is present
            'cnic_back_img' => $clientId ? 'nullable' : 'required', // Image is not required if userId is present
            'status' => 'required',
            'accounts' =>  $clientId ? 'nullable' : 'required|array|min:1', // Ensure accounts is an array with at least one item
            'accounts.*.type' =>  $clientId ? 'nullable' : 'required|integer|exists:account_types,id', // Ensure type exists in the account_types table
            'accounts.*.number' =>  $clientId ? 'nullable' : 'required|string|max:255', // Validate account number
            'accounts.*.title' => $clientId ? 'nullable' : 'required|string|max:255', // Validate account title
        ];
    }
}
