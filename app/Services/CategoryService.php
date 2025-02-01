<?php

namespace App\Services;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use App\Enums\CategoryStatus;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

use App\Http\Requests\CategoryRequest;

class CategoryService
{
    /**
     * Authenticates a user based on the given credentials.
     *
     * @param array $credentials
     * @return array
     */
    public function list()
    {
        return Category::all();
    }
    public function find($id)
    {
        return Category::find($id);
    }
    public function edit($id)
    {
        $CategoryDetail  = Category::where('id', $id)->first();
        return response()->json([
            'category'      => $CategoryDetail
        ]);
    }

    public function update(CategoryRequest $request)
    {
        $id = $request->category_id;
        $category = Category::findOrFail($id);
        if($category) {
            $category->update([
                'name' => $request->name,
                'description' => $request->description,
                'img_path' => $this->storeImageInPublicFolder($request->file('img_path'), 'categories'),

            ]);
            // check if the slug field is empty
            if (empty($category->slug)) {
                // Generate a unique slug
                $slug = Str::slug($request->name);
                $slugCount = Category::where('slug', $slug)->count();
                // If the slug already exists, append a number to make it unique
                if ($slugCount > 0) {
                    $slug = $slug . '-' . ($slugCount + 1);
                }
                $category->update(['slug' => $slug]);
            }
            return back()->withSuccess('Category Updated Successfully');
        }
        return back()->withError('Category Not Found');
    }

    public function create(CategoryRequest $request)
    {
        // Generate a unique slug
        $slug = Str::slug($request->name);
        $slugCount = Category::where('slug', $slug)->count();
        // If the slug already exists, append a number to make it unique
        if ($slugCount > 0) {
            $slug = $slug . '-' . ($slugCount + 1);
        }

        Category::create([
            'name'        => $request->name,
            'description' => $request->description,
            'slug'        => $slug,
            'status'      => $request->status ==  1 ? CategoryStatus::Active->value : CategoryStatus::Inactive->value,
            'img_path'    => $this->storeImageInPublicFolder($request->file('img_path'), 'categories'),
            'key_points'  => json_encode(explode("\n", $request->key_points)), // Convert to JSON

        ]);
        return back()->withSuccess('Category Created Successfully');
    }

    public function toggleStatus(Request $request)
    {
        $id       = $request->id;
        $category = Category::findOrFail($id);
        if ($category ){
            $category ->status = $request->status == "Active" ? CategoryStatus::Inactive->value : CategoryStatus::Active->value;
            $category ->save();
            return response()->json([
               'success' => true,
               'message' => 'Category status updated successfully',
            ]);
        }
        return response()->json([
           'success' => false,
           'message' => 'Category not found',
        ]);
    }

    public function toggleVisibilityStatus(Request $request)
    {
        $id       = $request->id;
        $category = Category::findOrFail($id);
        if ($category ){
            $category ->is_visible = $request->status == "1" ? 0 : 1;
            $category ->save();
            return response()->json([
               'success' => true,
               'message' => 'Category Visibility Updated Successfully',
            ]);
        }
        return response()->json([
           'success' => false,
           'message' => 'Category not found',
        ]);
    }

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
}
