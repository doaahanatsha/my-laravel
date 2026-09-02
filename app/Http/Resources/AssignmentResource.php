<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AssignmentResource extends JsonResource
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
            'volunteer_id' => $this->volunteer_id,
            'volunteer_name' => $this->volunteer->user->name,
            'work_location_id' => $this->work_location_id,
            'work_location_name' => $this->workLocation->name,
            'task_id' => $this->task_id,
            'task_name' => $this->task->name,
            'notes' => $this->notes,
            'created_at' => $this->created_at,
        ];
    }
}
