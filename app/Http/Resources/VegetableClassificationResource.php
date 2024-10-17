<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VegetableClassificationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'vegetables' => VegetableResource::collection($this->whenLoaded('vegetables')),
            'created_at' => $this->created_at->format('d M Y h:i A'),
            'updated_at' => $this->updated_at->format('d M Y h:i A'),
        ];
    }
}
