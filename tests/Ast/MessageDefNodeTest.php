<?php

declare(strict_types=1);

namespace Butschster\Tests\Ast;

use Butschster\ProtoParser\Ast\CommentNode;
use Butschster\ProtoParser\Ast\EnumDefNode;
use Butschster\ProtoParser\Ast\FieldType;
use Butschster\ProtoParser\Ast\ReservedNode;
use Butschster\ProtoParser\Ast\ReservedNumber;

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
  string message = 4;
}
PROTO,
        );

        $this->assertSame('proto3', $node->syntax->syntax);
        $this->assertSame('example', $node->package->name);

        $message = $node->topLevelDefs[0];

        $this->assertSame('Person', $message->name);
        $this->assertCount(4, $message->fields);

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

    public function testParse2(): void
    {
        $node = $this->parser->parse(
            <<<'PROTO'
syntax = "proto3";

package example;

message message {
  string name = 1;
}
PROTO,
        );

        $this->assertSame('proto3', $node->syntax->syntax);
        $this->assertSame('example', $node->package->name);

        $message = $node->topLevelDefs[0];

        $this->assertSame('message', $message->name);
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

    public function testParseWithReserved(): void
    {
        $node = $this->parser->parse(
            <<<'PROTO'
syntax = "proto3";

package example;

message Problem {
    // unused because of parser updating
    reserved 1;
    string name = 2;
    reserved 3, 4;
    // uint32 status = 7; // status of running
}
PROTO,
        );

        $message = $node->topLevelDefs[0];
        $this->assertSame('Problem', $message->name);
        $this->assertCount(3, $message->fields);

        $this->assertCount(1, $message->comments);
        $this->assertSame('uint32 status = 7; // status of running', $message->comments[0]->text);

        // Test first reserved field
        $this->assertInstanceOf(ReservedNode::class, $message->fields[0]);
        $this->assertCount(1, $message->fields[0]->ranges);
        $this->assertInstanceOf(ReservedNumber::class, $message->fields[0]->ranges[0]);
        $this->assertSame(1, $message->fields[0]->ranges[0]->value);

        // Test the comment for the first reserved field
        $this->assertCount(1, $message->fields[0]->comments);
        $this->assertInstanceOf(CommentNode::class, $message->fields[0]->comments[0]);
        $this->assertSame('unused because of parser updating', $message->fields[0]->comments[0]->text);

        // Test the string field
        $this->assertSame('name', $message->fields[1]->name);
        $this->assertInstanceOf(FieldType::class, $message->fields[1]->type);
        $this->assertSame('string', $message->fields[1]->type->type);
        $this->assertSame(2, $message->fields[1]->number);

        // Test second reserved field
        $this->assertInstanceOf(ReservedNode::class, $message->fields[2]);
        $this->assertCount(2, $message->fields[2]->ranges);
        $this->assertInstanceOf(ReservedNumber::class, $message->fields[2]->ranges[0]);
        $this->assertSame(3, $message->fields[2]->ranges[0]->value);
        $this->assertInstanceOf(ReservedNumber::class, $message->fields[2]->ranges[1]);
        $this->assertSame(4, $message->fields[2]->ranges[1]->value);
    }
}
