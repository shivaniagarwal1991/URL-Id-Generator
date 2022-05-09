<?php

namespace Semrush\HomeTest\Database;

abstract class AbstractConnection
{
    protected $credentials;
    protected $connection;
    const REQUIRED_CONNECTION_KEYS = [];

    public function __construct(array $credentials)
    {
        $this->credentials = $credentials;
        if (!$this->credentialHaveRequiredKeys($this->credentials)) {
            throw new \Throwable(
                sprintf('Database connection credential are not mapped, required keys %s', implode(',', static::REQUIRED_CONNECTION_KEYS))
            );
        }
    }

    private function credentialHaveRequiredKeys(array $credentials): bool
    {
        $match = array_intersect(static::REQUIRED_CONNECTION_KEYS, array_keys($credentials));
        return (count($match) === count(static::REQUIRED_CONNECTION_KEYS));
    }
    abstract protected function parseCredentials(array $credentials): array;
}
