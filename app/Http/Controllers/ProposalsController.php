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
        $proposal_type_code_fractial = Self::generateFractial($requestData['proposal_type']);

        //[technical_approver]
        $technical_approver_code_fractial = Self::generateFractial($requestData['technical_approver']);

        //[client_source]
        $client_source_code_fractial = Self::generateFractial($requestData['client_source']);
        if($client_source_code_fractial === "R")
        {
            $client_source_code_fractial = "RE";
        }

        //[sales_agent]
        $sales_agent_code_fractial = Self::generateFractial($requestData['sales_agent']);

        //generate the total code
        $generated_code = implode("-", [$proposal_type_code_fractial.$technical_approver_code_fractial,$requestData['proposal_number'],$client_source_code_fractial.$sales_agent_code_fractial]);

        //store proposal
        $proposalCreation = new Proposal;
        $proposalCreation->proposal_type = $requestData['proposal_type'];
        $proposalCreation->technical_approver = strtolower(preg_replace('/[^a-zA-Z]/',' ',$requestData['technical_approver']));
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
        $proposal->update($request->all());
        return response([
            'data' => new ProposalsResource($proposal)
        ],Response::HTTP_CREATED);
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

    public static function generateFractial($intervial)
    {
        $code_array = preg_split('~[^a-z]~i', $intervial);
        $code_fractial = "";
        foreach ($code_array as $c) {
          $code_fractial .= $c[0];
        }
        $code_fractial = strtoupper($code_fractial);
        return $code_fractial;
    }
}
