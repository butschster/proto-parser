<?php

declare(strict_types=1);

namespace Butschster\ProtoParser\Ast;

use Phplrt\Contracts\Ast\NodeInterface;

final readonly class OneofDeclNode implements NodeInterface
{
    public function __construct(
        public string $name,
        /** @var OneofFieldNode[] */
        public array $fields = [],
        /** @var OptionDeclNode[] */
        public array $options = [],
        /** @var CommentNode[] */
        public array $comments = [],
    ) {}

    public function getIterator(): \Traversable
    {
        yield from $this->fields;
    }
}

