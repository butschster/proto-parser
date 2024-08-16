<?php

declare(strict_types=1);

namespace Butschster\ProtoParser\Ast;

final readonly class RpcMessageType
{
    public function __construct(
        public string $name,
        public bool $isStream = false,
    ) {}
}
