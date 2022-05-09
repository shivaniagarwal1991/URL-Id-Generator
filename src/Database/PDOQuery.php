<?php

namespace Semrush\HomeTest\Database;

use Semrush\HomeTest\Helpers\Config;
use Semrush\HomeTest\Database\Interface\IQuery;

class PDOQuery implements IQuery
{

    private $connection;

    public function __construct()
    {
        $credentials = array_merge(Config::get('database', 'pdo'));
        $this->connection = (new PDOConnection($credentials))->getConnection();
    }

    public function execute(string $url)
    {
        $sql = 'SELECT CAST(CONV(SUBSTRING(SHA1("' . $url . '"), 1, 16), 16, 10) AS UNSIGNED) AS val';
        $query = $this->connection->prepare($sql);
        $query->execute();
        $data = $query->fetch(\PDO::FETCH_ASSOC);
        return $data['val'];
    }
}
