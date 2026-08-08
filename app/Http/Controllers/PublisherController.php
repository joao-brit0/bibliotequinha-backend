<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PublisherService;
use App\Http\Requests\StorePublisherRequest;    

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

    public function store(StorePublisherRequest $request)
    {
        $validatedData = $request->validated();

        $publisher = $this->publisherService->createPublisher($validatedData);

        return response()->json([
            'success' => true,
            'data' => $publisher
        ], 201);
    }
}
