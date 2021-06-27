<?php

namespace App\Infra\Presentation;

use App\Infra\Http\Controllers\Presentation;

final class ExportRegistrationPresenter implements Presentation
{
    public function output(array $data): string
    {
        return json_encode($data);
    }
}