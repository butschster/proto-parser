<?php

declare(strict_types=1);

namespace Butschster\ProtoParser\Ast;

use Phplrt\Contracts\Ast\NodeInterface;

final readonly class ExtensionsNode implements NodeInterface
{
    public function __construct(
        public array $ranges,
    ) {}

    public function getIterator(): \Traversable
    {
        return new \EmptyIterator();
    }
}
