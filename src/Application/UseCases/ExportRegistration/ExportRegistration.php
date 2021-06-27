<?php

namespace App\Application\UseCases\ExportRegistration;

use App\Application\Contracts\PdfExporter;
use App\Application\Contracts\Storage;
use App\Domain\Repositories\LoadRegistrationRepository;
use App\Domain\ValueObjects\Cpf;

final class ExportRegistration
{
    private LoadRegistrationRepository $repository;
    private PdfExporter $pdfExporter;
    private Storage $storage;

    public function __construct(
        LoadRegistrationRepository $repository,
        PdfExporter $pdfExporter,
        Storage $storage
    )
    {
        $this->repository = $repository;
        $this->pdfExporter = $pdfExporter;
        $this->storage = $storage;
    }

    public function handle(InputBoundary $input): OutputBoundary
    {
        $cpf = new Cpf($input->getRegistrationNumber());
        $registration = $this->repository->loadByRegistrationNumber($cpf);
        $registrationArray = [
            'name' => $registration->getName(),
            'email' => (string)$registration->getEmail(),
            'birthDate' => $registration->getBirthDate()->format('Y-m-d H:i:s'),
            'registrationNumber' => (string)$registration->getRegistrationNumber(),
            'registrationAt' => $registration->getRegistrationAt()->format('Y-m-d H:i:s'),
        ];

        $fileContent = $this->pdfExporter->generate($registrationArray);
        $this->storage->store($input->getPdfFileName(), $input->getPath(), $fileContent);

        return new OutputBoundary($input->getPath().DIRECTORY_SEPARATOR.$input->getPdfFileName());
    }
}