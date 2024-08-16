<?php

declare(strict_types=1);

namespace Butschster\Tests\Ast;

use Butschster\ProtoParser\Ast\FieldDeclNode;
use Butschster\ProtoParser\Ast\FieldModifier;
use Butschster\ProtoParser\Ast\FieldType;
use Butschster\ProtoParser\Ast\MessageDefNode;
use Butschster\ProtoParser\Ast\OptionNode;
use Butschster\ProtoParser\Ast\ProtoNode;

final class FieldDeclNodeTest extends TestCase
{
    public function testSimpleFieldDeclaration(): void
    {
        $proto = $this->parseProto(
            <<<PROTO
syntax = "proto3";
package example;
message Person {
    string name = 1;
}
PROTO,
        );

        $field = $this->getFirstFieldFromFirstMessage($proto);

        $this->assertInstanceOf(FieldDeclNode::class, $field);
        $this->assertEquals(new FieldType('string'), $field->type);
        $this->assertSame('name', $field->name);
        $this->assertSame(1, $field->number);
        $this->assertNull($field->modifier);
        $this->assertEmpty($field->options);
    }

    public function testSimpleOptionalFieldDeclaration(): void
    {
        $proto = $this->parseProto(
            <<<PROTO
syntax = "proto3";
package example;
message Person {
    optional string name = 1;
}
PROTO,
        );

        $field = $this->getFirstFieldFromFirstMessage($proto);

        $this->assertInstanceOf(FieldDeclNode::class, $field);
        $this->assertEquals(new FieldType('string'), $field->type);
        $this->assertSame('name', $field->name);
        $this->assertSame(1, $field->number);
        $this->assertSame(FieldModifier::Optional, $field->modifier);
        $this->assertEmpty($field->options);
    }

    public function testFieldDeclarationWithModifier(): void
    {
        $proto = $this->parseProto(
            <<<PROTO
syntax = "proto3";
package example;
message Person {
    repeated int32 id = 2;
}
PROTO,
        );

        $field = $this->getFirstFieldFromFirstMessage($proto);

        $this->assertInstanceOf(FieldDeclNode::class, $field);
        $this->assertEquals(new FieldType('int32'), $field->type);
        $this->assertSame('id', $field->name);
        $this->assertSame(2, $field->number);
        $this->assertSame(FieldModifier::Repeated, $field->modifier);
        $this->assertEmpty($field->options);
    }

    public function testFieldDeclarationWithOptions(): void
    {
        $proto = $this->parseProto(
            <<<PROTO
syntax = "proto3";
package example;
message Data {
    bytes content = 3 [deprecated = true, packed = false];
}
PROTO,
        );

        $field = $this->getFirstFieldFromFirstMessage($proto);

        $this->assertInstanceOf(FieldDeclNode::class, $field);
        $this->assertEquals(new FieldType('bytes'), $field->type);
        $this->assertSame('content', $field->name);
        $this->assertSame(3, $field->number);
        $this->assertNull($field->modifier);
        $this->assertCount(2, $field->options);
        $this->assertEquals(new OptionNode('deprecated', true), $field->options['deprecated']);
        $this->assertEquals(new OptionNode('packed', false), $field->options['packed']);
    }

    public function testFieldDeclarationWithCustomType(): void
    {
        $proto = $this->parseProto(
            <<<PROTO
syntax = "proto3";
package example;
message Person {
    Address address = 4;
}
PROTO,
        );

        $field = $this->getFirstFieldFromFirstMessage($proto);

        $this->assertInstanceOf(FieldDeclNode::class, $field);
        $this->assertEquals(new FieldType('Address'), $field->type);
        $this->assertSame('address', $field->name);
        $this->assertSame(4, $field->number);
        $this->assertNull($field->modifier);
        $this->assertEmpty($field->options);
    }

    public function testFieldDeclarationWithNestedType(): void
    {
        $proto = $this->parseProto(
            <<<PROTO
syntax = "proto3";
package example;
message Person {
    Person.PhoneNumber phone = 5;
}
PROTO,
        );

        $field = $this->getFirstFieldFromFirstMessage($proto);

        $this->assertInstanceOf(FieldDeclNode::class, $field);
        $this->assertEquals(new FieldType('Person.PhoneNumber'), $field->type);
        $this->assertSame('phone', $field->name);
        $this->assertSame(5, $field->number);
        $this->assertNull($field->modifier);
        $this->assertEmpty($field->options);
    }

    public function testFieldDeclarationWithAllElements(): void
    {
        $proto = $this->parseProto(
            <<<PROTO
syntax = "proto3";
package example;
message ComplexMessage {
    optional .my.CustomType custom_field = 6 [default = "test", json_name = "customField"];
}
PROTO,
        );

        $field = $this->getFirstFieldFromFirstMessage($proto);

        $this->assertInstanceOf(FieldDeclNode::class, $field);
        $this->assertEquals(new FieldType('.my.CustomType'), $field->type);
        $this->assertSame('custom_field', $field->name);
        $this->assertSame(6, $field->number);
        $this->assertSame(FieldModifier::Optional, $field->modifier);
        $this->assertCount(2, $field->options);
        $this->assertEquals(new OptionNode('default', 'test'), $field->options['default']);
        $this->assertEquals(new OptionNode('json_name', 'customField'), $field->options['json_name']);
    }

    private function parseProto(string $protoDefinition): ProtoNode
    {
        return $this->parser->parse($protoDefinition);
    }

    private function getFirstFieldFromFirstMessage(ProtoNode $proto): FieldDeclNode
    {
        $message = $proto->topLevelDefs[0];
        assert($message instanceof MessageDefNode);
        return $message->fields[0];
    }
}
