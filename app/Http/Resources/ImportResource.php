<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ImportResource extends JsonResource
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
            'formatted_processed_rows' => number_format($this->processed_rows),
            'formatted_total_rows' => number_format($this->total_rows),
            'total_rows' => $this->total_rows,
            'processed_rows' => $this->processed_rows,
            'completed_at' => $this->status,
            'model' => $this->model,
        ];
    }
}
