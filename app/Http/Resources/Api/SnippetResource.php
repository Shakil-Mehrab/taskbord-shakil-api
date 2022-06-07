<?php

namespace App\Http\Resources\Api;

use App\Http\Resources\Api\StepResource;
use App\Http\Resources\Api\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class SnippetResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'title' => $this->title??'',
            'steps_count' => $this->steps->count(),
            'is_public' => $this->is_public,
            'steps' => StepResource::collection($this->steps),
            'author' =>new UserResource($this->user),
            'user' =>[
                'owner'=>$this->user_id==auth()->user()?->id,

            ],

        ];
    }
}
