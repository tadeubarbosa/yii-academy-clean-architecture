<?php

namespace App\Application\UseCases\ExportRegistration;

final class InputBoundary
{
    private string $registrationNumber;
    private string $pdfFileName;
    private string $path;

    public function __construct(
        string $registrationNumber,
        string $pdfFileName,
        string $path
    )
    {
        $this->registrationNumber = $registrationNumber;
        $this->pdfFileName = $pdfFileName;
        $this->path = $path;
    }

    /**
     * @return string
     */
    public function getRegistrationNumber(): string
    {
        return $this->registrationNumber;
    }

    /**
     * @return string
     */
    public function getPdfFileName(): string
    {
        return $this->pdfFileName;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }
}