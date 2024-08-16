<?php

declare(strict_types=1);

namespace Butschster\Tests\Feature;

use Butschster\ProtoParser\Ast\ImportDeclNode;
use Butschster\ProtoParser\Ast\MessageDefNode;
use Butschster\ProtoParser\Ast\PackageDeclNode;
use Butschster\ProtoParser\Ast\ProtoNode;
use Butschster\ProtoParser\Ast\SyntaxDeclNode;
use Butschster\ProtoParser\ProtoParser;
use Butschster\ProtoParser\ProtoParserFactory;
use Butschster\Tests\TestCase;

class SubtitlesV1RequestTest extends TestCase
{
    protected ProtoParser $parser;
    private ProtoNode $ast;

    protected function setUp(): void
    {
        $this->parser = ProtoParserFactory::create();
        $this->ast = $this->parser->parse(
            <<<'PROTO'
syntax = "proto3";

package subtitles.v1.request;

import "common/v1/message.proto";
import "subtitles/v1/message.proto";

option php_metadata_namespace = "GRPC\\ProtobufMetadata\\Subtitles\\v1";
option php_namespace = "GRPC\\Services\\Subtitles\\v1\\Request";

message TranscribeRequest {
  common.v1.dto.BucketFile audio = 1;
  optional string language = 2; // The language of the audio file
  bool translate = 3; // Translate the transcription to the english language
}

message GenerateSubtitleRequest {
  common.v1.dto.BucketFile audio = 1;
  optional string parent_uuid = 2; // The parent UUID of the subtitle
  string hash = 3; // Checksum of the file
  optional string language = 4; // The language of the audio file
  bool translate = 5; // Translate the transcription to the english language
}

message CreateRequest {
  common.v1.dto.BucketFile audio = 1;
  string hash = 2; // Checksum of the file
  optional string language = 3; // The language of the audio file
  optional string parent_uuid = 4; // The parent UUID of the subtitle
}

message StartProcessing {
  string uuid = 1;
}

message SubtitleProcessed {
  string uuid = 1;
  subtitles.v1.dto.Subtitle subtitle = 2;
}

message SubtitleFailed {
  string uuid = 1;
  string reason = 2;
}

message CancelProcessing {
  string uuid = 1;
  string reason = 2;
}
PROTO,
        );
    }

    public function testSyntaxDeclaration(): void
    {
        $this->assertInstanceOf(SyntaxDeclNode::class, $this->ast->syntax);
        $this->assertEquals('proto3', $this->ast->syntax->syntax);
    }

    public function testPackageDeclaration(): void
    {
        $this->assertInstanceOf(PackageDeclNode::class, $this->ast->package);
        $this->assertEquals('subtitles.v1.request', $this->ast->package->name);
    }

    public function testImports(): void
    {
        $this->assertCount(2, $this->ast->imports);

        $this->assertInstanceOf(ImportDeclNode::class, $this->ast->imports[0]);
        $this->assertEquals('common/v1/message.proto', $this->ast->imports[0]->path);
        $this->assertNull($this->ast->imports[0]->modifier);

        $this->assertInstanceOf(ImportDeclNode::class, $this->ast->imports[1]);
        $this->assertEquals('subtitles/v1/message.proto', $this->ast->imports[1]->path);
        $this->assertNull($this->ast->imports[1]->modifier);
    }

    private function findMessage(string $name): ?MessageDefNode
    {
        foreach ($this->ast->topLevelDefs as $def) {
            if ($def instanceof MessageDefNode && $def->name === $name) {
                return $def;
            }
        }
        return null;
    }
}
