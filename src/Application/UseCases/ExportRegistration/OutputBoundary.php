<?php

namespace App\Application\UseCases\ExportRegistration;

final class OutputBoundary
{
    private string $fullFileName;

    public function __construct(string $fullFileName)
    {
        $this->fullFileName = $fullFileName;
    }

    /**
     * @return string
     */
    public function getFullFileName(): string
    {
        return $this->fullFileName;
    }
}