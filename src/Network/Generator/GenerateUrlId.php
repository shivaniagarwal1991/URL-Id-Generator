<?php

declare(strict_types=1);

namespace Semrush\HomeTest\Network\Generator;

use Semrush\HomeTest\Database\PDOQuery;
use Semrush\HomeTest\Network\Generator\Trait\VPortScheme;
use Semrush\HomeTest\Network\Generator\Trait\AsciiEncoding;
use Semrush\HomeTest\Constant\SchemePort;

class GenerateUrlId
{
    use AsciiEncoding;
    use VPortScheme;
    protected $query;
    protected $validSchemesPort;
    protected $http;
    protected $https;

    public function __construct()
    {
        $this->query = new PDOQuery();
        $this->setValidPortScheme();
    }

    /**
     * Get Id from the URL
     * 
     * @param string $url
     * @return string
     */
    public function getId(string $url): string
    {
        $url = $this->getAsciiEncodedValue($this->filterUrl($url));
        return $this->query->execute($url);
    }

    /**
     * Filtered the get url
     * 
     * @param string $url
     * @return string
     */
    private function filterUrl($url): string
    {
        //([scheme]=>, [host]=>, [port] =>, [path] =>, [query]=>)
        $pareUrl = \parse_url($url);

        if (!empty($pareUrl['scheme']) && !empty($pareUrl['port'])) {
            $url = $this->hasDefaultPortForScheme(
                scheme: $pareUrl['scheme'],
                port: $pareUrl['port'],
                validSchemesPort: $this->validSchemesPort,
                url: $url
            );
        } else if (
            empty($pareUrl['scheme']) &&
            !empty($pareUrl['port']) &&
            in_array($pareUrl['port'], $this->validSchemesPort)
        ) {
            $url = $this->hasDefaultPortWithOutScheme(
                port: $pareUrl['port'],
                validSchemesPort: $this->validSchemesPort,
                url: $url
            );
        } else if (
            empty($pareUrl['scheme']) &&
            !empty($pareUrl['path']) &&
            strpos($pareUrl['path'], $this->https) === FALSE &&
            strpos($pareUrl['path'], $this->http) === FALSE
        ) {
            $url = $this->http . $url;
        }
        return $url;
    }

    private function setValidPortScheme()
    {
        $constSchemePort = (new \ReflectionClass(SchemePort::class))->getConstants();
        $this->validSchemesPort = [$constSchemePort['PROTOCOL_HTTPS'] => $constSchemePort['PORT_HTTPS'], $constSchemePort['PROTOCOL_HTTP'] => $constSchemePort['PORT_HTTP']];
        $this->http = $constSchemePort['PROTOCOL_HTTP'];
        $this->https = $constSchemePort['PROTOCOL_HTTPS'];
    }
}
