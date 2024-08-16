<?php

declare(strict_types=1);

namespace Butschster\ProtoParser\Ast;

use Phplrt\Contracts\Ast\NodeInterface;

final readonly class FieldDeclNode implements NodeInterface
{
    public function __construct(
        public FieldType $type,
        public string $name,
        public int $number,
        public ?FieldModifier $modifier = null,
        public array $options = [],
        public array $comments = [],
    ) {}

    public function getIterator(): \Traversable
    {
        return new \EmptyIterator();
    }
}
