<?php

namespace App\Application\UseCases\ExportRegistration;

final class InputBoundary
{
    private string $registrationNumber;

    public function __construct(string $registrationNumber)
    {
        $this->registrationNumber = $registrationNumber;
    }

    /**
     * @return string
     */
    public function getRegistrationNumber(): string
    {
        return $this->registrationNumber;
    }
}