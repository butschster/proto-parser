<?php

declare(strict_types=1);

namespace Butschster\ProtoParser\Ast;

use Phplrt\Contracts\Ast\NodeInterface;

final readonly class FieldDeclNode implements NodeInterface
{
    public function __construct(
        public FieldType $type,
        /** @var non-empty-string */
        public string $name,
        /** @var positive-int */
        public int $number,
        public ?FieldModifier $modifier = null,
        /** @var OptionNode[] */
        public array $options = [],
        /** @var CommentNode[] */
        public array $comments = [],
    ) {}

    public function getIterator(): \Traversable
    {
        return new \EmptyIterator();
    }
}
