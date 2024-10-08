<?php

declare(strict_types=1);

namespace Butschster\ProtoParser\Ast;

final class ReservedNumber
{
    public function __construct(
        /** @var positive-int */
        public int $value,
    ) {}
}
