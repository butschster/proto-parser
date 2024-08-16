<?php

declare(strict_types=1);

namespace Butschster\ProtoParser\Ast;

use Phplrt\Contracts\Ast\NodeInterface;

final readonly class MapFieldDeclNode implements NodeInterface
{
    public function __construct(
        public FieldType $keyType,
        public FieldType $valueType,
        public string $name,
        public int $number,
        public array $options = [],
        public array $comments = [],
    ) {}

    public function getIterator(): \Traversable
    {
        return new \EmptyIterator();
    }
}
