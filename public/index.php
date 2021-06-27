<?php

use App\Application\UseCases\ExportRegistration\ExportRegistration;
use App\Application\UseCases\ExportRegistration\InputBoundary;
use App\Domain\Entities\Registration;
use App\Domain\ValueObjects\Cpf;
use App\Domain\ValueObjects\Email;
use App\Infra\Adapters\Html2PdfAdapter;

require_once __DIR__.'/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__.'/../');
$dotenv->load();

$appConfig = require __DIR__.'/../config/app.php';

// Entities
$registration = new Registration();
$registration->setName('Tadeu')
    ->setEmail(new Email('tadeufbarbosa@gmail.com'))
    ->setBirthDate(new DateTimeImmutable('1994-03-24'))
    ->setRegistrationNumber(new Cpf('123.456.789-12'))
    ->setRegistrationAt(new DateTimeImmutable('2021-03-11'));

// Use cases
$loadRegistrationRepository = new stdClass();
$pdfExport = new Html2PdfAdapter();
$storage = new stdClass();

$exportRegistrationUseCase = new ExportRegistration();
$inputBoundary = new InputBoundary('12345678911', 'example', __DIR__.'/../storage');
$output = $exportRegistrationUseCase->handle($inputBoundary);