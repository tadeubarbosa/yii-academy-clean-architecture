<?php

namespace App\Domain\ValueObjects;

class Cpf
{
    private string $cpf;

    public function __construct(string $cpf)
    {
        if ($this->checkCpfIsInvalid($cpf)) {
            throw new \DomainException('CPF is not valid');
        }
        $this->cpf = $cpf;
    }

    private function checkCpfIsInvalid(string $cpf): bool
    {
        $cpf = preg_replace('/\D+/', '', $cpf);
        if (strlen($cpf) !== 11) {
            return true;
        }
        // Verifica se foi informada uma sequência de digitos repetidos. Ex: 111.111.111-11
        if (preg_match('/(\d)\1{10}/', $cpf)) {
            return true;
        }
        // Faz o calculo para validar o CPF
        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf[$c] * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf[$c] != $d) {
                return true;
            }
        }
        return false;
    }

    public function __toString(): string
    {
        return $this->cpf;
    }
}