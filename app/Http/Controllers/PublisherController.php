<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PublisherService;

class PublisherController extends Controller
{
    public function __construct(
        protected PublisherService $publisherService
    ) {}

    public function index()
    {
        $publishers = $this->publisherService->getAllPublishers();

        return response()->json([
            'success' => true,
            'data' => $publishers
        ]);
    }
}
