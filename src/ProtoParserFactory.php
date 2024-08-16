<?php

declare(strict_types=1);

namespace Butschster\ProtoParser;

use Butschster\Dbml\Exceptions\GrammarFileNotFoundException;

final class ProtoParserFactory
{
    public static function create(): ProtoParser
    {
        $path = __DIR__ . '/grammar.php';
        if (!\file_exists($path)) {
            throw new GrammarFileNotFoundException("Grammar file [{$path}] not found.");
        }

        $data = require $path;

        return new ProtoParser($data);
    }
}
