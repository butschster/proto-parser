<?php

declare(strict_types=1);

namespace Butschster\Tests\Feature;

use Butschster\ProtoParser\Ast\ProtoNode;
use Butschster\ProtoParser\ProtoParser;
use Butschster\ProtoParser\ProtoParserFactory;
use Butschster\Tests\TestCase;

final class AssetTest extends TestCase
{
    protected ProtoParser $parser;
    private ProtoNode $ast;

    protected function setUp(): void
    {
        $this->parser = ProtoParserFactory::create();
        $this->ast = $this->parser->parse(
            <<<'PROTO'
syntax = "proto3";

package auth.v2.public.request;

import "auth/v2/message.proto";

option php_namespace = "Internal\\Shared\\gRPC\\Services\\Auth\\v2\\Public\\Request";
option php_metadata_namespace = "Internal\\Shared\\gRPC\\ProtobufMetadata\\Auth\\v2\\Public";

message LoginRequest {
  string email = 1;
  string password = 2;
  // For what purposes requested token: web, mobile, desktop, api
  // string type = 3;
  reserved 3;
  auth.v2.dto.ClientContext context = 4;
}

// @Guarded
message LogoutRequest {
}

// @Guarded
message MeRequest {
  auth.v2.dto.ClientContext context = 1;
}

message RegisterRequest {
  string email = 1;

  message Profile {
    // @Optional
    // @DefaultValue(value=null)
    string first_name = 1;
    // @Optional
    // @DefaultValue(value=null)
    string last_name = 2;
    // @Optional
    // @DefaultValue(value=null)
    string company_name = 3;
    // @Optional
    // @DefaultValue(value=null)
    string company_role = 4;
    // @Optional
    // @DefaultValue(value=null)
    string timezone = 5;
    // @Optional
    // @DefaultValue(value=null)
    string language = 6;
  }

  Profile profile = 4;

  string password = 5;

  auth.v2.dto.ClientContext context = 7;
}

// Регистрация проекта при регистрации пользователя
message RegisterProjectRequest {
  string token = 1;

  message Project {
    // @Optional
    // @DefaultValue(value=null)
    string name = 1;
  }

  Project project = 2;

  message AssetData {
    // @Optional
    // @DefaultValue(value=null)
    string assets = 1;
    // @Optional
    // @DefaultValue(value=null)
    string excluded_assets = 2;
  }

  AssetData asset_data = 3;
}

message ForgotPasswordRequest {
  string email = 1;
  auth.v2.dto.ClientContext context = 2;
}

// Используется для сброса пароля
message ResetPasswordRequest {
  string token = 1;
  string password = 2;
}

// Используется для смены пароля после создания пользователя администратором
message ChangePasswordRequest {
  string token = 1;
  string password = 2;
}

// Проверка email на валидность и что он не занят
message ValidateEmailRequest {
  string email = 1;
}

// Генерация токена для подтверждения email
message GenerateEmailVerificationTokenRequest {
  string email = 1;
  auth.v2.dto.ClientContext context = 2;
}

// Подтверждение email
message MarkEmailAsVerifiedRequest {
  string token = 1;
  auth.v2.dto.ClientContext context = 2;
}
PROTO,
        );
    }

    public function testSyntaxDeclaration(): void
    {
        dump($this->ast);
    }
}
