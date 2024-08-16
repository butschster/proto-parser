<?php

declare(strict_types=1);

namespace Butschster\ProtoParser\Ast;

use Phplrt\Contracts\Ast\NodeInterface;

final readonly class MessageDefNode implements NodeInterface
{
    public function __construct(
        public string $name,
        public array $fields = [],
        public array $messages = [],
        public array $enums = [],
        public array $comments = [],
    ) {}

    public function getIterator(): \Traversable
    {
        yield from $this->fields;
    }
}
