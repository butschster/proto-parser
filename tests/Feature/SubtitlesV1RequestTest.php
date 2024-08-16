<?php

declare(strict_types=1);

namespace Butschster\Tests\Feature;

use Butschster\ProtoParser\Ast\ImportDeclNode;
use Butschster\ProtoParser\Ast\MessageDefNode;
use Butschster\ProtoParser\Ast\OptionDeclNode;
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

    public function testOptions(): void
    {
        $this->assertCount(2, $this->ast->options);

        $this->assertInstanceOf(OptionDeclNode::class, $this->ast->options[0]);
        $this->assertEquals('php_metadata_namespace', $this->ast->options[0]->name);
        $this->assertEquals('GRPC\\ProtobufMetadata\\Subtitles\\v1', $this->ast->options[0]->value);

        $this->assertInstanceOf(OptionDeclNode::class, $this->ast->options[1]);
        $this->assertEquals('php_namespace', $this->ast->options[1]->name);
        $this->assertEquals('GRPC\\Services\\Subtitles\\v1\\Request', $this->ast->options[1]->value);
    }

    public function testTranscribeRequestMessage(): void
    {
        $message = $this->findMessage('TranscribeRequest');
        $this->assertNotNull($message);

        $this->assertCount(3, $message->fields);

        $this->assertEquals('audio', $message->fields[0]->name);
        $this->assertEquals('common.v1.dto.BucketFile', $message->fields[0]->type);
        $this->assertEquals(1, $message->fields[0]->number);

        $this->assertEquals('language', $message->fields[1]->name);
        $this->assertEquals('string', $message->fields[1]->type);
        $this->assertEquals(2, $message->fields[1]->number);
        $this->assertSame('optional', $message->fields[1]->modifier?->name);

        $this->assertEquals('translate', $message->fields[2]->name);
        $this->assertEquals('bool', $message->fields[2]->type);
        $this->assertEquals(3, $message->fields[2]->number);
    }

    public function testGenerateSubtitleRequestMessage(): void
    {
        $message = $this->findMessage('GenerateSubtitleRequest');
        $this->assertNotNull($message);

        $this->assertCount(5, $message->fields);

        $this->assertEquals('audio', $message->fields[0]->name);
        $this->assertEquals('common.v1.dto.BucketFile', $message->fields[0]->type);
        $this->assertEquals(1, $message->fields[0]->number);

        $this->assertEquals('parent_uuid', $message->fields[1]->name);
        $this->assertEquals('string', $message->fields[1]->type);
        $this->assertEquals(2, $message->fields[1]->number);
        $this->assertSame('optional', $message->fields[1]->modifier?->name);

        $this->assertEquals('hash', $message->fields[2]->name);
        $this->assertEquals('string', $message->fields[2]->type);
        $this->assertEquals(3, $message->fields[2]->number);

        $this->assertEquals('language', $message->fields[3]->name);
        $this->assertEquals('string', $message->fields[3]->type);
        $this->assertEquals(4, $message->fields[3]->number);
        $this->assertSame('optional', $message->fields[3]->modifier?->name);

        $this->assertEquals('translate', $message->fields[4]->name);
        $this->assertEquals('bool', $message->fields[4]->type);
        $this->assertEquals(5, $message->fields[4]->number);
    }

    public function testCreateRequestMessage(): void
    {
        $message = $this->findMessage('CreateRequest');
        $this->assertNotNull($message);

        $this->assertCount(4, $message->fields);

        $this->assertEquals('audio', $message->fields[0]->name);
        $this->assertEquals('common.v1.dto.BucketFile', $message->fields[0]->type);
        $this->assertEquals(1, $message->fields[0]->number);

        $this->assertEquals('hash', $message->fields[1]->name);
        $this->assertEquals('string', $message->fields[1]->type);
        $this->assertEquals(2, $message->fields[1]->number);

        $this->assertEquals('language', $message->fields[2]->name);
        $this->assertEquals('string', $message->fields[2]->type);
        $this->assertEquals(3, $message->fields[2]->number);
        $this->assertSame('optional', $message->fields[2]->modifier?->name);

        $this->assertEquals('parent_uuid', $message->fields[3]->name);
        $this->assertEquals('string', $message->fields[3]->type);
        $this->assertEquals(4, $message->fields[3]->number);
        $this->assertSame('optional', $message->fields[3]->modifier?->name);
    }

    public function testStartProcessingMessage(): void
    {
        $message = $this->findMessage('StartProcessing');
        $this->assertNotNull($message);

        $this->assertCount(1, $message->fields);

        $this->assertEquals('uuid', $message->fields[0]->name);
        $this->assertEquals('string', $message->fields[0]->type);
        $this->assertEquals(1, $message->fields[0]->number);
    }

    public function testSubtitleProcessedMessage(): void
    {
        $message = $this->findMessage('SubtitleProcessed');
        $this->assertNotNull($message);

        $this->assertCount(2, $message->fields);

        $this->assertEquals('uuid', $message->fields[0]->name);
        $this->assertEquals('string', $message->fields[0]->type);
        $this->assertEquals(1, $message->fields[0]->number);

        $this->assertEquals('subtitle', $message->fields[1]->name);
        $this->assertEquals('subtitles.v1.dto.Subtitle', $message->fields[1]->type);
        $this->assertEquals(2, $message->fields[1]->number);
    }

    public function testSubtitleFailedMessage(): void
    {
        $message = $this->findMessage('SubtitleFailed');
        $this->assertNotNull($message);

        $this->assertCount(2, $message->fields);

        $this->assertEquals('uuid', $message->fields[0]->name);
        $this->assertEquals('string', $message->fields[0]->type);
        $this->assertEquals(1, $message->fields[0]->number);

        $this->assertEquals('reason', $message->fields[1]->name);
        $this->assertEquals('string', $message->fields[1]->type);
        $this->assertEquals(2, $message->fields[1]->number);
    }

    public function testCancelProcessingMessage(): void
    {
        $message = $this->findMessage('CancelProcessing');
        $this->assertNotNull($message);

        $this->assertCount(2, $message->fields);

        $this->assertEquals('uuid', $message->fields[0]->name);
        $this->assertEquals('string', $message->fields[0]->type);
        $this->assertEquals(1, $message->fields[0]->number);

        $this->assertEquals('reason', $message->fields[1]->name);
        $this->assertEquals('string', $message->fields[1]->type);
        $this->assertEquals(2, $message->fields[1]->number);
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
