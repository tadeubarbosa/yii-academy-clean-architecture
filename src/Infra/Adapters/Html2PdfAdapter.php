<?php

namespace App\Infra\Adapters;

use App\Application\Contracts\ExportRegistrationPdfExporter;
use App\Domain\Entities\Registration;
use Spipu\Html2Pdf\Exception\ExceptionFormatter;
use Spipu\Html2Pdf\Exception\Html2PdfException;
use Spipu\Html2Pdf\Html2Pdf;

final class Html2PdfAdapter implements ExportRegistrationPdfExporter
{
    public function generate(Registration $registration): string
    {
        $html2pdf = new Html2Pdf('P', 'A4', 'fr');
        try {
            $content = "<p>Nome: {$registration->getName()}</p><p>CPF: {$registration->getRegistrationNumber()}}</p>";

            $html2pdf->setDefaultFont('Arial');
            $html2pdf->writeHTML($content);
            return $html2pdf->output('', 'S');
        } catch (Html2PdfException $e) {
            $html2pdf->clean();

            $formatter = new ExceptionFormatter($e);
            echo $formatter->getHtmlMessage();
        }
    }
}