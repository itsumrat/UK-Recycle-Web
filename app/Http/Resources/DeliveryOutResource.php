<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DeliveryOutResource extends JsonResource
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
            'date' => $this->date->format('d/m/Y'),
            'delivery_out_id' => $this->delivery_out_id,
            'category_id' => $this->category_id,
            'delivery_type' => $this->delivery_type,
            'customer_id' => $this->customer_id,
            'measurement_type' => $this->measurement_type,
            'added_by' => $this->added_by,
            'assigned_to' => $this->assigned_to,
            'created_at' => $this->created_at->format('d/m/Y'),
            'updated_at' => $this->updated_at->format('d/m/Y'),
        ];
        }
}