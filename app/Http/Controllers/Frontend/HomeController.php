<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ContactUs;
use App\Models\Booking;
use App\Models\Review;
use App\Models\User;
use App\Models\UserMeta;
use App\Models\Category;
use App\Enums\UserStatus;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Services\CategoryService;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

class HomeController extends Controller
{
    public function index(CategoryService $categories)
    {

        return view('frontend.index');

        // return view('frontend.index');
    }

    public function about()
    {
        return view('frontend.about');
    }

    public function contact()
    {
        return view('frontend.contact');
    }

    public function storeContact(Request $request)
    {
        $validatedData = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|max:255',
            'phone'   => 'required|string|max:20',
            'message' => 'required|string|max:1000',
        ]);
        ContactUs::create([
            'name'       => $validatedData['name'],
            'email'      => $validatedData['email'],
            'phone'      => $validatedData['phone'],
            'message'    => $validatedData['message'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        return back()->with('message', 'Your message has been sent successfully.');
    }

    public function client()
    {
        return view('frontend.client');
    }

    public function storeClient(Request $request)
    {
        try {
            // Start transaction
            DB::beginTransaction();
            // Validate data
            $validatedData = $request->validate([
                'name'    => 'required|string|max:255',
                'phone'   => 'required|string|regex:/^[0-9]{10,20}$/|unique:users,phone',
                'cnic_no' => 'required|numeric|digits:13|unique:user_metas,cnic_no',
                'address' => 'required|string|max:255',
            ]);
            // Create the user
            $user = User::create([
                'name'     => $validatedData['name'],
                'email'    => $validatedData['phone'] . '@gmail.com',  // You might want to change email generation logic
                'password' => Hash::make('password'),  // Use a secure password (generate a random one or ask user to set it)
                'phone'    => $validatedData['phone'],
                'status'   => UserStatus::Inactive->value,
            ]);
            // Create user meta
            UserMeta::create([
                'user_id'  => $user->id,
                'cnic_no'  => $validatedData['cnic_no'],
                'address'  => $validatedData['address'],
            ]);
            // Assign role
            $user->assignRole('client');
            // Commit transaction
            DB::commit();
            return back()->with('message', 'Client Registered Successfully.');
        } catch (ValidationException $e) {
            DB::rollBack();
            return back()->withErrors($e->errors())->withInput();
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with('message', $th->getMessage());
        }
    }

    public function services()
    {
        return view('frontend.services');
    }

    public function serviceDetail($slug)
    {
        $category = Category::where('slug', $slug)->first();
        if (!$category) {
            abort(404);
        }
        return view('frontend.service-detail', compact('category'));
    }

    public function contractorDetail($slug)
    {
        $contractor = User::whereHas('meta', function($query) use ($slug) {
            $query->where('slug', $slug);
        })->first();
        if (!$contractor) {
            abort(404);
        }
        return view('frontend.contractor-detail', compact('contractor'));
    }

    public function feedbackForm($url)
    {
        try {
            $id = Crypt::decryptString($url);
            $bookingExist = Booking::find($id);
            if (!$bookingExist) {
                abort(404, 'Booking not found');
            }
            $reviewExist = Review::where(['booking_id' => $bookingExist->id])->first();
            if ($reviewExist) {
                abort(404, 'Feedback already submitted for this booking');
            }
            return view('feedback.form', compact('id', 'url'));
        } catch (DecryptException $e) {
            abort(404, 'Invalid Feedback Link');
        }
    }

    public function feedbackFormStore(Request $request)
    {
        $validatedData = request()->validate([
            'rating'      => ['required', 'integer','min:1','max:5'],
            'comment'   => ['required','string','min:5','max:500'],
            'url' => ['required','string']
        ]);
        $id = Crypt::decryptString($validatedData['url']);
        $bookingExist = Booking::find($id);
        if (!$bookingExist) {
            abort(404, 'Booking not found');
        }
        $reviewExist = Review::where(['booking_id' => $bookingExist->id])->first();
        if ($reviewExist) {
            abort(404, 'Feedback already submitted for this booking');
        }
        Review::create([
            'booking_id' => $bookingExist->id,
            'rating'      => $validatedData['rating'],
            'comment'   => $validatedData['comment'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        return redirect('/')->withSuccess('Feedback submitted successfully');
    }
}
