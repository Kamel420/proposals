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
            'proposal type' => $this->proposal_type ,
            'technical approver' => $this->technical_approver ,
            'proposal number' => $this->proposal_number ,
            'client source' => $this->client_source ,
            'sales agent' => $this->sales_agent ,
            'number' => $this->id,
            'code'=> $this->code,
            'value' => $this->value,
        ];
    }
}
