<?php

declare(strict_types=1);

namespace Butschster\ProtoParser\Ast;

final readonly class FieldType
{
    public function __construct(
        public string $type,
    ) {}
}
