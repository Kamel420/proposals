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
            'name' => $this->name,
            'email' => empty($this->email) ? 'No Email Provided' : $this->email,
            'Proposals' => [
                'item' => ProposalsCollection::collection($this->proposals)
            ],
        ];
    }
}
