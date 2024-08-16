<?php

declare(strict_types=1);

namespace Butschster\Tests\Ast;

use Butschster\ProtoParser\Ast\ImportDeclNode;
use Butschster\ProtoParser\Ast\ImportModifier;

final class ImportDeclNodeTest extends TestCase
{
    public function testSimpleImport(): void
    {
        $node = $this->parser->parse(
            <<<'PROTO'
syntax = "proto3";

package example;

import "google/protobuf/timestamp.proto";
PROTO,
        );

        $this->assertSame('proto3', $node->syntax->syntax);
        $this->assertSame('example', $node->package->name);

        $this->assertCount(1, $node->imports);
        $import = $node->imports[0];

        $this->assertSame('google/protobuf/timestamp.proto', $import->path);
        $this->assertNull($import->modifier);
    }

    public function testImportWeak(): void
    {
        $node = $this->parser->parse(
            <<<'PROTO'
syntax = "proto3";

package example;

import weak "google/protobuf/timestamp.proto";
PROTO,
        );

        $this->assertSame('proto3', $node->syntax->syntax);
        $this->assertSame('example', $node->package->name);

        $this->assertCount(1, $node->imports);
        $import = $node->imports[0];

        $this->assertSame('google/protobuf/timestamp.proto', $import->path);
        $this->assertSame(ImportModifier::Weak, $import->modifier);
    }

    public function testImportPublic(): void
    {
        $node = $this->parser->parse(
            <<<'PROTO'
syntax = "proto3";

package example;

import public "google/protobuf/timestamp.proto";
PROTO,
        );

        $this->assertSame('proto3', $node->syntax->syntax);
        $this->assertSame('example', $node->package->name);

        $this->assertCount(1, $node->imports);
        $import = $node->imports[0];

        $this->assertSame('google/protobuf/timestamp.proto', $import->path);
        $this->assertSame(ImportModifier::Public, $import->modifier);
    }

    public function testMultipleImports(): void
    {
        $node = $this->parser->parse(
            <<<'PROTO'
syntax = "proto3";

package example;

import "foo.proto";
import public "bar.proto";
import weak "baz.proto";
import "qux.proto";

PROTO,
        );

        $this->assertSame('proto3', $node->syntax->syntax);
        $this->assertSame('example', $node->package->name);

        $this->assertCount(4, $node->imports);
        $import = $node->imports[0];

        $this->assertSame('foo.proto', $import->path);
        $this->assertNull($import->modifier);

        $import = $node->imports[1];
        $this->assertSame('bar.proto', $import->path);
        $this->assertSame(ImportModifier::Public, $import->modifier);

        $import = $node->imports[2];
        $this->assertSame('baz.proto', $import->path);
        $this->assertSame(ImportModifier::Weak, $import->modifier);

        $import = $node->imports[3];
        $this->assertSame('qux.proto', $import->path);
        $this->assertNull($import->modifier);
    }

    public function testImportWithLeadingDot(): void
    {
        $node = $this->parser->parse(
            <<<'PROTO'
            syntax = "proto3";

            import "./relative_path/message.proto";
            PROTO,
        );

        $this->assertCount(1, $node->imports);
        $import = $node->imports[0];

        $this->assertSame('./relative_path/message.proto', $import->path);
        $this->assertNull($import->modifier);
    }

    public function testImportWithBackslashes(): void
    {
        $node = $this->parser->parse(
            <<<'PROTO'
            syntax = "proto3";

            import "path\\with\\backslashes\\message.proto";
            PROTO,
        );

        $this->assertCount(1, $node->imports);
        $import = $node->imports[0];

        $this->assertSame('path\with\backslashes\message.proto', $import->path);
        $this->assertNull($import->modifier);
    }

    public function testImportWithSpecialCharacters(): void
    {
        $node = $this->parser->parse(
            <<<'PROTO'
            syntax = "proto3";

            import "path-with_special@characters.proto";
            PROTO,
        );

        $this->assertCount(1, $node->imports);
        $import = $node->imports[0];

        $this->assertInstanceOf(ImportDeclNode::class, $import);
        $this->assertSame('path-with_special@characters.proto', $import->path);
        $this->assertNull($import->modifier);
    }
}
