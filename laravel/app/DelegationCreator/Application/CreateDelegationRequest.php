<?php

namespace App\DelegationCreator\Application;

use Illuminate\Foundation\Http\FormRequest;

class CreateDelegationRequest extends FormRequest
{
    public function authorize(): bool
    {
        // app has no authentication so we cannot add authorization
        return true;
    }
    public function rules(): array
    {
        return [
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'country_code' => 'required|string|exists:countries,code',
        ];
    }
    public function getStartDate(): string
    {
        return strval($this->input('start_date'));
    }
    public function getEndDate(): string
    {
        return strval($this->input('end_date'));
    }
    public function getCountryCode(): string
    {
        return strval($this->input('country_code'));
    }
}
