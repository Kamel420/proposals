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

    protected function validationData()
    {   
        //because Rule:in is case sensetive i will convert inputs to lowercase fisrt
        $all = parent::validationData();
        //Convert request value to lowercase
        $all['proposal_type'] = strtolower(preg_replace('~[^a-z]~i',' ', $all['proposal_type']));
        $all['technical_approver'] = strtolower(preg_replace('~[^a-z]~i',' ', $all['technical_approver']));
        $all['client_source'] = strtolower(preg_replace('~[^a-z]~i',' ', $all['client_source']));
        $all['sales_agent'] = strtolower(preg_replace('~[^a-z]~i',' ', $all['sales_agent']));
        return $all;
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
                                    Rule::in(['0001','0002']),
                                    'min:4|max:4'
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
            'proposal_type.*' => 'A proposal_type must be Set to web development, digital marketing or web product',
            'technical_approver.required'  => 'A technical_approver is required',
            'proposal_number.*'  => 'A proposal_number must be Set to 0001 or 0002',
            'client_source.*'  => 'A client_source must be Set to recap or digital campaign',
            'sales_agent.*'  => 'A sales_agent Must be Set to yassmin hassan or ahmed essam',
            'value' => 'required',
        ];
    }
}
