<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\BookingService;
use App\Http\Requests\BookingRequest;
use App\Models\User;
use App\Http\Resources\BookingResource;

class BookingController extends Controller
{
    /**
     * Displays the booking page.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        // $data['clients'] = User::role('client')->get();
        // $data['labours'] = User::role('labour')->get();

        $data['clients'] = User::role('client')->where('status', 1)->get();
        $data['labours'] = User::role('labour')->where('status', 1)->get();

        return view('admin.booking.index',$data);
    }

    /**
     * Returns a list of bookings.
     *
     * @param BookingService $booking
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function list(BookingService $booking)
    {
        $data = $booking->list();
        $resource = BookingResource::collection($data);
        return response()->json(['data' => $resource]);
    }

    /**
     * Store a newly created booking in the database.
     *
     * @param \App\Services\BookingService $booking
     * @param \App\Http\Requests\BookingRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(BookingService $booking, BookingRequest $request)
    {
        return $booking->store($request);
    }
    public function update(BookingService $booking, BookingRequest $request)
    {
        return $booking->update($request);
    }

    public function edit(BookingService $booking,$id)
    {
        return $booking->edit($id);
    }

    /**
     * Remove the specified booking from storage.
     *
     * @param  \App\Services\BookingService  $booking
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(BookingService $booking, $id)
    {
        return $booking->delete($id);
    }

    public function toggleStatus(BookingService $booking, Request $request)
    {
        return $booking->toggleStatus($request);
    }

    public function sendFeedbackEmail(BookingService $booking, Request $request)
    {
        return $booking->sendFeedbackEmail($request);
    }
}
