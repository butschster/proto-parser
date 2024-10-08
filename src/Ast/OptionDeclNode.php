<?php

declare(strict_types=1);

namespace Butschster\ProtoParser\Ast;

use Phplrt\Contracts\Ast\NodeInterface;

final readonly class OptionDeclNode implements NodeInterface
{
    public function __construct(
        public ?string $name,
        /** @var CommentNode[] */
        public array $comments = [],
        /** @var OptionNode[] */
        public array $options = [],
    ) {}

    public function getIterator(): \Traversable
    {
        return new \EmptyIterator();
    }
}
