<?php

declare(strict_types=1);

namespace Semrush\HomeTest\Network;

use Semrush\HomeTest\Database\PDOQuery;

final class PhpUrlIdGenerator extends AbstractUrlIdGenerator
{
    protected $query;

    public function __construct()
    {
        $this->query = new PDOQuery();
    }

    protected function generateId(string $url): string
    {
        return $this->query->execute($url);
    }
}
