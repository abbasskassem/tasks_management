<?php

namespace App\Http\Resources\Tasks;

use App\Core\BaseResource;
use Illuminate\Http\Request;

class TaskResource extends BaseResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'task_id' => $this->task_id,
            'title' => $this->title,
            'description' => $this->description,
            'categories' => $this->whenLoaded('categories', function ()
            {
                return $this->categories->toArray();
                //WE CAN DO SOMETHIG LIKE THIS ..
                //return TicketResource::collection($this->category);
            })
        ];
    }
}
