<?php

namespace App\Application\Contracts;

interface PdfExporter
{
    public function generate(array $data): string;
}