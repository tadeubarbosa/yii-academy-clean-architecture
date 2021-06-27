<?php

namespace App\Application\Contracts;

interface Storage
{
    public function store(string $filename, string $path, string $content);
}