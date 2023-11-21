<?php

namespace App\DelegationCreator\Domain;

interface CreateDelegationRepositoryInterface
{
    public function create(CreateDelegationInterface $delegation);
}
