<?php

declare(strict_types=1);

namespace Semrush\HomeTest\Network\Generator\Trait;

trait VPortScheme
{
    /**
     * Remove the default port for scheme
     * 
     * @param array $args
     * @return string
     */

    public function hasDefaultPortForScheme(...$args): string
    {
        $schemeWithDelimeter = $args['scheme'] . '://';
        if (array_key_exists($schemeWithDelimeter, $args['validSchemesPort']) && ($args['port'] == $args['validSchemesPort'][$schemeWithDelimeter])) {
            $port = $args['port'];
            return $this->replaceStr($port, $args['url']);
        }
        return $args['url'];
    }

    /**
     * Remove the default port and add scheme
     * 
     * @param array $args
     * @return string
     */

    public function hasDefaultPortWithOutScheme(...$args): string
    {
        $port = $args['port'];
        $scheme = array_search($port, $args['validSchemesPort']);
        return $scheme . $this->replaceStr($port, $args['url']);
    }

    /**
     * @param int $port
     * @return string
     */
    private function replaceStr(int $port, string $url): string
    {
        return preg_replace("#:$port#", '', $url, 1);
    }
}
