<?php

namespace App\Http\Requests\Seat;

use App\Rules\Seat\StartStationBeforeEndStationOrderRule;
use Illuminate\Foundation\Http\FormRequest;

class ListAvailableTripSeatsRequest extends FormRequest
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
            'trip_id' => ['required', 'int', 'exists:trips,id'],
            'start_station_id' => ['required', 'int', 'exists:stations,id'],
            'end_station_id' => ['bail', 'required', 'int', 'exists:stations,id', new StartStationBeforeEndStationOrderRule($this->get('start_station_id'))],
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge(['trip_id' => $this->route('trip')]);
    }
}
