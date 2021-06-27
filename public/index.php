<?php

use App\Domain\Entities\Registration;
use App\Domain\ValueObjects\Cpf;
use App\Domain\ValueObjects\Email;

require_once __DIR__.'/../vendor/autoload.php';

$registration = new Registration();
$registration->setName('Tadeu')
    ->setEmail(new Email('tadeufbarbosa@gmail.com'))
    ->setBirthDate(new DateTimeImmutable('1994-03-24'))
    ->setRegistrationNumber(new Cpf('123.456.789-12'))
    ->setRegistrationAt(new DateTimeImmutable('2021-03-11'));