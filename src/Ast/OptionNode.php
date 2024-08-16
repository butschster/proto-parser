<?php

declare(strict_types=1);

namespace Butschster\ProtoParser\Ast;

final readonly class OptionNode
{
    public function __construct(
        public string $name,
        /** @var mixed|OptionDeclNode */
        public mixed $value,
        /** @var CommentNode[] */
        public array $comments = [],
    ) {}

    public function getIterator(): \Traversable
    {
        return new \EmptyIterator();
    }
}
