<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Proposal;
use App\Http\Resources\Proposals\ProposalsResource;
use App\Http\Resources\Proposals\ProposalsCollection;
use App\Http\Requests\ProposalsRequest;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class ProposalsController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api')->except('index','show');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ProposalsCollection::collection(Proposal::paginate(5));
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProposalsRequest $request)
    {
        $requestData = $request->all();

        // restrict the user to enter only the first and last name 
        $techApprover = $requestData['technical_approver'];
        $techApprover = preg_split('~[^a-z]~i', $techApprover);
        $countValues = count($techApprover);
        if($countValues > 2)
        {
            return response([
                'Error' => 'Please enter first and last name only for the Techinical Approver'], Response::HTTP_BAD_REQUEST);
        }

        //generate code fractical
        //[proposal_type]
        $proposal_type_code_array = explode(" ", $requestData['proposal_type']);
        $proposal_type_code_fractial = "";
        foreach ($proposal_type_code_array as $c) {
          $proposal_type_code_fractial .= $c[0];
        }
        $proposal_type_code_fractial = strtoupper($proposal_type_code_fractial);

        //[technical_approver]
        $technical_approver_code_array = preg_split('~[^a-z]~i',$requestData['technical_approver']);
        $technical_approver_code_fractial = "";
        foreach ($technical_approver_code_array as $c) {
          $technical_approver_code_fractial .= $c[0];
        }
        $technical_approver_code_fractial = strtoupper($technical_approver_code_fractial);

        //implode the preivous fractical
        $implode_string_1 = $proposal_type_code_fractial.$technical_approver_code_fractial;

        //[client_source]
        $client_source_code_array = explode(" ",$requestData['client_source']);
        $client_source_code_fractial = "";
        foreach ($client_source_code_array as $c) {
          $client_source_code_fractial .= $c[0];
        }
        $client_source_code_fractial = strtoupper($client_source_code_fractial);

        if($client_source_code_fractial === "R")
        {
            $client_source_code_fractial = "RE";
        }

        //[sales_agent]
        $sales_agent_code_array = explode(" ", $requestData['sales_agent']);
        $sales_agent_code_fractial = "";
        foreach ($sales_agent_code_array as $c) {
          $sales_agent_code_fractial .= $c[0];
        }
        $sales_agent_code_fractial = strtoupper($sales_agent_code_fractial);

        //implode the preivous two fractical
        $implode_string_2 = $client_source_code_fractial.$sales_agent_code_fractial;
        
        //generate the total code
        $generated_code_array = [$implode_string_1,$requestData['proposal_number'],$implode_string_2];
        $generated_code = implode("-", $generated_code_array);

        $proposalCreation = new Proposal;
        $proposalCreation->proposal_type = $requestData['proposal_type'];
        $proposalCreation->technical_approver = $requestData['technical_approver'];
        $proposalCreation->proposal_number = $requestData['proposal_number'];
        $proposalCreation->client_source = $requestData['client_source'];
        $proposalCreation->sales_agent = $requestData['sales_agent'];
        $proposalCreation->user_id = Auth::id();
        $proposalCreation->value =  $requestData['value'];
        $proposalCreation->code = $generated_code;
        $proposalCreation->save();
        return response([
            'data' => new ProposalsResource($proposalCreation)
        ],Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Proposal  $proposal
     * @return \Illuminate\Http\Response
     */
    public function show(Proposal $proposal)
    {
        // return $proposal;
        return new ProposalsResource($proposal);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Proposal  $proposal
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Proposal $proposal)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Proposal  $proposal
     * @return \Illuminate\Http\Response
     */
    public function destroy(Proposal $proposal)
    {
        //
    }
}
