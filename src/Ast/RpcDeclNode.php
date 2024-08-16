<?php

declare(strict_types=1);

namespace Butschster\ProtoParser\Ast;

use Phplrt\Contracts\Ast\NodeInterface;

final readonly class RpcDeclNode implements NodeInterface
{
    public function __construct(
        public string $name,
        public RpcMessageType $inputType,
        public RpcMessageType $outputType,
        public array $options = [],
        public array $comments = []
    ) {}

    public function getIterator(): \Traversable
    {
        yield from $this->options;
    }
}
