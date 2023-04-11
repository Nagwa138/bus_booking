<?php

namespace Tests\Feature\Seat;

use App\Models\Seat;
use App\Models\Station;
use App\Models\Trip;
use App\Models\User;
use Database\Seeders\StationSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class ListAvailableSeatsTest extends TestCase
{
    use RefreshDatabase,
        WithFaker;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(StationSeeder::class);
    }

    public function testListAvailableSeatsSuccess()
    {
        $this->withoutExceptionHandling();
        $user = User::factory()->create();
        $this->actingAs($user);

        $firstStation = Station::first();
        $finalStation = Station::factory()->create(['order' => $firstStation->order + 5]);

        $trip = Trip::factory()->create([
            'start_station_id' => $firstStation->id,
            'end_station_id' => $finalStation->id,
        ]);

        Seat::factory(5)->create([
            'start_station_id' => $trip->start_station_id,
            'end_station_id' => $trip->end_station_id,
            'bus_id' => $trip->bus_id
        ]);

        Seat::factory(7)->create([
            'start_station_id' => null,
            'end_station_id' => null,
            'user_id' => null,
            'bus_id' => $trip->bus_id
        ]);

        $response = $this->json('get','/api/seats/list/'.$trip->id, [
            'start_station_id' => $trip->start_station_id,
            'end_station_id' => $trip->end_station_id
        ]);

        $seatsCount = Seat::where([
            'start_station_id' => $trip->start_station_id,
            'end_station_id' => $trip->end_station_id,
            'bus_id' => $trip->bus_id
        ])->whereNotNull('user_id')->count();

        $data = $response->json()['data'];

        $this->assertCount((Seat::where('bus_id', $trip->bus_id)->count() - $seatsCount), $data);
    }

    // todo :: test 3 levels in in-between station to book

    public function testUserListSeatWillBeAvailableInCrossStation()
    {
        $this->withoutExceptionHandling();
        $user = User::factory()->create();
        $this->actingAs($user);

        $firstStation = Station::first();
        $finalStation = Station::factory()->create(['order' => $firstStation->order + 5]);
        $middleStation = Station::factory()->create(['order' => $finalStation->order - 1]);

        $trip = Trip::factory()->create([
            'start_station_id' => $firstStation->id,
            'end_station_id' => $finalStation->id,
        ]);

        Seat::factory(5)->create([
            'start_station_id' => $trip->start_station_id,
            'end_station_id' => $trip->end_station_id,
            'bus_id' => $trip->bus_id
        ]);

        Seat::factory(5)->create([
            'start_station_id' => null,
            'end_station_id' => null,
            'user_id' => null,
            'bus_id' => $trip->bus_id
        ]);

        Seat::factory(2)->create([
            'start_station_id' => $trip->start_station_id,
            'end_station_id' => $middleStation->id,
            'bus_id' => $trip->bus_id
        ]);

        $response = $this->json('get','/api/seats/list/'.$trip->id, [
            'start_station_id' => $middleStation->id,
            'end_station_id' => $trip->end_station_id
        ]);

        $seatsCount = Seat::where([
            'start_station_id' => $trip->start_station_id,
            'end_station_id' => $trip->end_station_id,
            'bus_id' => $trip->bus_id
        ])->whereNotNull('user_id')->count();

        $data = $response->json()['data'];

        $this->assertCount((Seat::where('bus_id', $trip->bus_id)->count() - $seatsCount), $data);
    }

    public function testDestinationOrderMustBeAfterStart()
    {
        $trip = Trip::factory()->create();
        $start = Station::orderBy('order', 'DESC')->first()->id;
        $end = Station::first()->id;

        $data = [
            'start_station_id' => $start,
            'end_station_id' => $end
        ];

        $this->validateInput('end_station_id', $data, $trip->id);
    }

    public function testTripIdShouldBeExists()
    {
        $tripId = rand(1,10);
        $this->validateInput('trip_id', [], $tripId);
    }

    public function testStartStationIdRequired()
    {
        $tripId = Trip::factory()->create()->id;
        $this->validateInput('start_station_id', [], $tripId);
    }


    public function testStartStationIdShouldBeInteger()
    {
        $tripId = Trip::factory()->create()->id;
        $data = [
            'start_station_id' => Str::random(5)
        ];
        $this->validateInput('start_station_id', $data, $tripId);
    }

    public function testStartStationIdShouldExist()
    {
        $tripId = Trip::factory()->create()->id;
        $data = [
            'start_station_id' => rand(10000,1000000)
        ];
        $this->validateInput('start_station_id', $data, $tripId);
    }

    public function testEndStationIdRequired()
    {
        $tripId = Trip::factory()->create()->id;
        $data = [
            'start_station_id' => Station::first()->id
        ];
        $this->validateInput('end_station_id', $data, $tripId);
    }

    public function testEndStationIdShouldBeInteger()
    {
        $tripId = Trip::factory()->create()->id;
        $data = [
            'start_station_id' => Station::first()->id,
            'end_station_id' => Str::random(5)
        ];
        $this->validateInput('end_station_id', $data, $tripId);
    }

    public function testEndStationIdShouldExist()
    {
        $tripId = Trip::factory()->create()->id;
        $data = [
            'start_station_id' => Station::first()->id,
            'end_station_id' => rand(10000,1000000)
        ];
        $this->validateInput('end_station_id', $data, $tripId);
    }

    private function validateInput($input, $data, $tripId)
    {
        $this->actingAs(User::factory()->create());
        $response = $this->json('get', '/api/seats/list/' . $tripId, $data);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors($input);
    }
}
