<?php

namespace App\Domain\ValueObjects;

class Email
{
    private string $email;

    public function __construct(string $email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new \DomainException('Email is not valid!');
        }
        $this->email = $email;
    }

    public function __toString(): string
    {
        return $this->email;
    }
}