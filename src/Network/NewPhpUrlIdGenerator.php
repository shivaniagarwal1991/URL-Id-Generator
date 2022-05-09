<?php

declare(strict_types=1);

namespace Semrush\HomeTest\Network;

use Semrush\HomeTest\Network\Generator\GenerateUrlId;

class NewPhpUrlIdGenerator extends GenerateUrlId implements UrlIdGenerator
{

    protected $generateUrlId;

    public function __construct()
    {
        $this->generateUrlId = new GenerateUrlId();
    }

    /**
     * Generate Id from the URL
     * 
     * @param string $url
     * @return string
     */
    public function generate(string $url): string
    {
        $url = \trim($url);
        if ($url === '') {
            throw new \InvalidArgumentException('URL string must not be empty!');
        }
        return $this->generateUrlId->getId($url);
    }
}
