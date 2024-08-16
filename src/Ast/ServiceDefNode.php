<?php

declare(strict_types=1);

namespace Butschster\ProtoParser\Ast;

use Phplrt\Contracts\Ast\NodeInterface;

final readonly class ServiceDefNode implements NodeInterface
{
    public function __construct(
        public string $name,
        public array $methods = [],
        public array $options = [],
        public array $comments = []
    ) {}

    public function getIterator(): \Traversable
    {
        yield from $this->methods;
    }
}

