<?php

namespace App\Infra\Cli\Commands;

use App\Application\UseCases\ExportRegistration\ExportRegistration;
use App\Application\UseCases\ExportRegistration\InputBoundary;
use App\Infra\Http\Controllers\Presentation;

class ExportRegistrationCommand
{
    private ExportRegistration $useCase;

    public function __construct(ExportRegistration $useCase)
    {
        $this->useCase = $useCase;
    }

    public function handle(Presentation $presentation): string
    {
        $payload = [
            'cpf' => '24809543072',
            'filename' => 'cliente-lorem.pdf',
            'path' => __DIR__ . '/../../../../storage/registrations'
        ];

        $inputBoundary = new InputBoundary($payload['cpf'], $payload['filename'], $payload['path']);

        $output = $this->useCase->handle($inputBoundary);

        return $presentation->output([
            'fullFileName' => $output->getFullFileName(),
        ]);
    }
}