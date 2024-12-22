<?php

namespace App\Http\Controllers\Admin;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\ClientService;
use App\Http\Resources\ClientResource;
use App\Http\Resources\CategoryResource;
use App\Http\Requests\ClientRequest;
use App\Enums\UserStatus;

class ClientController extends Controller
{
    public function index(ClientService $client, Request $request)
    {
        $data['accountTypes'] = $client->accountTypeList();
        return view('admin.clients.index', $data);
    }

    public function list(Request $request)
    {
        $clients = User::role('client')->get();
        $data = ClientResource::collection($clients);
        return response()->json(['data' => $data]);
    }

    public function store(ClientService $client, ClientRequest $request)
    {
        return $client->store($request);
    }

    public function destroy(ClientService $client, $id)
    {
        return $client->destroy($id);
    }

    public function toggleStatus(ClientService $client, Request $request)
    {
        return $client->toggleStatus($request);
    }
}
