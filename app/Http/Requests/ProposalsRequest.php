<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProposalsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {   
        $proposalType = ['web development','digital marketing','web product'];
        $clientSource = ['recap','digital campaign'];
        $salesAgent = ['yassmin hassan','ahmed essam'];

        return [
            'proposal_type' => [
                                    'required',
                                    Rule::in($proposalType)
                                ],
            'technical_approver' => 'required|string',
            'proposal_number' => [
                                    'required',
                                    Rule::in(['0001','0002'])
                                ],
            'client_source' => [
                                    'required',
                                    Rule::in($clientSource)
                                ],
            'sales_agent' =>    [
                                    'required',
                                    Rule::in($salesAgent)
                                ],
            'value' => 'required',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'proposal_type.*' => 'A proposal_type must be Set to web development, digital marketing or web product And case-sensitive applies',
            'technical_approver.required'  => 'A technical_approver is required',
            'proposal_number.*'  => 'A proposal_number must be Set to 0001 or 0002',
            'client_source.*'  => 'A client_source must be Set to recap or digital campaign And case-sensitive applies',
            'sales_agent.*'  => 'A sales_agent Must be Set to yassmin hassan or ahmed essam And case-sensitive applies',
            'value' => 'required',
        ];
    }
}
