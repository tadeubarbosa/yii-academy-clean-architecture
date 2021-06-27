<?php

namespace App\Infra\Http\Controllers;

use App\Application\UseCases\ExportRegistration\ExportRegistration;
use App\Application\UseCases\ExportRegistration\InputBoundary;
use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

final class ExportRegistrationController
{
    private Request $request;
    private Response $response;
    private ExportRegistration $useCase;

    public function __construct(Request $request, Response $response, ExportRegistration $useCase)
    {
        $this->request = $request;
        $this->response = $response;
        $this->useCase = $useCase;
    }

    public function handle(Presentation $presentation): Response
    {
        [$cpf, $filename, $path] = $this->request->getHeader('form_params');
        $inputBoundary = new InputBoundary($cpf, $filename, $path);

        $output = $this->useCase->handle($inputBoundary);

        $this->response->getBody()->write($presentation->output([
            'fullFileName' => $output->getFullFileName(),
        ]));

        return $this->response
            ->withHeader('Content-type', 'application/json')
            ->withStatus(200);
    }
}