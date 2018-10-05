<?php

namespace App\Http\Resources\Users;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Proposals\ProposalsCollection;


class UsersResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'number' => $this->id,
            'name' => $this->name,
            'email' => empty($this->email) ? 'No Email Provided' : $this->email,
            'can_view' => $this->can_view == 0 ? 'False' : 'true',
            'can_delete' => $this->can_delete == 0 ? 'False' : 'true',
            'can_list' => $this->can_list == 0 ? 'False' : 'true',
            'can_create' => $this->can_create == 0 ? 'False' : 'true',
            'Proposals' => [
                'item' => ProposalsCollection::collection($this->proposals)
            ],
        ];
    }
}
