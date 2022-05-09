<?php

namespace Semrush\HomeTest\Database;

use PDOException, PDO;

class PDOConnection extends AbstractConnection
{
    const  REQUIRED_CONNECTION_KEYS = [
        'driver',
        'db_username',
        'db_user_password'
    ];

    private function connect(): PDOConnection
    {
        $credentials = $this->parseCredentials($this->credentials);
        try {
            $this->connection = new PDO(...$credentials);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $exception) {
            throw ($exception->getMessage());
        }
        return $this;
    }
    public function getConnection(): PDO
    {
        if (!isset($this->connection)) {
            $this->connect();
        }
        return $this->connection;
    }

    protected function parseCredentials(array $credentials): array
    {
        return [$credentials['driver'], $credentials['db_username'], $credentials['db_user_password']];
    }
}
