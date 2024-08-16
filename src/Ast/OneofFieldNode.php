<?php

declare(strict_types=1);

namespace Butschster\ProtoParser\Ast;

use Phplrt\Contracts\Ast\NodeInterface;

final readonly class OneofFieldNode implements NodeInterface
{
    public function __construct(
        public FieldType $type,
        public string $name,
        public int $number,
        public array $options = [],
    ) {}

    public function getIterator(): \Traversable
    {
        return new \EmptyIterator();
    }
}
