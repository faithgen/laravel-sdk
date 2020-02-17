<?php

namespace FaithGen\SDK\Http\Controllers;

use Illuminate\Http\Request;
use FaithGen\SDK\Models\Image;
use Illuminate\Routing\Controller;
use FaithGen\SDK\Helpers\CommentHelper;
use FaithGen\SDK\Services\ImageService;
use FaithGen\Gallery\Http\Requests\ImageCommentRequest;

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
