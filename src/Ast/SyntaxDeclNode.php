<?php

declare(strict_types=1);

namespace Butschster\ProtoParser\Ast;

use Phplrt\Contracts\Ast\NodeInterface;

final readonly class SyntaxDeclNode implements NodeInterface
{
    public function __construct(
        /** @var non-empty-string */
        public string $syntax,
        /** @var CommentNode[] */
        public array $comments = [],
    ) {}

    public function getIterator(): \Traversable
    {
        return new \EmptyIterator();
    }
}

