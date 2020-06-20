<?php

namespace FaithGen\SDK\Http\Controllers;

use FaithGen\Gallery\Http\Requests\ImageCommentRequest;
use FaithGen\SDK\Helpers\CommentHelper;
use FaithGen\SDK\Models\Image;
use FaithGen\SDK\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ImageController extends Controller
{
    protected $imageService;

    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
    }

    /**
     * Sends a comment to an image.
     *
     * @param \FaithGen\Gallery\Http\Requests\ImageCommentRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function comment(ImageCommentRequest $request)
    {
        return CommentHelper::createComment($this->imageService->getImage(), $request);
    }

    /**
     * Fetches the comments for this image.
     *
     * @param \Illuminate\Http\Request $request
     * @param \FaithGen\SDK\Models\Image $image
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function comments(Request $request, Image $image)
    {
        return CommentHelper::getComments($image, $request);
    }
}
