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
            'date'=> $this->created_at ? $this->created_at->format('d-m-Y') : 'UnKnown',
            'user'=> [
                'name' => $this->user->name,
                'email' => empty($this->user->email) ? 'No Email Provided' : $this->user->email,
            ]
        ];
    }
}
