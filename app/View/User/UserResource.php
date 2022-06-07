<?php

namespace App\Http\Resources\Admin\User;

use App\Http\Resources\Admin\User\UserIndexResource;

class UserResource extends UserIndexResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return array_merge(parent::toArray($request), [
            // 'region'=>new RegionResource($this->region),
        ]);
    }
}
