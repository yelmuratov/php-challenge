<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;

class UserController extends Controller
{
    public function edit(Request $request, $id)
    {       

        $user = User::find($id);
        $roles = Role::all()->toArray();
        return view('user.edit', compact('user', 'roles'));
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);
        $user->update($request->only('name', 'email'));
        $user->roles()->sync($request->roles);
        return redirect('/users')->withSuccess('User updated successfully.');
    }

    public function delete(Request $request, $id)
    {
        $user = User::find($id);
        $user->delete();
        return redirect('/users')->withSuccess('User deleted successfully.');
    }
}
