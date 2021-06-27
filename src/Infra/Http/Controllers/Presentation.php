<?php

namespace App\Infra\Http\Controllers;

interface Presentation
{
    public function output(array $data): string;
}