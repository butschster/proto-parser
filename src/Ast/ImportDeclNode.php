<?php

declare(strict_types=1);

namespace Butschster\ProtoParser\Ast;

use Phplrt\Contracts\Ast\NodeInterface;

final readonly class ImportDeclNode implements NodeInterface
{
    public function __construct(
        public string $path,
        public ?ImportModifier $modifier = null,
        public array $comments = [],
    ) {}

    public function getIterator(): \Traversable
    {
        return new \EmptyIterator();
    }
}

