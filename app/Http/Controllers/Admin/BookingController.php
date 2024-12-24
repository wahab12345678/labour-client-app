<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\BookingService;
use App\Http\Requests\BookingRequest;
use App\Models\User;

class BookingController extends Controller
{
    public function index()
    {
        $data['clients'] = User::role('client')->get();
        $data['labours'] = User::role('labour')->get();
        return view('admin.booking.index',$data);
    }

    public function list(BookingService $booking)
    {
        return $booking->list();
    }

    public function store(BookingService $booking, BookingRequest $request)
    {
        return $booking->store($request);
    }

    public function edit($id)
    {

    }

    public function destroy($id)
    {

    }
}
