<?php

declare(strict_types=1);

namespace Butschster\Tests\Ast;

use Butschster\ProtoParser\Ast\PackageDeclNode;

final class PackageDeclNodeTest extends TestCase
{
    public function testParseSimplePackageName(): void
    {
        $node = $this->parser->parse(
            <<<'PROTO'
            syntax = "proto3";

            package example;
            PROTO,
        );

        $this->assertSame('proto3', $node->syntax->syntax);

        $this->assertInstanceOf(PackageDeclNode::class, $node->package);
        $this->assertSame('example', $node->package->name);
    }

    public function testParsePackageNameWithDots(): void
    {
        $node = $this->parser->parse(
            <<<'PROTO'
            syntax = "proto3";

            package com.example.foo;
            PROTO,
        );

        $this->assertSame('proto3', $node->syntax->syntax);

        $this->assertInstanceOf(PackageDeclNode::class, $node->package);
        $this->assertSame('com.example.foo', $node->package->name);
    }
}
