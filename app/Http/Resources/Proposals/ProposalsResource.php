<?php

namespace App\Http\Resources\Proposals;

use Illuminate\Http\Resources\Json\JsonResource;

class ProposalsResource extends JsonResource
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
            'code'=> $this->code,
            'value'=> $this->value,
            'user'=> [
                'name' => $this->user->name,
                'email' => $this->user->email,
            ],
        ];;
    }
}
