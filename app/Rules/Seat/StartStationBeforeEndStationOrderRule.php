<?php

namespace App\Rules\Seat;

use App\Interfaces\Repositories\IStationRepository;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class StartStationBeforeEndStationOrderRule implements ValidationRule
{
    public function __construct(
        private mixed $startStationId
    )
    {}

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $startStation = app(IStationRepository::class)->findById($this->startStationId);
        $endStation = app(IStationRepository::class)->findById($value);

        if ($endStation->order < $startStation->order) {
            $fail('Destination station must be after start station in order!');
        }
    }
}
