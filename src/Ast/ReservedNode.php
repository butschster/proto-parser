<?php

declare(strict_types=1);

namespace Butschster\ProtoParser\Ast;

use Phplrt\Contracts\Ast\NodeInterface;

final readonly class ReservedNode implements NodeInterface
{
    public function __construct(
        /** @var ReservedRange[]|ReservedNumber[] */
        public array $ranges,
        /** @var CommentNode[] */
        public array $comments = []
    ) {}

    public function getIterator(): \Traversable
    {
        return new \EmptyIterator();
    }
}
