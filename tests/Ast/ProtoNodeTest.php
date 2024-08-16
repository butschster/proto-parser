<?php

declare(strict_types=1);

namespace Butschster\Tests\Ast;

use Butschster\ProtoParser\Ast\OptionNode;
use Butschster\ProtoParser\Ast\ProtoNode;
use Butschster\ProtoParser\Ast\SyntaxDeclNode;
use Butschster\ProtoParser\Ast\PackageDeclNode;
use Butschster\ProtoParser\Ast\ImportDeclNode;
use Butschster\ProtoParser\Ast\OptionDeclNode;

final class ProtoNodeTest extends TestCase
{
    public function testParseWithRootOptions(): void
    {
        $node = $this->parser->parse(
            <<<'PROTO'
            syntax = "proto3";

            package subtitles.v1.dto;

            import "common/v1/message.proto";

            option php_metadata_namespace = "GRPC\\ProtobufMetadata\\Subtitles\\v1";
            option php_namespace = "GRPC\\Services\\Subtitles\\v1";

            message Subtitle {

            }
            PROTO,
        );

        $this->assertInstanceOf(ProtoNode::class, $node);

        // Test syntax
        $this->assertInstanceOf(SyntaxDeclNode::class, $node->syntax);
        $this->assertSame('proto3', $node->syntax->syntax);

        // Test package
        $this->assertInstanceOf(PackageDeclNode::class, $node->package);
        $this->assertSame('subtitles.v1.dto', $node->package->name);

        // Test imports
        $this->assertCount(1, $node->imports);
        $this->assertInstanceOf(ImportDeclNode::class, $node->imports[0]);
        $this->assertSame('common/v1/message.proto', $node->imports[0]->path);

        // Test options
        $this->assertCount(2, $node->options);

        $this->assertInstanceOf(OptionDeclNode::class, $node->options[0]);
        $this->assertSame('php_metadata_namespace', $node->options[0]->name);
        $this->assertEquals(new OptionNode('php_metadata_namespace', 'GRPC\\\\ProtobufMetadata\\\\Subtitles\\\\v1'), $node->options[0]->options[0]);

        $this->assertInstanceOf(OptionDeclNode::class, $node->options[1]);
        $this->assertSame('php_namespace', $node->options[1]->name);
        $this->assertEquals(new OptionNode('php_namespace', 'GRPC\\\\Services\\\\Subtitles\\\\v1'), $node->options[1]->options[0]);

        // Test top-level definitions (only checking for the presence of the message)
        $this->assertCount(1, $node->topLevelDefs);
        $this->assertInstanceOf(\Butschster\ProtoParser\Ast\MessageDefNode::class, $node->topLevelDefs[0]);
        $this->assertSame('Subtitle', $node->topLevelDefs[0]->name);
    }
}
