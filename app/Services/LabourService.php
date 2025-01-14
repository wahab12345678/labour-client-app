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

use Illuminate\Support\Str;


class LabourService
{
    /**
     * Authenticates a user based on the given credentials.
     *
     * @param array $credentials
     * @return array
     */
    public function list()
    {
        return Category::get();
    }
    /**
     * Get a list of all categories that are active.
     *
     * @return \Illuminate\Database\Eloquent\Collection|Category[]
     */
    public function categoryList()
    {
        return Category::where('status',1)->get();
    }
    /**
     * Get a list of Account Types
     *
     * @return \Illuminate\Database\Eloquent\Collection|AccountType[]
     */
    public function accountTypeList()
    {
        return AccountType::where('status', 1)->get();
    }
    /**
     * Get a category by id.
     *
     * @param int $id
     * @return Category|null
     */
    public function find($id)
    {
        return Category::find($id);
    }
    /**
     * Update a category
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    // public function update(Request $request)
    // {
    //     $id      = $request->category_id;
    //     $category = Category::findOrFail($id);
    //     if($category) {
    //         $category->update([
    //             'name' => $request->name,
    //             'description' => $request->description,
    //             'status' => $request->status ==  1 ? UserStatus::Active->value : UserStatus::Inactive->value,
    //         ]);
    //         return response()->json([
    //             'success' => true,
    //             'message' => 'Category Updated Successfully'
    //         ]);
    //     }
    //     return response()->json([
    //         'success' => false,
    //         'message' => 'Category Not Found'
    //     ]);
    // }
    /**
     * Store a newly created labour in the database.
     *
     * This method handles the creation of a new labour user, including their
     * associated metadata and accounts. It also assigns the "labour" role
     * to the user. The method performs the operations within a database
     * transaction to ensure atomicity.
     *
     * @param LabourRequest $request The request object containing the labour
     *                               details to be stored.
     * @return \Illuminate\Http\JsonResponse JSON response indicating the
     *                                       success or failure of the operation.
     */
    public function store(LabourRequest $request)
    {
        DB::beginTransaction();
        try {
            // Create the user
            $user = User::create([
                'name' => $request->name,
                'email' => $request->phone . '@gmail.com',
                'password' => bcrypt('password'), // Default password
                'phone' => $request->phone,
                'status' => $request->status == "1" ? UserStatus::Active->value : UserStatus::Inactive->value,
            ]);
            // Generate a unique slug
            $slug      = Str::slug($request->name);
            $slugCount = UserMeta::where('slug', $slug)->count();

            // If the slug already exists, append a number to make it unique
            if ($slugCount > 0) 
            {
                $slug = $slug . '-' . ($slugCount + 1);
            }

            // Create user meta

            UserMeta::create([
                'user_id'        => $user->id,
                'category_id'    => $request->category_id,
                'cnic_no'        => $request->cnic_no,
                'cnic_front_img' => $this->storeImageInPublicFolder($request->file('cnic_front_img'), 'cnic_front'),
                'cnic_back_img'  => $this->storeImageInPublicFolder($request->file('cnic_back_img'), 'cnic_back'),
                'address'        => $request->address,
                'slug'           => $slug,

                
            ]);
            // Use createMany to add multiple accounts
            foreach ($request->accounts as $account) {
                UserAccount::create([
                    'user_id' => $user->id,
                    'account_type_id' => $account['type'],
                    'account_no' => $account['number'],
                    'account_title' => $account['title'],
                ]);
            }
            // Assign role to the user
            $user->assignRole('labour');
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Labour created successfully!',
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while creating the labour.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function update(LabourRequest $request)
    {
        $id  = $request->user_id;
        // dd($request->all());

        DB::beginTransaction();

        try 
        {
            // Find the user by ID
            $user = User::findOrFail($id);
            
            // Update the user's basic information
            $user->update([
                'name'   => $request->name,
                'email'  => $request->phone . '@gmail.com', // Update email based on phone
                'phone'  => $request->phone,
                'status' => $request->status == "1" ? UserStatus::Active->value : UserStatus::Inactive->value,
            ]);
    
            // Update user meta
            $userMeta = $user->meta; // Assuming you have a one-to-one relationship with UserMeta
            $userMeta->update([
                'category_id' => $request->category_id,
                'cnic_no'     => $request->cnic_no,
                'address'     => $request->address,
            ]);
            // check if the slug field is empty
            if (empty($userMeta->slug)) 
            {
                // Generate a unique slug

                $slug      = Str::slug($request->name);
                $slugCount = UserMeta::where('slug', $slug)->count();
                
                // If the slug already exists, append a number to make it unique
                if ($slugCount > 0) {
                    $slug = $slug . '-' . ($slugCount + 1);
                }

                $userMeta->update(['slug' => $slug]);
            }
    
            // Update images only if new files are uploaded
            if ($request->hasFile('labour-cnic_front_img')) 
            {
                $userMeta->cnic_front_img = $this->storeImageInPublicFolder($request->file('labour-cnic_front_img'), 'cnic_front');
            }
            if ($request->hasFile('labour-cnic_back_img')) 
            {
                $userMeta->cnic_back_img = $this->storeImageInPublicFolder($request->file('labour-cnic_back_img'), 'cnic_back');
            }
    
            // Save the updated user meta
            $userMeta->save();
    
            // Update user accounts
            // First, delete existing accounts
            $user->accounts()->delete();
            
            // Add updated accounts
            foreach ($request->accounts as $account) {
                UserAccount::create([
                    'user_id'         => $user->id,
                    'account_type_id' => $account['type'],
                    'account_no'      => $account['number'],
                    'account_title'   => $account['title'],
                ]);
            }
    
            // Assign role if not already assigned
            if (!$user->hasRole('labour')) 
            {
                $user->assignRole('labour');
            }
    
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Labour updated successfully!',
            ], 200);
        } 
        catch (\Exception $e) 
        {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while updating the labour.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    
    
    /**
     * Store uploaded file in the public folder.
     *
     * @param \Illuminate\Http\UploadedFile $file
     * @param string $directory
     * @return string
     */
    private function storeImageInPublicFolder($file, $directory)
    {
        // Define the target path in the public directory
        $targetPath = public_path($directory);
        // Create the directory if it doesn't exist
        if (!file_exists($targetPath)) {
            mkdir($targetPath, 0755, true);
        }
        // Generate a unique file name
        $fileName = uniqid() . '_' . $file->getClientOriginalName();
        // Move the file to the target directory
        $file->move($targetPath, $fileName);
        // Return the public path of the file
        return $directory . '/' . $fileName;
    }

    /**
     * Deletes a labour by its ID.
     *
     * @param int $id The ID of the labour to delete
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        DB::beginTransaction(); // Start the transaction
        try {
            $user = User::findOrFail($id); // Use findOrFail to automatically return 404 if not found
            // Check if the user has associated metadata for images
            if ($user->meta) {
                $cnicFrontPath = public_path($user->meta->cnic_front_img);
                $cnicBackPath = public_path($user->meta->cnic_back_img);
                // Delete cnic front image if it exists
                if (File::exists($cnicFrontPath)) {
                    File::delete($cnicFrontPath); // Delete the front image
                }
                // Delete cnic back image if it exists
                if (File::exists($cnicBackPath)) {
                    File::delete($cnicBackPath); // Delete the back image
                }
            }
            // Delete associated user meta, accounts, and roles
            UserMeta::where('user_id', $user->id)->delete();
            UserAccount::where('user_id', $user->id)->delete();
            $user->roles()->detach(); // Detach all roles from the user
            // Delete the user
            $user->delete();
            DB::commit(); // Commit the transaction if everything is successful
            // Return success response
            return response()->json([
                'success' => true,
                'message' => 'Labour deleted successfully',
            ], 200);

        } catch (\Exception $e) {
            DB::rollBack(); // Rollback transaction in case of error
            // Return error response
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while deleting the labour',
            ]);
        }
    }

    public function edit($id)
    {
        $categoryList    =   $this->categoryList();
        $accountTypeList =   $this->accountTypeList();

        $user = User::where('id', $id)->with('accounts','meta')->get();
       

        return response()->json([
            'user'            => $user,
            'categoryList'    => $categoryList,
            'accountTypeList' => $accountTypeList,
        ]);

    }

    /**
     * Toggle the status of the specified labour
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function toggleStatus(Request $request)
    {
        $id = $request->id;
        $user = User::findOrFail($id);
        if ($user) {
            $user->status = $request->status == "Active" ? UserStatus::Inactive->value : UserStatus::Active->value;
            $user->save();
            return response()->json([
               'success' => true,
               'message' => 'Labour status updated successfully',
            ]);
        }
        return response()->json([
           'success' => false,
           'message' => 'Labour not found',
        ]);
    }
}
