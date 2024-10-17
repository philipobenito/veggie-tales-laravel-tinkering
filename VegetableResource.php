<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VegetableResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'classification' => $this->classification,
            'description' => $this->description,
            'edible' => $this->edible,
            'created_at' => $this->created_at->format('d M Y h:i A'),
            'updated_at' => $this->updated_at->format('d M Y h:i A'),
        ];
    }
}
