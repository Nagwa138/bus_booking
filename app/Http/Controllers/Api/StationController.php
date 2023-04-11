<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\StationResource;
use App\Interfaces\Repositories\IStationRepository;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class StationController extends Controller
{
    public function __construct(public IStationRepository $stationRepository)
    {
    }

    public function index(): AnonymousResourceCollection
    {
        $stations = $this->stationRepository->all('order');
        return StationResource::collection($stations);
    }
}
