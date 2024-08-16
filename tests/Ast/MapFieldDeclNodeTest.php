<?php

declare(strict_types=1);

namespace Butschster\Tests\Ast;

use Butschster\ProtoParser\Ast\FieldType;
use Butschster\ProtoParser\Ast\MapFieldDeclNode;
use Butschster\ProtoParser\Ast\OptionNode;

final class MapFieldDeclNodeTest extends TestCase
{
    public function testSimpleMapField(): void
    {
        $node = $this->parser->parse(
            <<<'PROTO'
syntax = "proto3";

message TestMessage {
    map<string, int32> test_map = 1;
}
PROTO,
        );

        $message = $node->topLevelDefs[0];
        $this->assertCount(1, $message->fields);

        $field = $message->fields[0];
        $this->assertInstanceOf(MapFieldDeclNode::class, $field);
        $this->assertEquals(new FieldType('string'), $field->keyType);
        $this->assertEquals(new FieldType('int32'), $field->valueType);
        $this->assertSame('test_map', $field->name);
        $this->assertSame(1, $field->number);
        $this->assertEmpty($field->options);
    }

    public function testMapFieldWithOptions(): void
    {
        $node = $this->parser->parse(
            <<<'PROTO'
syntax = "proto3";

message TestMessage {
    map<string, int32> test_map = 1 [deprecated = true];
}
PROTO,
        );

        $message = $node->topLevelDefs[0];
        $this->assertCount(1, $message->fields);

        $field = $message->fields[0];
        $this->assertInstanceOf(MapFieldDeclNode::class, $field);
        $this->assertEquals(new FieldType('string'), $field->keyType);
        $this->assertEquals(new FieldType('int32'), $field->valueType);
        $this->assertSame('test_map', $field->name);
        $this->assertSame(1, $field->number);
        $this->assertEquals([
            'deprecated' => new OptionNode(
                'deprecated',
                true
            )
        ], $field->options);
    }

    public function testMapFieldWithCustomKeyType(): void
    {
        $node = $this->parser->parse(
            <<<'PROTO'
syntax = "proto3";

message UserId {
    string value = 1;
}

message TestMessage {
    map<UserId, string> user_messages = 1;
}
PROTO,
        );

        $message = $node->topLevelDefs[1];
        $this->assertCount(1, $message->fields);

        $field = $message->fields[0];
        $this->assertInstanceOf(MapFieldDeclNode::class, $field);
        $this->assertEquals(new FieldType('UserId'), $field->keyType);
        $this->assertEquals(new FieldType('string'), $field->valueType);
        $this->assertSame('user_messages', $field->name);
        $this->assertSame(1, $field->number);
        $this->assertEmpty($field->options);
    }
}
