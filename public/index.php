<?php

use App\Application\UseCases\ExportRegistration\ExportRegistration;
use App\Domain\Entities\Registration;
use App\Domain\ValueObjects\Cpf;
use App\Domain\ValueObjects\Email;
use App\Infra\Adapters\DomPdfAdapter;
use App\Infra\Adapters\LocalStorageAdapter;
use App\Infra\Http\Controllers\ExportRegistrationController;
use App\Infra\Presentation\ExportRegistrationPresenter;
use App\Infra\Repositories\MySQL\PdoRegistrationRepository;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;

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
    ->setRegistrationNumber(new Cpf('24809543072'))
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
$pdfExport = new DomPdfAdapter();
$storage = new LocalStorageAdapter();

$uri = sprintf(
    '%s://%s%s',
    $_SERVER['REQUEST_SCHEME'],
    $_SERVER['SERVER_NAME'],
    $_SERVER['REQUEST_URI'],
);

$exportRegistrationUseCase = new ExportRegistration($loadRegistrationRepository, $pdfExport, $storage);

$headers = [
    'form_params' => [
        '24809543072',
        'cliente-lorem.pdf',
        __DIR__ . '/../storage/registrations'
    ],
];
$request = new Request($_SERVER['REQUEST_METHOD'], $uri, $headers);
$response = new Response();

// Controllers
$exportRegistrationController = new ExportRegistrationController(
    $request,
    $response,
    $exportRegistrationUseCase
);

$exportRegistrationPresenter = new ExportRegistrationPresenter();
echo $exportRegistrationController->handle($exportRegistrationPresenter)->getBody();