<?php

namespace App\DelegationList\Application;

use App\DelegationList\Infrastructure\DelegationDTO;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DelegationResource extends JsonResource
{
    /**
     * @var DelegationDTO
     */
    public $resource;
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'start' => $this->resource->getStart(),
            'end' => $this->resource->getEnd(),
            'country' => $this->resource->getCountryCode(),
            'amount_due' => $this->resource->getAmountDue(),
            'currency' => 'PLN', // here probably I would take it from country model, but it was not in a task scope
        ];
    }
}
