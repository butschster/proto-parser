<?php

declare(strict_types=1);

namespace Butschster\Tests\Ast;

use Butschster\ProtoParser\Ast\SyntaxDeclNode;

final class SyntaxDeclNodeTest extends TestCase
{
    public function testValidSyntaxDeclaration(): void
    {
        $node = $this->parser->parse('syntax = "proto3";');

        $this->assertInstanceOf(SyntaxDeclNode::class, $node->syntax);
        $this->assertSame('proto3', $node->syntax->syntax);
    }
}
