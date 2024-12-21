<?php

namespace App\Http\Controllers\Admin;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\LabourService;
use App\Http\Resources\LabourResource;
use App\Http\Resources\CategoryResource;
use App\Http\Requests\LabourRequest;
use App\Enums\UserStatus;

class LabourController extends Controller
{
    public function index(LabourService $labour, Request $request)
    {
        $categories = $labour->categoryList();
        $data['category'] = CategoryResource::collection($categories);
        $data['accountTypes'] = $labour->accountTypeList();
        return view('admin.labours.index', $data);
    }

    public function list(Request $request)
    {
        $labours = User::role('labour')->get();
        $data = LabourResource::collection($labours);
        return response()->json(['data' => $data]);
    }

    public function store(LabourService $labour, LabourRequest $request)
    {
        return $labour->store($request);
    }

    public function destroy(LabourService $labour, $id)
    {
        return $labour->destroy($id);
    }

    public function toggleStatus(LabourService $labour, Request $request)
    {
        return $labour->toggleStatus($request);
    }
}
