<?php

declare(strict_types=1);

namespace Butschster\Tests\Ast;

use Butschster\ProtoParser\Ast\RpcMessageType;
use Butschster\ProtoParser\Ast\ServiceDefNode;
use Butschster\ProtoParser\Ast\RpcDeclNode;
use Butschster\ProtoParser\Ast\OptionDeclNode;

final class ServiceDefNodeTest extends TestCase
{
    public function testBasicServiceDefinition(): void
    {
        $node = $this->parser->parse(
            <<<'PROTO'
            syntax = "proto3";

            package example;

            service Greeter {
                rpc SayHello (HelloRequest) returns (HelloReply);
            }
            PROTO,
        );

        $this->assertSame('proto3', $node->syntax->syntax);
        $this->assertSame('example', $node->package->name);

        $this->assertCount(1, $node->topLevelDefs);
        $service = $node->topLevelDefs[0];

        $this->assertInstanceOf(ServiceDefNode::class, $service);
        $this->assertSame('Greeter', $service->name);
        $this->assertCount(1, $service->methods);

        $method = $service->methods[0];
        $this->assertInstanceOf(RpcDeclNode::class, $method);
        $this->assertSame('SayHello', $method->name);
        $this->assertEquals(new RpcMessageType('HelloRequest'), $method->inputType);
        $this->assertEquals(new RpcMessageType('HelloReply'), $method->outputType);
        $this->assertEmpty($method->options);
    }

    public function testServiceWithMultipleMethods(): void
    {
        $node = $this->parser->parse(
            <<<'PROTO'
            syntax = "proto3";

            package example;

            service Calculator {
                rpc Add (CalcRequest) returns (CalcResponse);
                rpc Subtract (CalcRequest) returns (CalcResponse);
                rpc Multiply (CalcRequest) returns (CalcResponse);
                rpc Divide (CalcRequest) returns (CalcResponse);
            }
            PROTO,
        );

        $this->assertSame('proto3', $node->syntax->syntax);
        $this->assertSame('example', $node->package->name);

        $this->assertCount(1, $node->topLevelDefs);
        $service = $node->topLevelDefs[0];

        $this->assertInstanceOf(ServiceDefNode::class, $service);
        $this->assertSame('Calculator', $service->name);
        $this->assertCount(4, $service->methods);

        $expectedMethods = ['Add', 'Subtract', 'Multiply', 'Divide'];
        foreach ($service->methods as $index => $method) {
            $this->assertInstanceOf(RpcDeclNode::class, $method);
            $this->assertSame($expectedMethods[$index], $method->name);
            $this->assertEquals(new RpcMessageType('CalcRequest'), $method->inputType);
            $this->assertEquals(new RpcMessageType('CalcResponse'), $method->outputType);
            $this->assertEmpty($method->options);
        }
    }

    public function testServiceWithOptions(): void
    {
        $node = $this->parser->parse(
            <<<'PROTO'
            syntax = "proto3";

            package example;

            service UserService {
                option (google.api.default_host) = "user.example.com";
                rpc GetUser (GetUserRequest) returns (User) {
                    option (google.api.http) = {
                        get: "/v1/users/{user_id}"
                    };
                }
            }
            PROTO,
        );

        $this->assertSame('proto3', $node->syntax->syntax);
        $this->assertSame('example', $node->package->name);

        $this->assertCount(1, $node->topLevelDefs);
        $service = $node->topLevelDefs[0];

        $this->assertInstanceOf(ServiceDefNode::class, $service);
        $this->assertSame('UserService', $service->name);
        $this->assertCount(1, $service->methods);

        $method = $service->methods[0];
        $this->assertInstanceOf(RpcDeclNode::class, $method);
        $this->assertSame('GetUser', $method->name);
        $this->assertSame('GetUserRequest', $method->inputType);
        $this->assertSame('User', $method->outputType);
        $this->assertCount(1, $method->options);

        $option = $method->options[0];
        $this->assertInstanceOf(OptionDeclNode::class, $option);
        $this->assertSame('google.api.http', $option->name);
        $this->assertIsArray($option->value);
        $this->assertArrayHasKey('get', $option->value);
        $this->assertSame('/v1/users/{user_id}', $option->value['get']);
    }

    public function testServiceWithStreamingMethods(): void
    {
        $node = $this->parser->parse(
            <<<'PROTO'
            syntax = "proto3";

            package example;

            service StreamService {
                rpc ServerStreaming (StreamRequest) returns (stream StreamResponse);
                rpc ClientStreaming (stream StreamRequest) returns (StreamResponse);
                rpc BidirectionalStreaming (stream StreamRequest) returns (stream StreamResponse);
            }
            PROTO,
        );

        $this->assertSame('proto3', $node->syntax->syntax);
        $this->assertSame('example', $node->package->name);

        $this->assertCount(1, $node->topLevelDefs);
        $service = $node->topLevelDefs[0];

        $this->assertInstanceOf(ServiceDefNode::class, $service);
        $this->assertSame('StreamService', $service->name);
        $this->assertCount(3, $service->methods);

        $serverStreaming = $service->methods[0];
        $this->assertInstanceOf(RpcDeclNode::class, $serverStreaming);
        $this->assertSame('ServerStreaming', $serverStreaming->name);
        $this->assertEquals(new RpcMessageType('StreamRequest'), $serverStreaming->inputType);
        $this->assertEquals(new RpcMessageType('StreamResponse', true), $serverStreaming->outputType);

        $clientStreaming = $service->methods[1];
        $this->assertInstanceOf(RpcDeclNode::class, $clientStreaming);
        $this->assertSame('ClientStreaming', $clientStreaming->name);
        $this->assertEquals(new RpcMessageType('StreamRequest', true), $clientStreaming->inputType);
        $this->assertEquals(new RpcMessageType('StreamResponse'), $clientStreaming->outputType);

        $bidirectionalStreaming = $service->methods[2];
        $this->assertInstanceOf(RpcDeclNode::class, $bidirectionalStreaming);
        $this->assertSame('BidirectionalStreaming', $bidirectionalStreaming->name);
        $this->assertEquals(new RpcMessageType('StreamRequest', true), $bidirectionalStreaming->inputType);
        $this->assertEquals(new RpcMessageType('StreamResponse', true), $bidirectionalStreaming->outputType);
    }
}
