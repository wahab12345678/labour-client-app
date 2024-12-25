<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\ReviewService;
use App\Http\Resources\ReviewResource;

class ReviewController extends Controller
{
    public function index()
    {
        return view('admin.reviews.index');
    }

    public function list(ReviewService $reviewService, Request $request)
    {
        $reviews = $reviewService->list();
        $resource = ReviewResource::collection($reviews);
        return response()->json(['data' => $resource]);
    }
}
