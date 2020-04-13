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

    public function comment(ImageCommentRequest $request)
    {
        return CommentHelper::createComment($this->imageService->getImage(), $request);
    }

    public function comments(Request $request, Image $image)
    {
        return CommentHelper::getComments($image, $request);
    }
}
