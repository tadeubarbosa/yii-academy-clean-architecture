<?php

namespace App\Domain\ValueObjects;

class Cpf
{
    private string $cpf;

    public function __construct(string $cpf)
    {
        if ($this->checkCpfIsInvalid()) {
            throw new \DomainException('CPF is not valid!');
        }
        $this->cpf = $cpf;
    }

    private function checkCpfIsInvalid(): bool
    {
        $this->cpf = preg_replace('/\D+/', '', $this->cpf);
        if (strlen($this->cpf) !== 11) {
            return false;
        }
        // Verifica se foi informada uma sequência de digitos repetidos. Ex: 111.111.111-11
        if (preg_match('/(\d)\1{10}/', $this->cpf)) {
            return false;
        }
        // Faz o calculo para validar o CPF
        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $this->cpf[$c] * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($this->cpf[$c] !== $d) {
                return false;
            }
        }
        return true;
    }

    public function __toString(): string
    {
        return $this->cpf;
    }
}