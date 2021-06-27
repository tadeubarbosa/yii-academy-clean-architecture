<?php

use App\Application\UseCases\ExportRegistration\ExportRegistration;
use App\Application\UseCases\ExportRegistration\InputBoundary;
use App\Domain\Entities\Registration;
use App\Domain\ValueObjects\Cpf;
use App\Domain\ValueObjects\Email;
use App\Infra\Adapters\Html2PdfAdapter;
use App\Infra\Adapters\LocalStorageAdapter;
use App\Infra\Repositories\MySQL\PdoRegistrationRepository;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__.'/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__.'/../');
$dotenv->load();

$appConfig = require __DIR__.'/../config/app.php';

// Entities
$registration = new Registration();
$registration->setName('Tadeu')
    ->setEmail(new Email('tadeufbarbosa@gmail.com'))
    ->setBirthDate(new DateTimeImmutable('1994-03-24'))
    ->setRegistrationNumber(new Cpf('12345678910'))
    ->setRegistrationAt(new DateTimeImmutable('2021-03-11'));

// Use cases
$dsn = sprintf(
    'mysql:host=%s;port=%s;dbname=%s;charset=%s',
    $appConfig['db']['host'],
    $appConfig['db']['port'],
    $appConfig['db']['dbname'],
    $appConfig['db']['charset'],
);
$pdo = new \PDO($dsn, $appConfig['db']['username'], $appConfig['db']['password'], [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_PERSISTENT => true,
]);

$loadRegistrationRepository = new PdoRegistrationRepository($pdo);
$pdfExport = new Html2PdfAdapter();
$storage = new LocalStorageAdapter();

$exportRegistrationUseCase = new ExportRegistration();
$inputBoundary = new InputBoundary('12345678911', 'example', __DIR__.'/../storage');
$output = $exportRegistrationUseCase->handle($inputBoundary);