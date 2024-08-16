<?php

declare(strict_types=1);

namespace Butschster\ProtoParser\Ast;

enum FieldModifier
{
    case Required;
    case Optional;
    case Repeated;
}
