<?php

namespace App\Http\Controllers\Admin;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Services\ContractorService;
use App\Http\Resources\ContractorResource;
use App\Http\Requests\ContractorRequest;

use App\Enums\UserStatus;

use Illuminate\Http\Request;

class ContractorController extends Controller
{
    public function index(ContractorService $contractor, Request $request)
    {
        $data['accountTypes'] = $contractor->accountTypeList();
        return view('admin.contractors.index', $data);
    }
    public function list(Request $request)
    {
        $contractors   = User::role('contractor')->get();
        $data          = ContractorResource::collection($contractors);
        return response()->json(['data' => $data]);
    }
    public function store(ContractorService $contractor, ContractorRequest $request)
    {
        return $contractor->store($request);
    }
    public function destroy(ContractorService $contractor, $id)
    {
        return $contractor->destroy($id);
    }
    public function toggleStatus(ContractorService $contractor, Request $request)
    {
        return $contractor->toggleStatus($request);
    }
    public function edit(ContractorService $contractor,$id)
    {
        return $contractor->edit($id);
    }
    public function update(ContractorService $contractor, ContractorRequest $request)
    {
        return $contractor->update($request);
    }


}
