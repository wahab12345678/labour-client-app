<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookingResource extends JsonResource
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
            'client_id' => $this->client_id,
            'labour_id' => $this->labour_id,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'client_name' => $this->client->name ?? "",
            'labour_name' => $this->labour->name ?? "",
            'price' => $this->price,
            'status' => $this->status,
            'created_at' => $this->created_at->toDateTimeString(),
        ];
    }
}
