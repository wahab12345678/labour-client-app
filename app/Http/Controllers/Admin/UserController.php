<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Services\UserService;
use App\Http\Requests\UserRequest;
use App\Http\Controllers\Controller; // ✅ this line fixes the issue

use App\Models\User;


class UserController extends Controller
{
    public function index()
    {
        return view('admin.user.index');
    }
     public function list(UserService $users, Request $request)
    {
        $data     = $users->list();
        return response()->json(['data' => $data]);
    }
    public function toggleStatus(UserService $users, Request $request)
    {
        return $users->toggleStatus($request);
    }
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json(['success' => true, 'message' => 'User deleted successfully.']);
    }
     public function create(UserService $user, UserRequest $request)
    {
    //    dd($request->all());
        return $user->create($request);
    }
    public function update(UserService $user, UserRequest $request)
    {
        return $user->update($request);
    }
    public function edit(UserService $user,$id)
    {
        return $user->edit($id);
    }

}
