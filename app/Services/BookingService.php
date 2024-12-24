<?php

namespace App\Services;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\User;
use Illuminate\Support\Facades\DB; // Attach the DB facade
use App\Http\Requests\BookingRequest;
use Illuminate\Support\Facades\File;

class BookingService
{
    /**
     * Authenticates a user based on the given credentials.
     *
     * @param array $credentials
     * @return array
     */
    public function list()
    {
        return Booking::get();
    }

    public function store(BookingRequest $request)
    {
        $bookingExist = Booking::where('labour_id', $request->labour_id)
            ->whereIn('status', ['pending', 'accepted'])
            ->where(function ($query) use ($request) {
                $query->whereBetween('start_date', [$request->start_date, $request->end_date])
                    ->orWhereBetween('end_date', [$request->start_date, $request->end_date])
                    ->orWhere(function ($query) use ($request) {
                        $query->where('start_date', '<=', $request->start_date)
                                ->where('end_date', '>=', $request->end_date);
                    });
            })->exists();
        if ($bookingExist) {
            return response()->json([
                'success' => false,
                'message' => 'Labour is already booked for this date range'
            ]);
        }
        Booking::create([
            'client_id' => $request->client_id,
            'labour_id' => $request->labour_id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => $request->status,
            'price' => $request->price,
            'description' => $request->description
        ]);
        return response()->json([
            'success' => true,
           'message' => 'Booking created successfully'
        ]);
    }
}
