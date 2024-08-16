<?php

declare(strict_types=1);

namespace Butschster\ProtoParser\Ast;

final class ReservedRange
{
    public function __construct(
        /** @var positive-int */
        public int $start,
        /** @var positive-int|max */
        public int|string $end,
    ) {}
}
