<?php

declare(strict_types=1);

namespace Butschster\ProtoParser\Ast;

use Phplrt\Contracts\Ast\NodeInterface;

final readonly class OneofFieldNode implements NodeInterface
{
    public function __construct(
        public FieldType $type,
        /** @var non-empty-string */
        public string $name,
        /** @var positive-int */
        public int $number,
        /** @var OptionDeclNode[] */
        public array $options = [],
    ) {}

    public function getIterator(): \Traversable
    {
        return new \EmptyIterator();
    }
}
