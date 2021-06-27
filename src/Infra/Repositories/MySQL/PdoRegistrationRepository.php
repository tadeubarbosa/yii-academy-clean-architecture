<?php

namespace App\Infra\Repositories\MySQL;

use App\Domain\Entities\Registration;
use App\Domain\Exceptions\RegistrationNotFoundException;
use App\Domain\Repositories\LoadRegistrationRepository;
use App\Domain\ValueObjects\Cpf;
use App\Domain\ValueObjects\Email;
use DateTimeImmutable;
use DomainException;
use Exception;
use PDO;

class PdoRegistrationRepository implements LoadRegistrationRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * @throws Exception
     */
    public function loadByRegistrationNumber(Cpf $cpf): Registration
    {
        $stmt = $this->pdo->prepare('SELECT * FROM `registrations` WHERE cpf = :cpf');
        $stmt->execute([':cpf' => (string) $cpf]);
        $record = $stmt->fetch();

        if (!$record) {
            throw new RegistrationNotFoundException($cpf);
        }

        $registration = new Registration();
        $registration->setName($record['name'])
            ->setBirthDate(new DateTimeImmutable($record['birth_date']))
            ->setEmail(new Email($record['email']))
            ->setRegistrationAt(new DateTimeImmutable($record['created_at']))
            ->setRegistrationNumber(new Cpf($record['cpf']));

        return $registration;
    }
}