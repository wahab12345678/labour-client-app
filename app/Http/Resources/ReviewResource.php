<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
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
            'rating' => $this->rating,
            'comment' => $this->comment,
            'booking_id' => $this->booking_id,
            'reviewer_name' => $this->reviewer->name ?? 'reviewer_name',
            'reviewee_name' => $this->reviewee->name ?? 'reviewee_name',
            'created_at' => $this->created_at->toDateTimeString(),
        ];
    }
}
