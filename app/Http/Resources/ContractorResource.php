<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ContractorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'phone' => $this->phone,
            'cnic_no' => $this->meta ? $this->meta->cnic_no : null,
            'status'         => $this->status == 1 ? 'Active' : 'Inactive',
            'cnic_front_img' => $this->meta ? env('APP_URL').$this->meta->cnic_front_img : null,
            'cnic_back_img'  => $this->meta ? env('APP_URL').$this->meta->cnic_back_img : null,
            'created_at'     => $this->created_at->toDateTimeString(),
        ];
    }
}
