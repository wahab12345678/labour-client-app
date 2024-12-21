<?php

namespace App\Services;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use App\Enums\CategoryStatus;
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
    public function update(Request $request)
    {
        $id = $request->category_id;
        $category = Category::findOrFail($id);
        if($category) {
            $category->update([
                'name' => $request->name,
                'description' => $request->description,
                'status' => $request->status ==  1 ? CategoryStatus::Active->value : CategoryStatus::Inactive->value,
            ]);
            return response()->json([
                'success' => true,
                'message' => 'Category Updated Successfully'
            ]);
        }
        return response()->json([
            'success' => false,
            'message' => 'Category Not Found'
        ]);
    }
    public function create(Request $request)
    {
        Category::create([
            'name'        => $request->name,
            'description' => $request->description,
            'status'      => $request->status ==  1 ? CategoryStatus::Active->value : CategoryStatus::Inactive->value,
        ]);
        return response()->json([
            'success' => true,
            'message' => 'Category Çreated Successfully'
        ]);
    }
}
