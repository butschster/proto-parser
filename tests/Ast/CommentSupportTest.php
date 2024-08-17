<?php

declare(strict_types=1);

namespace Butschster\Tests\Ast;

use Butschster\ProtoParser\Ast\CommentNode;
use Butschster\ProtoParser\Ast\OptionNode;

final class CommentSupportTest extends TestCase
{
    public function testSingleLineComments(): void
    {
        $proto = <<<'PROTO'
        // This is a comment for syntax
        syntax = "proto3";

        // This is a comment for package
        package example;

        // This is a comment for message
        message Person {
            // Comment for a field 1
            string name = 1; // Inline comment 1
            // Comment for a field 2
            string message = 2; // Inline comment 2
            // Comment for a field 3
            string email = 3; // Inline comment 3
        }
        PROTO;

        $ast = $this->parser->parse($proto);

        $this->assertCount(1, $ast->topLevelDefs);
        $messageNode = $ast->topLevelDefs[0];

        $this->assertSame('Person', $messageNode->name);

        // Check message comment
        $this->assertCount(1, $messageNode->comments);
        $this->assertInstanceOf(CommentNode::class, $messageNode->comments[0]);
        $this->assertSame('This is a comment for message', $messageNode->comments[0]->text);

        // Check fields
        $this->assertCount(3, $messageNode->fields);

        // Check field 1
        $field1 = $messageNode->fields[0];
        $this->assertSame('name', $field1->name);
        $this->assertCount(2, $field1->comments);
        $this->assertSame('Comment for a field 1', $field1->comments[0]->text);
        $this->assertSame('Inline comment 1', $field1->comments[1]->text);

        // Check field 2
        $field2 = $messageNode->fields[1];
        $this->assertSame('message', $field2->name);
        $this->assertCount(2, $field2->comments);
        $this->assertSame('Comment for a field 2', $field2->comments[0]->text);
        $this->assertSame('Inline comment 2', $field2->comments[1]->text);

        // Check field 3
        $field3 = $messageNode->fields[2];
        $this->assertSame('email', $field3->name);
        $this->assertCount(2, $field3->comments);
        $this->assertSame('Comment for a field 3', $field3->comments[0]->text);
        $this->assertSame('Inline comment 3', $field3->comments[1]->text);
    }

    public function testMultiLineComments(): void
    {
        $proto = <<<'PROTO'
        /*
         * This is a multi-line comment
         * for syntax
         */
        syntax = "proto3";

        /* Multi-line comment
           for package */
        package example;

        /* Multi-line comment
           for message */
        message Person {
            /* Multi-line comment
               for a field */
            string name = 1;
        }
        PROTO;

        $node = $this->parser->parse($proto);

        $this->assertSame('proto3', $node->syntax->syntax);
        $this->assertCount(1, $node->syntax->comments);
        $this->assertStringContainsString('This is a multi-line comment', $node->syntax->comments[0]->text);

        $this->assertSame('example', $node->package->name);
        $this->assertCount(1, $node->package->comments);
        $this->assertStringContainsString('Multi-line comment', $node->package->comments[0]->text);

        $this->assertCount(1, $node->topLevelDefs);
        $message = $node->topLevelDefs[0];
        $this->assertSame('Person', $message->name);
        $this->assertCount(1, $message->comments);
        $this->assertStringContainsString('Multi-line comment', $message->comments[0]->text);

        $this->assertCount(1, $message->fields);
        $field = $message->fields[0];
        $this->assertSame('name', $field->name);
        $this->assertCount(1, $field->comments);
        $this->assertStringContainsString('Multi-line comment', $field->comments[0]->text);
    }

    public function testCommentsInEnums(): void
    {
        $proto = <<<'PROTO'
        syntax = "proto3";
        package example;

        // Enum comment
        enum Color {
            // Comment for RED
            RED = 0;
            // Comment for GREEN
            GREEN = 1;
            // Comment for BLUE
            BLUE = 2;
        }
        PROTO;

        $node = $this->parser->parse($proto);

        $this->assertCount(1, $node->topLevelDefs);
        $enum = $node->topLevelDefs[0];

        $this->assertInstanceOf(\Butschster\ProtoParser\Ast\EnumDefNode::class, $enum);
        $this->assertSame('Color', $enum->name);
        $this->assertCount(1, $enum->comments);
        $this->assertSame('Enum comment', $enum->comments[0]->text);

        $this->assertCount(3, $enum->fields);
        $this->assertSame('RED', $enum->fields[0]->name);
        $this->assertCount(1, $enum->fields[0]->comments);
        $this->assertSame('Comment for RED', $enum->fields[0]->comments[0]->text);

        $this->assertSame('GREEN', $enum->fields[1]->name);
        $this->assertCount(1, $enum->fields[1]->comments);
        $this->assertSame('Comment for GREEN', $enum->fields[1]->comments[0]->text);

        $this->assertSame('BLUE', $enum->fields[2]->name);
        $this->assertCount(1, $enum->fields[2]->comments);
        $this->assertSame('Comment for BLUE', $enum->fields[2]->comments[0]->text);
    }

    public function testCommentsInServices(): void
    {
        $proto = <<<'PROTO'
        syntax = "proto3";
        package example;

        // Service comment
        service Greeter {
            // RPC comment
            rpc SayHello (HelloRequest) returns (HelloResponse) {
                // Option comment
                option (google.api.http) = {
                    // HTTP option comment
                    get: "/v1/say-hello"
                };
            }
        }
        PROTO;

        $node = $this->parser->parse($proto);

        $this->assertCount(1, $node->topLevelDefs);
        $service = $node->topLevelDefs[0];

        $this->assertInstanceOf(\Butschster\ProtoParser\Ast\ServiceDefNode::class, $service);
        $this->assertSame('Greeter', $service->name);
        $this->assertCount(1, $service->comments);
        $this->assertSame('Service comment', $service->comments[0]->text);

        $this->assertCount(1, $service->methods);
        $method = $service->methods[0];
        $this->assertSame('SayHello', $method->name);
        $this->assertCount(1, $method->comments);
        $this->assertSame('RPC comment', $method->comments[0]->text);

        $this->assertCount(1, $method->options);
        $option = $method->options[0];
        $this->assertSame('google.api.http', $option->name);
        $this->assertCount(1, $option->comments);
        $this->assertEquals(new CommentNode('Option comment'), $option->comments[0]);

        $this->assertEquals(new OptionNode('get', '/v1/say-hello', [
            new CommentNode('HTTP option comment'),
        ]), $option->options[0]);
    }
}
