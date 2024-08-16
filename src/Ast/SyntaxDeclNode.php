<?php

declare(strict_types=1);

namespace Butschster\ProtoParser\Ast;

use Phplrt\Contracts\Ast\NodeInterface;

final readonly class SyntaxDeclNode implements NodeInterface
{
    public function __construct(
        public string $syntax,
        public array $comments = []
    ) {}

    public function getIterator(): \Traversable
    {
        return new \EmptyIterator();
    }
}

