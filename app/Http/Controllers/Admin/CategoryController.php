<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Enums\CategoryStatus;
use App\Services\CategoryService;
use App\Http\Resources\CategoryResource;


class CategoryController extends Controller
{
    public function index()
    {
        return view('admin.categories.index');
    }

    public function list(CategoryService $category, Request $request)
    {
        $data     = $category->list();
        $resource = CategoryResource::collection($data);
        return response()->json(['data' => $resource]);
    }
    public function update(CategoryService $category, CategoryRequest $request)
    {
        return $category->update($request);
    }
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return response()->json(['success' => true, 'message' => 'Category deleted successfully.']);
    }
}
