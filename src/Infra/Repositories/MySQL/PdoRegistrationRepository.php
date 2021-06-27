<?php

namespace App\Infra\Repositories\MySQL;

use App\Domain\Entities\Registration;
use App\Domain\Repositories\LoadRegistrationRepository;
use App\Domain\ValueObjects\Cpf;
use App\Domain\ValueObjects\Email;
use DateTimeImmutable;
use DomainException;
use PDO;

class PdoRegistrationRepository implements LoadRegistrationRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * @throws \Exception
     */
    public function loadByRegistrationNumber(Cpf $cpf): Registration
    {
        $stmt = $this->pdo->prepare('SELECT * FROM `registrations` WHERE cpf = :cpf');
        $stmt->execute([':cpf' => (string) $cpf]);
        $record = $stmt->fetch();

        if (!$record) {
            throw new DomainException('There\'s no one registered with this CPF');
        }

        $registration = new Registration();
        $registration->setName($record['name'])
            ->setBirthDate(new DateTimeImmutable($record['birthdate']))
            ->setEmail(new Email($record['email']))
            ->setRegistrationAt(new DateTimeImmutable($record['registration_at']))
            ->setRegistrationNumber(new Cpf($record['cpf']));

        return $registration;
    }
}