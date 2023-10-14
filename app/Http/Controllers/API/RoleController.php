<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $roles = Role::all();
        return response()->json($roles);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $val=Validator::make($request->all(),
        [
            'description'=>'required|string|max:255',
            'admin'=>'required|boolean',
            'user'=>'required|boolean',
            'nom_role'=>'required|string|max:25',
        ] 
        );

        if( $val->fails()){
            return response()->json($val->errors(), 422);     
        }

        $role = Role::create([
            'description'=>$request->description,
            'admin'=>$request->admin,
            'user'=>$request->user,
            'nom_role'=>$request->nom_role,  
        ]);

        return response()->json($role,201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        //
        return response()->json($role);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        //
        $this->validate($request,[
            'description'=>'required|string|max:255',
            'admin'=>'required|boolean',
            'user'=>'required|boolean',
            'nom_role'=>'required|string|max:25',
        ]);

        $role->update([
            'description'=>$request->description,
            'admin'=>$request->admin,
            'user'=>$request->user,
            'nom_role'=>$request->nom_role,  
        ]);

        return response()->json();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        //
        $role->delete();
        return response()->json();
    }
}
