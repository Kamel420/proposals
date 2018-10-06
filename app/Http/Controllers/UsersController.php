<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Http\Resources\Users\UsersResource;
use App\Http\Resources\Users\UsersCollection;
use Symfony\Component\HttpFoundation\Response;


class UsersController extends Controller
{   
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return UsersCollection::collection(User::paginate(5));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return new UsersResource($user);
    }

    /**
     * Update the specified privileges in users table.
     *
     */
    public function ChangePermissions(Request $request, $user_id)
    {  
        $user = User::findOrFail($user_id);
        $requestData = $request->all();
        $perms = ['can_view','can_delete','can_create','can_list'];
        foreach ($requestData as $key => $value) 
        {   
            if(!in_array($key, $perms))
            {
                return response([
                    'Data' => 'Please enter can_view, can_list, can_delete, can_create parameters only for this function'], Response::HTTP_BAD_REQUEST);
            }
            
            if($value !== 0 && $value !== 1)
            {
                return response([
                    'Error' => 'Please enter 0 for false or 1 for true only for this permission'], Response::HTTP_BAD_REQUEST);
            }

        }  

        $user->can_view = $request->get('can_view', $user->can_view);
        $user->can_delete = $request->get('can_delete', $user->can_delete);
        $user->can_create = $request->get('can_create', $user->can_create);
        $user->can_list = $request->get('can_list', $user->can_list);
        $user->save();

        return response([
           'Data' => 'Ok'
        ],Response::HTTP_CREATED);
    }

}
