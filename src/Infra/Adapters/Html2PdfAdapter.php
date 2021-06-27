<?php

namespace App\Infra\Adapters;

use App\Application\Contracts\ExportRegistrationPdfExporter;
use App\Domain\Entities\Registration;

final class Html2PdfAdapter implements ExportRegistrationPdfExporter
{
    public function generate(Registration $registration): string
    {
        // TODO: Implement generate() method.
    }
}