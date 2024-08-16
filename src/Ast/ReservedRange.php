<?php

declare(strict_types=1);

namespace Butschster\ProtoParser\Ast;

final class ReservedRange
{
    public function __construct(
        public int $start,
        public int|string $end,
    ) {}
}
