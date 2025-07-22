<?php

declare(strict_types=1);

namespace Butschster\ProtoParser\Ast;

use Phplrt\Contracts\Ast\NodeInterface;

final readonly class MessageDefNode implements NodeInterface
{
    public function __construct(
        /** @var non-empty-string */
        public string $name,
        /** @var FieldDeclNode[]|OneofDeclNode[]|MapFieldDeclNode|ReservedNode[] */
        public array $fields = [],
        /** @var MessageDefNode */
        public array $messages = [],
        /** @var EnumDefNode */
        public array $enums = [],
        /** @var CommentNode[] */
        public array $comments = [],
    ) {}

    public function getIterator(): \Traversable
    {
        yield from $this->fields;
    }
}
