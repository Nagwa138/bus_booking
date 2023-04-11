<?php

namespace App\Http\Requests\Seat;

use App\Rules\Seat\StartStationBeforeEndStationOrderRule;
use Illuminate\Foundation\Http\FormRequest;

class BookSeatRequest extends FormRequest
{
    protected $stopOnFirstFailure = true;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'seat_id' => ['required', 'int', 'exists:seats,id'],
            'start_station_id' => ['required', 'int', 'exists:stations,id'],
            'end_station_id' => ['bail', 'required', 'int', 'exists:stations,id', new StartStationBeforeEndStationOrderRule($this->get('start_station_id'))],
        ];
    }
}
