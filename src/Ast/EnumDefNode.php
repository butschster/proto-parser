<?php

declare(strict_types=1);

namespace Butschster\ProtoParser\Ast;

use Phplrt\Contracts\Ast\NodeInterface;

final readonly class EnumDefNode implements NodeInterface
{
    public function __construct(
        /** @var non-empty-string */
        public string $name,
        /** @var EnumFieldNode[] */
        public array $fields = [],
        /** @var OptionDeclNode[] */
        public array $comments = [],
    ) {}

    public function getIterator(): \Traversable
    {
        yield from $this->fields;
    }
}
