<?php

namespace App\Services;
use App\Models\Publisher;

class PublisherService
{
    public function getAllPublishers()
    {
        return Publisher::all();
    }
}