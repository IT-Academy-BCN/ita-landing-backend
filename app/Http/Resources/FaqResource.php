<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FaqResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'ca' => [
                'title' => $this->resource->translations->where('locale', 'ca')->first()->title,
                'description' => $this->resource->translations->where('locale', 'ca')->first()->description,
            ],
            'es' => [
                'title' => $this->resource->translations->where('locale', 'es')->first()->title,
                'description' => $this->resource->translations->where('locale', 'es')->first()->description,
            ],
        ];
    }
}
