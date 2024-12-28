<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookingRequest extends FormRequest
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
        $bookingId = $this->input('booking_id');

        return [
            'client_id' => 'required',
            'labour_id' => 'required|array',
            'start_date' => 'required',
            'status' => $bookingId ? 'nullable' : 'required', // Image is not required if userId is present
            'end_date' => 'required',
            // 'description' => 'required',
            'price' => 'required',
            // 'status' => 'required',
        ];
    }
}
