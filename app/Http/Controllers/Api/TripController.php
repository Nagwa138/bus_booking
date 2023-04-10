<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TripResource;
use App\Interfaces\Repositories\ITripRepository;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class TripController extends Controller
{
    public function __construct(public ITripRepository $tripRepository)
    {
    }

    public function index(): AnonymousResourceCollection
    {
        $trips = $this->tripRepository->all();
        return TripResource::collection($trips);
    }
}
