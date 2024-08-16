<?php

declare(strict_types=1);

namespace Butschster\Tests\Ast;


use Butschster\ProtoParser\Ast\FieldType;
use Butschster\ProtoParser\Ast\OneofDeclNode;
use Butschster\ProtoParser\Ast\OneofFieldNode;
use Butschster\ProtoParser\Ast\OptionDeclNode;

final class OneofDeclNodeTest extends TestCase
{
    public function testSimpleOneofDecl(): void
    {
        $node = $this->parser->parse(
            <<<'PROTO'
syntax = "proto3";

package example;

message SampleMessage {
  oneof test_oneof {
    string name = 4;
    SubMessage sub_message = 9;
  }
}
PROTO,
        );

        $this->assertSame('proto3', $node->syntax->syntax);
        $this->assertSame('example', $node->package->name);

        $message = $node->topLevelDefs[0];
        $this->assertCount(1, $message->fields);

        $oneof = $message->fields[0];
        $this->assertInstanceOf(OneofDeclNode::class, $oneof);
        $this->assertSame('test_oneof', $oneof->name);

        $this->assertCount(2, $oneof->fields);

        $field1 = $oneof->fields[0];

        $this->assertInstanceOf(OneofFieldNode::class, $field1);
        $this->assertSame('name', $field1->name);
        $this->assertEquals(new FieldType('string'), $field1->type);
        $this->assertSame(4, $field1->number);

        $field2 = $oneof->fields[1];
        $this->assertInstanceOf(OneofFieldNode::class, $field2);
        $this->assertSame('sub_message', $field2->name);
        $this->assertEquals(new FieldType('SubMessage'), $field2->type);
        $this->assertSame(9, $field2->number);
    }

    public function testOneofWithOptions(): void
    {
        $node = $this->parser->parse(
            <<<'PROTO'
            syntax = "proto3";

            package example;

            message SampleMessage {
              oneof test_oneof {
                option my_option.a = true;
                string name = 4;
                option my_option.b = 42;
                SubMessage sub_message = 9;
              }
            }
            PROTO,
        );

        $oneof = $node->topLevelDefs[0]->fields[0];

        $this->assertCount(2, $oneof->fields);
        $this->assertCount(2, $oneof->options);

        $option1 = $oneof->options[0];
        $this->assertInstanceOf(OptionDeclNode::class, $option1);
        $this->assertSame('my_option.a', $option1->name);
        $this->assertTrue($option1->value);

        $option2 = $oneof->options[1];
        $this->assertInstanceOf(OptionDeclNode::class, $option2);
        $this->assertSame('my_option.b', $option2->name);
        $this->assertSame(42, $option2->value);
    }

    public function testOneofFieldWithOptions(): void
    {
        $node = $this->parser->parse(
            <<<'PROTO'
            syntax = "proto3";

            package example;

            message SampleMessage {
              oneof test_oneof {
                string name = 4 [my_option = "test"];
              }
            }
            PROTO,
        );

        $oneof = $node->topLevelDefs[0]->fields[0];
        $this->assertCount(1, $oneof->fields);

        $field = $oneof->fields[0];
        $this->assertSame(['my_option' => 'test'], $field->options);
    }

    public function testEmptyOneofDecl(): void
    {
        $node = $this->parser->parse(
            <<<'PROTO'
            syntax = "proto3";

            package example;

            message SampleMessage {
              oneof test_oneof {}
            }
            PROTO,
        );

        $oneof = $node->topLevelDefs[0]->fields[0];
        $this->assertCount(0, $oneof->fields);
    }
}
