<?php

declare(strict_types=1);

namespace Butschster\Tests\Ast;

use Butschster\ProtoParser\Ast\FieldModifier;
use Butschster\ProtoParser\Ast\MessageDefNode;

class AnyTypeParserTest extends TestCase
{
    public function testParseMessageWithAnyType(): void
    {
        $ast = $this->parser->parse(
            <<<'PROTO'
syntax = "proto3";

package test;

message TestMessage {
    any data = 1;
}
PROTO,
        );

        $this->assertCount(1, $ast->topLevelDefs);
        $message = $ast->topLevelDefs[0];
        $this->assertEquals('TestMessage', $message->name);

        $this->assertCount(1, $message->fields);
        $field = $message->fields[0];

        $this->assertEquals('data', $field->name);
        $this->assertEquals(1, $field->number);
        $this->assertEquals('any', $field->type->type);
    }

    public function testParseMessageWithMultipleFieldsIncludingAny(): void
    {
        $proto = <<<'PROTO'
        syntax = "proto3";

        package test;

        message ComplexMessage {
            string name = 1;
            int32 age = 2;
            any extra_data = 3;
        }
        PROTO;

        $ast = $this->parser->parse($proto);

        $this->assertCount(1, $ast->topLevelDefs);
        $message = $ast->topLevelDefs[0];

        $this->assertInstanceOf(MessageDefNode::class, $message);
        $this->assertEquals('ComplexMessage', $message->name);

        $this->assertCount(3, $message->fields);

        $this->assertEquals('string', $message->fields[0]->type->type);
        $this->assertEquals('name', $message->fields[0]->name);
        $this->assertEquals(1, $message->fields[0]->number);

        $this->assertEquals('int32', $message->fields[1]->type->type);
        $this->assertEquals('age', $message->fields[1]->name);
        $this->assertEquals(2, $message->fields[1]->number);

        $this->assertEquals('any', $message->fields[2]->type->type);
        $this->assertEquals('extra_data', $message->fields[2]->name);
        $this->assertEquals(3, $message->fields[2]->number);
    }

    public function testParseMessageWithRepeatedAnyType(): void
    {
        $ast = $this->parser->parse(
            <<<'PROTO'
syntax = "proto3";

package test;

message RepeatedAnyMessage {
    repeated any items = 1;
}
PROTO,
        );

        $message = $ast->topLevelDefs[0];
        $field = $message->fields[0];

        $this->assertSame('items', $field->name);
        $this->assertSame(1, $field->number);
        $this->assertSame('any', $field->type->type);
        $this->assertEquals(FieldModifier::Repeated, $field->modifier);
    }

    public function testParseMessageWithAnyTypeAndOptions(): void
    {
        $ast = $this->parser->parse(
            <<<'PROTO'
syntax = "proto3";

package test;

message OptionsMessage {
    any data = 1 [deprecated = true];
}
PROTO,
        );

        $message = $ast->topLevelDefs[0];
        $field = $message->fields[0];

        $this->assertEquals('data', $field->name);
        $this->assertEquals(1, $field->number);
        $this->assertEquals('any', $field->type->type);

        $this->assertCount(1, $field->options);
        $this->assertEquals('deprecated', $field->options['deprecated']->name);
        $this->assertTrue($field->options['deprecated']->value);
    }
}
