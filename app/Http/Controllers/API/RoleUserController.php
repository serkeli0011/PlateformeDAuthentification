<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\RoleUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RoleUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $roleUsers = RoleUser::all();
        return response()->json($roleUsers);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //'role_id','user_id'
        $val=Validator::make($request->all(),
        [
            'role_id'=>'required|integer',
            'user_id'=>'required|integer',
        ]
    );

    if( $val->fails()){
        return response()->json($val->errors(), 422);     
    }

        $roleUser = RoleUser::create([
            'role_id'=>$request->role_id,
            'user_id'=>auth()->user()->id,
        ]);

        return response()->json($roleUser,201);
    }

    /**
     * Display the specified resource.
     */
    public function show(RoleUser $roleUser)
    {
        //
        return response()->json($roleUser);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RoleUser $roleUser)
    {
        //
        $this->validate($request,[
            'role_id'=>'required|integer',
            'user_id'=>'required|integer',
        ]);

        $roleUser->update([
            'role_id'=>$request->role_id,
            'user_id'=>$request->user_id,
        ]);

        return response()->json();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RoleUser $roleUser)
    {
        //
        $roleUser->delete();
        return response()->json();
    }
}
