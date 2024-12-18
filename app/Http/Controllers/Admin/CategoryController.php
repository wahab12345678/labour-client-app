<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        return view('admin.categories.index');
    }

    public function list(Request $request)
    {
        return response()->json(['data' => Category::all()]);
    }
}
