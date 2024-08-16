<?php

declare(strict_types=1);

namespace Butschster\Tests\Ast;

use Butschster\ProtoParser\Ast\EnumDefNode;
use Butschster\ProtoParser\Ast\EnumFieldNode;
use Butschster\ProtoParser\Ast\OptionDeclNode;
use Butschster\ProtoParser\Ast\ReservedNode;
use Butschster\ProtoParser\Ast\ReservedNumber;
use Butschster\ProtoParser\Ast\ReservedRange;

final class EnumDefNodeTest extends TestCase
{
    public function testSimpleEnum(): void
    {
        $node = $this->parser->parse(
            <<<'PROTO'
            syntax = "proto3";

            package example;

            enum Color {
              RED = 0;
              GREEN = 1;
              BLUE = 2;
            }
            PROTO,
        );

        $this->assertSame('proto3', $node->syntax->syntax);
        $this->assertSame('example', $node->package->name);

        $this->assertCount(1, $node->topLevelDefs);
        $enum = $node->topLevelDefs[0];

        $this->assertInstanceOf(EnumDefNode::class, $enum);
        $this->assertSame('Color', $enum->name);
        $this->assertCount(3, $enum->fields);

        $this->assertEnumField($enum->fields[0], 'RED', 0);
        $this->assertEnumField($enum->fields[1], 'GREEN', 1);
        $this->assertEnumField($enum->fields[2], 'BLUE', 2);
    }

    public function testEnumWithOptions(): void
    {
        $node = $this->parser->parse(
            <<<'PROTO'
            syntax = "proto3";

            package example;

            enum Status {
              option allow_alias = true;
              UNKNOWN = 0;
              STARTED = 1;
              RUNNING = 1;
              FINISHED = 2;
            }
            PROTO,
        );

        $this->assertSame('proto3', $node->syntax->syntax);
        $this->assertSame('example', $node->package->name);

        $this->assertCount(1, $node->topLevelDefs);
        $enum = $node->topLevelDefs[0];

        $this->assertInstanceOf(EnumDefNode::class, $enum);
        $this->assertSame('Status', $enum->name);
        $this->assertCount(5, $enum->fields);

        $this->assertInstanceOf(OptionDeclNode::class, $enum->fields[0]);
        $this->assertSame('allow_alias', $enum->fields[0]->name);
        $this->assertTrue($enum->fields[0]->value);

        $this->assertEnumField($enum->fields[1], 'UNKNOWN', 0);
        $this->assertEnumField($enum->fields[2], 'STARTED', 1);
        $this->assertEnumField($enum->fields[3], 'RUNNING', 1);
        $this->assertEnumField($enum->fields[4], 'FINISHED', 2);
    }

    public function testEnumWithFieldOptions(): void
    {
        $node = $this->parser->parse(
            <<<'PROTO'
            syntax = "proto3";

            package example;

            enum Direction {
              NORTH = 0 [deprecated = true];
              EAST = 1;
              SOUTH = 2 [alias = "S"];
              WEST = 3;
            }
            PROTO,
        );

        $this->assertSame('proto3', $node->syntax->syntax);
        $this->assertSame('example', $node->package->name);

        $this->assertCount(1, $node->topLevelDefs);
        $enum = $node->topLevelDefs[0];

        $this->assertInstanceOf(EnumDefNode::class, $enum);
        $this->assertSame('Direction', $enum->name);
        $this->assertCount(4, $enum->fields);

        $this->assertEnumField($enum->fields[0], 'NORTH', 0, ['deprecated' => true]);
        $this->assertEnumField($enum->fields[1], 'EAST', 1);
        $this->assertEnumField($enum->fields[2], 'SOUTH', 2, ['alias' => 'S']);
        $this->assertEnumField($enum->fields[3], 'WEST', 3);
    }

    public function testEnumWithReservedFields(): void
    {
        $node = $this->parser->parse(
            <<<'PROTO'
            syntax = "proto3";

            package example;

            enum Operation {
              reserved 2, 15, 9 to 11, 40 to max;
              reserved "FOO", "BAR";
              ADD = 0;
              SUBTRACT = 1;
              MULTIPLY = 3;
              DIVIDE = 4;
            }
            PROTO,
        );

        $this->assertSame('proto3', $node->syntax->syntax);
        $this->assertSame('example', $node->package->name);

        $this->assertCount(1, $node->topLevelDefs);
        $enum = $node->topLevelDefs[0];

        $this->assertInstanceOf(EnumDefNode::class, $enum);
        $this->assertSame('Operation', $enum->name);
        $this->assertCount(6, $enum->fields);

        $this->assertInstanceOf(ReservedNode::class, $enum->fields[0]);
        $this->assertEquals([
            new ReservedNumber(2),
            new ReservedNumber(15),
            new ReservedRange(9, 11),
            new ReservedRange(40, 'max'),
        ], $enum->fields[0]->ranges);

        $this->assertInstanceOf(ReservedNode::class, $enum->fields[1]);
        $this->assertSame(['FOO', 'BAR'], $enum->fields[1]->ranges);

        $this->assertEnumField($enum->fields[2], 'ADD', 0);
        $this->assertEnumField($enum->fields[3], 'SUBTRACT', 1);
        $this->assertEnumField($enum->fields[4], 'MULTIPLY', 3);
        $this->assertEnumField($enum->fields[5], 'DIVIDE', 4);
    }

    private function assertEnumField(
        EnumFieldNode $field,
        string $expectedName,
        int $expectedNumber,
        array $expectedOptions = [],
    ): void {
        $this->assertSame($expectedName, $field->name);
        $this->assertSame($expectedNumber, $field->number);
        $this->assertEquals($expectedOptions, $field->options);
    }
}
