<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Http\Requests\UserUpdateRequest;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('tables', compact('users'));
    }

    public function update(UserUpdateRequest $request, $id)
    {
        $user = User::find($id);
        $user->update($request->all());
        return redirect()->back()->withSuccess('User updated successfully.');
    }

    public function delete(Request $request, $id)
    {
        $user = User::find($id);
        $user->delete();
        return redirect()->back()->withSuccess('User deleted successfully.');
    }
}
