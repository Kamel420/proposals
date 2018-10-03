<?php

namespace App\Http\Resources\Proposals;

use Illuminate\Http\Resources\Json\JsonResource;

class ProposalsCollection extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'code'=> $this->code,
            'user'=> [
                'name' => $this->user->name,
                'email' => empty($this->user->email) ? 'No Email Provided' : $this->user->email,
                
            ]
        ];
    }
}
