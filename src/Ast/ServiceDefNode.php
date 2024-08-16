<?php

declare(strict_types=1);

namespace Butschster\ProtoParser\Ast;

use Phplrt\Contracts\Ast\NodeInterface;

final readonly class ServiceDefNode implements NodeInterface
{
    public function __construct(
        /** @var non-empty-string */
        public string $name,
        /** @var RpcDeclNode[] */
        public array $methods = [],
        /** @var OptionDeclNode[] */
        public array $options = [],
        /** @var CommentNode[] */
        public array $comments = []
    ) {}

    public function getIterator(): \Traversable
    {
        yield from $this->methods;
    }
}

