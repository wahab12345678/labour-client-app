<?php

namespace App\Services;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\BookingLabour;
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
        try {
            DB::beginTransaction();
            $labourIds = $request->labour_id; // Array of selected labour IDs
            // Fetch conflicting labours
            $conflictingLabours = DB::table('booking_labours')
            ->join('bookings', 'booking_labours.booking_id', '=', 'bookings.id')
            ->whereIn('booking_labours.labour_id', $labourIds)
            ->whereIn('bookings.status', ['pending', 'accepted'])
            ->where(function ($query) use ($request) {
                $query->whereBetween('bookings.start_date', [$request->start_date, $request->end_date])
                    ->orWhereBetween('bookings.end_date', [$request->start_date, $request->end_date])
                    ->orWhere(function ($query) use ($request) {
                        $query->where('bookings.start_date', '<=', $request->start_date)
                            ->where('bookings.end_date', '>=', $request->end_date);
                    });
            })
            ->pluck('booking_labours.labour_id');
            if ($conflictingLabours->isNotEmpty()) {
                // Fetch the names of the unavailable labours
                $unavailableLabours = DB::table('users')
                    ->whereIn('id', $conflictingLabours)
                    ->pluck('name');
                return response()->json([
                    'success' => false,
                    'message' => 'The following labours are already booked for this date range: ' . $unavailableLabours->join(', '),
                ]);
            }
            // Create the new booking
            $booking = Booking::create([
                'client_id' => $request->client_id,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'status' => $request->status,
                'price' => $request->price,
                'description' => $request->description
            ]);
            // Associate the booking with the selected labours
            foreach ($labourIds as $labourId) {
                BookingLabour::create([
                    'booking_id' => $booking->id,
                    'labour_id' => $labourId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Booking created successfully'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    /**
     * Update an existing booking in the database.
     *
     * This method updates the details of an existing booking, including
     * client details, date range, price, and associated labours. It also
     * checks for conflicts with existing bookings for the new labours
     * before updating. If conflicts are found, the booking update is aborted.
     *
     * @param BookingRequest $request The validated request object containing
     *                                the booking details to be updated.
     * @return \Illuminate\Http\JsonResponse JSON response indicating the success
     *                                       or failure of the operation.
     */
    public function update(BookingRequest $request)
    {
        try {
            DB::beginTransaction();
            $id = $request->booking_id;
            $labourIds = $request->labour_id; // Array of selected labour IDs
            $booking = Booking::find($id);
            if (!$booking) {
                return response()->json([
                    'success' => false,
                    'message' => 'Booking not found'
                ]);
            }
            // Get existing labour IDs for the booking
            $existingLabourIds = BookingLabour::where('booking_id', $id)->pluck('labour_id')->toArray();
            // Identify new labour IDs (not in the existing list)
            $newLabourIds = array_diff($labourIds, $existingLabourIds);
            // Check for overlapping bookings only for the new labours
            if (!empty($newLabourIds)) {
                $conflictingLabours = DB::table('booking_labours')
                    ->join('bookings', 'booking_labours.booking_id', '=', 'bookings.id')
                    ->whereIn('booking_labours.labour_id', $newLabourIds)
                    ->where('bookings.id', '!=', $id) // Exclude current booking
                    ->whereIn('bookings.status', ['pending', 'accepted'])
                    ->where(function ($query) use ($request) {
                        $query->whereBetween('bookings.start_date', [$request->start_date, $request->end_date])
                            ->orWhereBetween('bookings.end_date', [$request->start_date, $request->end_date])
                            ->orWhere(function ($query) use ($request) {
                                $query->where('bookings.start_date', '<=', $request->start_date)
                                    ->where('bookings.end_date', '>=', $request->end_date);
                            });
                    })
                    ->pluck('booking_labours.labour_id');
                if ($conflictingLabours->isNotEmpty()) {
                    // Fetch the names of the unavailable labours
                    $unavailableLabours = DB::table('users')
                        ->whereIn('id', $conflictingLabours)
                        ->pluck('name');

                    return response()->json([
                        'success' => false,
                        'message' => 'The following labours are already booked for this date range: ' . $unavailableLabours->join(', '),
                    ]);
                }
            }
            // Update booking details
            $booking->update([
                'client_id'    => $request->client_id,
                'start_date'   => $request->start_date,
                'end_date'     => $request->end_date,
                'price'        => $request->price,
                'description'  => $request->description
            ]);
            // Delete existing booking labours and re-associate with the selected labours
            BookingLabour::where('booking_id', $id)->delete();
            foreach ($labourIds as $labourId) {
                BookingLabour::create([
                    'booking_id' => $booking->id,
                    'labour_id'  => $labourId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Booking updated successfully'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
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
            return response()->json(['success' => false, 'message' => 'Booking not found.']);
        }
        try {
            DB::beginTransaction();
            // Delete related labours from the `booking_labours` table
            BookingLabour::where('booking_id', $id)->delete();
            // Delete the booking
            $booking->delete();
            DB::commit();
            return response()->json(['success' => true, 'message' => 'Booking and associated labours deleted successfully.']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Error deleting booking: ' . $e->getMessage()]);
        }
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

    /**
     * Retrieve a booking by ID and its associated labours.
     *
     * @param int $id The ID of the booking to retrieve
     * @return \Illuminate\Http\JsonResponse JSON response containing the booking
     *                                       details and an array of associated
     *                                       labour IDs
     */
    public function edit($id)
    {
        $BookingDetail = Booking::where('id', $id)->first();
        $labourIds = $BookingDetail->labours->pluck('id'); // Extract labour IDs
        return response()->json([
            'booking'   => $BookingDetail,
            'labour_ids' => $labourIds
        ]);
    }
}
