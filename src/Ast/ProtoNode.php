<?php

declare(strict_types=1);

namespace Butschster\ProtoParser\Ast;

use Phplrt\Contracts\Ast\NodeInterface;

final readonly class ProtoNode implements NodeInterface
{
    public function __construct(
        public SyntaxDeclNode $syntax,
        public array $imports = [],
        public ?PackageDeclNode $package = null,
        public array $options = [],
        public array $topLevelDefs = [],
    ) {}

    public function getIterator(): \Traversable
    {
        yield $this->syntax;
        yield from $this->imports;
        if ($this->package) {
            yield $this->package;
        }
        yield from $this->options;
        yield from $this->topLevelDefs;
    }
}
