<?php

namespace App\Services;
use App\Models\Publisher;
use Illuminate\Support\Facades\DB;

class PublisherService
{
    public function getAllPublishers()
    {
        return Publisher::all();
    }

    public function createPublisher(array $data)
    {
        return DB::transaction(function () use ($data) {
            return Publisher::create($data);
        });
    }
}