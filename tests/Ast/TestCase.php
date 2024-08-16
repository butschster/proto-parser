<?php

declare(strict_types=1);

namespace Butschster\Tests\Ast;

use Butschster\ProtoParser\ProtoParser;
use Butschster\ProtoParser\ProtoParserFactory;

abstract class TestCase extends \Butschster\Tests\Parsers\TestCase
{
    protected ProtoParser $parser;

    protected function setUp(): void
    {
        parent::setUp();

        $this->parser = ProtoParserFactory::create();
    }
}
