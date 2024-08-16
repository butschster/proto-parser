<?php

declare(strict_types=1);

namespace Butschster\ProtoParser\Ast;

use Phplrt\Contracts\Ast\NodeInterface;

final readonly class EnumFieldNode implements NodeInterface
{
    public function __construct(
        /** @var non-empty-string */
        public string $name,
        /** @var positive-int|0 */
        public int $number,
        /** @var OptionDeclNode[] */
        public array $options = [],
        /** @var CommentNode[] */
        public array $comments = [],
    ) {}

    public function getIterator(): \Traversable
    {
        return new \EmptyIterator();
    }
}
