<?php

declare(strict_types=1);

namespace Butschster\ProtoParser\Ast;

final readonly class CommentNode
{
    public function __construct(
        /** @var non-empty-string */
        public string $text,
    ) {}

    public function getIterator(): \Traversable
    {
        return new \EmptyIterator();
    }
}
