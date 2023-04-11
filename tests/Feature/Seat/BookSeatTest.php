<?php

namespace Tests\Feature\Seat;

use App\Models\Seat;
use App\Models\Station;
use App\Models\Trip;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class BookSeatTest extends TestCase
{
    use RefreshDatabase,
        WithFaker;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    public function testUserMustBeAuthenticated()
    {
        $response = $this->json('post', '/api/seats/book', []);
        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    public function testUserBookSeatSuccessfully()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $trip = Trip::first();
        $seat = $trip->bus->seats()->first();
        $response = $this->json('post', '/api/seats/book', [
            'seat_id' => $seat->id,
            'start_station_id' => $trip->start_station_id,
            'end_station_id' => $trip->end_station_id
        ]);

        $response->assertOk();

        $response->assertJsonStructure([
            'data' => [
                'id',
                'start_station' => [
                    'id', 'name'
                ],
                'end_station' => [
                    'id', 'name'
                ]
            ]
        ]);

        $this->assertEquals('Seat booked successfully!', $response->json()['message']);
        $this->assertEquals($seat->id, $response->json()['data']['id']);
        $this->assertEquals($trip->start_station_id, $response->json()['data']['start_station']['id']);
        $this->assertEquals($trip->end_station_id, $response->json()['data']['end_station']['id']);
    }

    public function testSeatIdRequired()
    {
        $this->validateInput('seat_id', []);
    }

    public function testSeatIdInt()
    {
        $data = [
            'seat_id' => Str::random(5)
        ];
        $this->validateInput('seat_id', $data);
    }

    public function testSeatIdShouldExists()
    {
        $data = [
            'seat_id' => rand(1000, 2000)
        ];
        $this->validateInput('seat_id', $data);
    }

    public function testStartStationIdRequired()
    {
        $seat = Seat::first();
        $data = [
            'seat_id' => $seat->id
        ];
        $this->validateInput('start_station_id', $data);
    }

    public function testEndStationIdRequired()
    {
        $seat = Seat::first();
        $startStation = Station::first();
        $data = [
            'seat_id' => $seat->id,
            'start_station_id' => $startStation->id
        ];
        $this->validateInput('end_station_id', $data);
    }

    public function testStartStationIdInt()
    {
        $seat = Seat::first();
        $data = [
            'seat_id' => $seat->id,
            'start_station_id' => Str::random(5)
        ];
        $this->validateInput('start_station_id', $data);
    }

    public function testEndStationIdInt()
    {
        $seat = Seat::first();
        $startStation = Station::first();
        $data = [
            'seat_id' => $seat->id,
            'start_station_id' => $startStation->id,
            'end_station_id' => Str::random(5)
        ];
        $this->validateInput('end_station_id', $data);
    }

    public function testStartIdShouldExists()
    {
        $seat = Seat::first();
        $data = [
            'seat_id' => $seat->id,
            'start_station_id' => rand(1000, 2000)
        ];
        $this->validateInput('start_station_id', $data);
    }

    public function testEndIdShouldExists()
    {
        $seat = Seat::first();
        $startStation = Station::first();
        $data = [
            'seat_id' => $seat->id,
            'start_station_id' => $startStation->id,
            'end_station_id' => rand(1000, 2000)
        ];
        $this->validateInput('end_station_id', $data);
    }

    public function testDestinationOrderMustBeAfterStart()
    {
        $seat = Seat::first();
        $start = Station::orderBy('order', 'DESC')->first()->id;
        $end = Station::first()->id;

        $data = [
            'seat_id' => $seat->id,
            'start_station_id' => $start,
            'end_station_id' => $end
        ];

        $this->validateInput('end_station_id', $data);
    }

    private function validateInput($input, $data)
    {
        $this->actingAs(User::factory()->create());
        $response = $this->json('post', '/api/seats/book', $data);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors($input);
    }
}
