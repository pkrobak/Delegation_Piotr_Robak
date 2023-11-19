<?php

namespace src\DelegationCreator\Domain;

interface CreateDelegationRepositoryInterface
{
    public function create(CreateDelegationInterface $delegation);
}
