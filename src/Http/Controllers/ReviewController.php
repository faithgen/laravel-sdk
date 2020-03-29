<?php

namespace FaithGen\SDK\Http\Controllers;

use FaithGen\SDK\Http\Requests\SendRevealRequest;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use InnoFlash\LaraStart\Traits\APIResponses;

class ReviewController extends Controller
{
    use APIResponses;

    /**
     * Sends a review by the given ministry.
     *
     * @param SendRevealRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    function sendReview(SendRevealRequest $request)
    {
        auth()->user()->reviews()->create($request->validated());

        return $this->successResponse('We received your review, thanks for getting in touch');
    }
}
