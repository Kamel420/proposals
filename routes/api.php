<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::apiResource('proposals', 'ProposalsController');
Route::Post('/get_proposal_code','ProposalsController@fetchCode');
Route::apiResource('users', 'UsersController');
Route::Patch('users/{user_id}/change_permission','UsersController@ChangePermissions');
