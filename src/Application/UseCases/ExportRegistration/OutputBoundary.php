<?php

namespace App\Application\UseCases\ExportRegistration;

final class OutputBoundary
{
    private string $name;
    private string $email;
    private string $birthDate;
    private string $registrationNumber;
    private string $registrationAt;

    public function __construct(array $values)
    {
        $this->name = $values['name'] ?? '';
        $this->email = $values['email'] ?? '';
        $this->birthDate = $values['birthDate'] ?? '';
        $this->registrationNumber = $values['registrationNumber'] ?? '';
        $this->registrationAt = $values['registrationAt'] ?? '';
    }

    /**
     * @return mixed|string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed|string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return mixed|string
     */
    public function getBirthDate()
    {
        return $this->birthDate;
    }

    /**
     * @return mixed|string
     */
    public function getRegistrationNumber()
    {
        return $this->registrationNumber;
    }

    /**
     * @return mixed|string
     */
    public function getRegistrationAt()
    {
        return $this->registrationAt;
    }

}