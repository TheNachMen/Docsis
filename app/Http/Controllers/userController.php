<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class userController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $users = User::simplePaginate(30);
        return view("admin.users.index", compact("users"));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $roles = Role::all();
        //dd($roles);
        $user = User::find($id);
        //dd($user);
        return view('admin.users.edit', compact('user','roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, user $user)
    {
        $user->roles()->sync($request->role);
        return redirect()->route('user.edit')->with('success-update','rol asignado con exito');
    }

    /**
     * Remove the specified resource from storage.
     */
    /*
    public function destroy(user $user)
    {
        $user->delete();

        return redirect()->action([userController::class,'index'])->with('success-delete','Usuario eliminado con exito');
    }
    */
}
