<?php

namespace App\Http\Resources\V1;

use App\Models\V1\Board;
use Illuminate\Http\Resources\Json\JsonResource;

class KanbanResources extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'columns' => ColumnTasksResource::collection($this->columns)
        ];
    }
}
