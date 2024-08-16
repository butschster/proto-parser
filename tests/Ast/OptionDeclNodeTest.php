<?php

declare(strict_types=1);

namespace Butschster\Tests\Ast;

use Butschster\ProtoParser\Ast\OptionDeclNode;

final class OptionDeclNodeTest extends TestCase
{
    public function testParseOptionWithParentheses(): void
    {
        $node = $this->parser->parse(
            <<<'PROTO'
            syntax = "proto3";

            package example;

            option (google.api.default_host) = "user.example.com";
            PROTO,
        );

        $this->assertSame('proto3', $node->syntax->syntax);
        $this->assertSame('example', $node->package->name);

        $this->assertCount(1, $node->options);
        $option = $node->options[0];

        $this->assertInstanceOf(OptionDeclNode::class, $option);
        $this->assertSame('google.api.default_host', $option->name);
        $this->assertSame('user.example.com', $option->value);
    }

    public function testParseMultipleOptionsWithParentheses(): void
    {
        $node = $this->parser->parse(
            <<<'PROTO'
            syntax = "proto3";

            package example;

            option (google.api.default_host) = "user.example.com";
            option (google.api.oauth_scopes) = "https://www.googleapis.com/auth/userinfo.email";
            option java_multiple_files = true;
            PROTO,
        );

        $this->assertSame('proto3', $node->syntax->syntax);
        $this->assertSame('example', $node->package->name);

        $this->assertCount(3, $node->options);

        $this->assertInstanceOf(OptionDeclNode::class, $node->options[0]);
        $this->assertSame('google.api.default_host', $node->options[0]->name);
        $this->assertSame('user.example.com', $node->options[0]->value);

        $this->assertInstanceOf(OptionDeclNode::class, $node->options[1]);
        $this->assertSame('google.api.oauth_scopes', $node->options[1]->name);
        $this->assertSame('https://www.googleapis.com/auth/userinfo.email', $node->options[1]->value);

        $this->assertInstanceOf(OptionDeclNode::class, $node->options[2]);
        $this->assertSame('java_multiple_files', $node->options[2]->name);
        $this->assertTrue($node->options[2]->value);
    }
}
