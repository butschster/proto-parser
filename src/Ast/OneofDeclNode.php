<?php

declare(strict_types=1);

namespace Butschster\ProtoParser\Ast;

use Phplrt\Contracts\Ast\NodeInterface;

final readonly class OneofDeclNode implements NodeInterface
{
    public function __construct(
        public string $name,
        public array $fields = [],
        public array $options = [],
        public array $comments = [],
    ) {}

    public function getIterator(): \Traversable
    {
        yield from $this->fields;
    }
}

