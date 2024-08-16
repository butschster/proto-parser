<?php

declare(strict_types=1);

namespace Butschster\Tests\Parsers;

final class MessageTest extends TestCase
{
    public function testParseMessage(): void
    {
        $this->assertAst(
            <<<PROTO
syntax = "proto3";

package subtitles.v1.dto;

import "common/v1/message.proto";

option php_metadata_namespace = "GRPC\\ProtobufMetadata\\Subtitles\\v1";
option php_namespace = "GRPC\\Services\\Subtitles\\v1";

message Subtitle {
  message Segment {
    uint32 id = 1;
    string start = 2;
    string end = 3;
    string text = 4;
    uint32 tokens = 5;
    string speaker = 6;
  }

  string uuid = 1;
  repeated Segment segments = 2;
  uint32 total_tokens = 3;
  float duration = 4;
  string language = 5; // The language of the subtitles
  string hash = 6; // Checksum of the subtitles
  common.v1.dto.BucketFile result = 7; // The subtitles file
}

message SubtitleRecord {
  string uuid = 1;
}

PROTO,
            <<<AST

AST,
        );
    }
}
