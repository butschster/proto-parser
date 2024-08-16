<?php

declare(strict_types=1);

namespace Butschster\Tests\Ast;

use Butschster\ProtoParser\Ast\EnumDefNode;
use Butschster\ProtoParser\Ast\FieldType;

final class MessageDefNodeTest extends TestCase
{
    public function testParse(): void
    {
        $node = $this->parser->parse(
            <<<'PROTO'
syntax = "proto3";

package example;

message Person {
  string name = 1;
  int32 id = 2;
  string email = 3;
}
PROTO,
        );

        $this->assertSame('proto3', $node->syntax->syntax);
        $this->assertSame('example', $node->package->name);

        $message = $node->topLevelDefs[0];

        $this->assertSame('Person', $message->name);
        $this->assertCount(3, $message->fields);

        $this->assertSame('name', $message->fields[0]->name);
        $this->assertEquals(new FieldType('string'), $message->fields[0]->type);
        $this->assertSame(1, $message->fields[0]->number);

        $this->assertSame('id', $message->fields[1]->name);
        $this->assertEquals(new FieldType('int32'), $message->fields[1]->type);
        $this->assertSame(2, $message->fields[1]->number);

        $this->assertSame('email', $message->fields[2]->name);
        $this->assertEquals(new FieldType('string'), $message->fields[2]->type);
        $this->assertSame(3, $message->fields[2]->number);
    }

    public function testParseWithEnum(): void
    {
        $node = $this->parser->parse(
            <<<'PROTO'
syntax = "proto3";

package example;

message Person {
  string name = 1;
  int32 id = 2;
  string email = 3;

  enum PhoneType {
    MOBILE = 0;
    HOME = 1;
    WORK = 2;
  }

  PhoneType type = 4;
}
PROTO,
        );

        $this->assertSame('proto3', $node->syntax->syntax);

        $message = $node->topLevelDefs[0];

        $this->assertSame('Person', $message->name);

        $this->assertCount(4, $message->fields);

        $this->assertSame('type', $message->fields[3]->name);
        $this->assertEquals(new FieldType('PhoneType'), $message->fields[3]->type);
        $this->assertSame(4, $message->fields[3]->number);

        $this->assertInstanceOf(EnumDefNode::class, $message->enums[0]);
        $this->assertSame('PhoneType', $message->enums[0]->name);
        $this->assertCount(3, $message->enums[0]->fields);
    }
}
