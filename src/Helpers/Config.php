<?php

declare(strict_types=1);

namespace Semrush\HomeTest\Helpers;

class Config
{
    public static function get(string $filename, string $key = null): array|string|bool
    {
        $fileContent = self::getFileContent($filename);
        if ($key === null) {
            return $fileContent;
        }

        return (!empty($fileContent[$key])) ? $fileContent[$key] : [];
    }

    public static function getFileContent(string $filename): array
    {
        $fileContent = [];
        try {
            $path = realpath(sprintf(__DIR__ . '/../Config/%s.php', $filename));
            if (file_exists($path)) {
                $fileContent = require $path;
            }
        } catch (\Throwable $exception) {
            die($exception->getMessage());
        }
        return $fileContent;
    }
}
