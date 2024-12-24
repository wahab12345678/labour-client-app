<?php

namespace App\Services;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\User;
use Illuminate\Support\Facades\DB; // Attach the DB facade
use App\Http\Requests\BookingRequest;
use Illuminate\Support\Facades\File;
use App\Enums\BookingStatus;

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

    /**
     * Store a newly created booking in the database.
     *
     * This method handles the creation of a new booking in the database, including
     * checks for existing bookings for the same date range.
     *
     * @param BookingRequest $request The validated request object containing the
     *                                booking details to be stored.
     * @return \Illuminate\Http\JsonResponse JSON response indicating the success
     *                                       or failure of the operation.
     */
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

    /**
     * Delete a booking by ID.
     *
     * @param int $id The ID of the booking to delete
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($id)
    {
        $booking = Booking::find($id);
        if (!$booking) {
            return response()->json(['success' => false,'message' => 'Booking not found.']);
        }
        $booking->delete();
        return response()->json(['success' => true, 'message' => 'Booking deleted successfully.']);
    }

    /**
     * Toggles the status of a booking.
     *
     * @param Request $request Request object containing the booking ID and new status
     * @return \Illuminate\Http\JsonResponse JSON response containing the success status
     *                                       and a message
     */
    public function toggleStatus(Request $request)
    {
        $id = $request->id;
        $booking = Booking::findOrFail($id);
        if ($booking) {
            $booking->status = $status = $request->status == "pending" ? BookingStatus::Pending->value
            : ($request->status == "accepted"
                ? BookingStatus::Accepted->value
                : BookingStatus::Completed->value);
            $booking->save();
            return response()->json([
               'success' => true,
               'message' => 'Booking status updated successfully',
            ]);
        }
        return response()->json([
           'success' => false,
           'message' => 'Booking not found',
        ]);
    }
}
