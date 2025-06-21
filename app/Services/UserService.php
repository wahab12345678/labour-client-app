<?php

namespace App\Services;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\User;
use App\Models\UserMeta;
use App\Models\AccountType;
use App\Enums\UserStatus;
use App\Models\UserAccount;
use Illuminate\Support\Facades\DB; // Attach the DB facade
use Illuminate\Support\Facades\Storage; // For file storage
use App\Http\Requests\LabourRequest;
use Illuminate\Support\Facades\File;
use App\Http\Requests\UserRequest;


use Illuminate\Support\Str;


class UserService
{
    /**
     * Authenticates a user based on the given credentials.
     *
     * @param array $credentials
     * @return array
     */
 
        
    public function list()
    {
        return User::role('admin')->get()->map(function ($user) {
            return [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone,
                'status' => $user->status ? 'Active' : 'Inactive',
                'role' => $user->roles->pluck('name')->first() ?? 'N/A',
                'is_visible' => $user->is_visible ?? 0
            ];
        });
    }
    public function toggleStatus(Request $request)
    {
        $id   = $request->id;
        $user = User::findOrFail($id);
     
        if ($user ){
            $user ->status = $request->status == "Active" ? UserStatus::Inactive->value : UserStatus::Active->value;
            $user ->save();
            return response()->json([
               'success' => true,
               'message' => 'User status updated successfully',
            ]);
        }
        return response()->json([
           'success' => false,
           'message' => 'Category not found',
        ]);
    }

    public function create(UserRequest $request)
    {
        $user =  User::create([
            'name'     =>  $request->name,
            'email'    =>  $request->email,
            'password' => bcrypt('password'), // Default password
            'phone'    => $request->phone,
            'status'   => $request->status == "1" ? UserStatus::Active->value : UserStatus::Inactive->value,
        ]);

        $user->assignRole('admin');

        return response()->json([
           'success' => true,
           'message' => 'User Created Successfully',
        ]);
    }

    public function update(UserRequest $request)
    {
        $id   = $request->user_id;
        $user = User::findOrFail($id);

        if($user) 
        {
            $user->update([
                'name'   => $request->name,
                'email'  => $request->email,
                'phone'  =>  $request->phone,
            ]);

            return back()->withSuccess('User Updated Successfully');
        }

        return back()->withError('user Not Found');
    }

      public function edit($id)
    {
        $UserDetail  = User::where('id', $id)->first();
        return response()->json([
            'user'      => $UserDetail
        ]);
    }
    
  
}
