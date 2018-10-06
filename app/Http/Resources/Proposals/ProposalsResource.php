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
            'number' => $this->id ,
            'proposal type' => $this->proposal_type ,
            'technical approver' => $this->technical_approver ,
            'proposal number' => $this->proposal_number ,
            'client source' => $this->client_source ,
            'sales agent' => $this->sales_agent ,
            'code'=> $this->code,
            'value'=> $this->value,
            'date'=> $this->created_at ? $this->created_at->format('d-m-Y') : 'UnKnown',
            'user'=> [
                'name' => $this->user->name,
                'email' => empty($this->user->email) ? 'No Email Provided' : $this->user->email,
                'Url' => [
                    'link' => route('users.show',$this->user['id'])
                ]
            ]
        ];
    }
}
