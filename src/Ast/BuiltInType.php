<?php

declare(strict_types=1);

namespace Butschster\ProtoParser\Ast;

enum BuiltInType: string
{
    case Double = 'double';
    case Float = 'float';
    case Int32 = 'int32';
    case Int64 = 'int64';
    case Uint32 = 'uint32';
    case Uint64 = 'uint64';
    case Sint32 = 'sint32';
    case Sint64 = 'sint64';
    case Fixed32 = 'fixed32';
    case Fixed64 = 'fixed64';
    case Sfixed32 = 'sfixed32';
    case Sfixed64 = 'sfixed64';
    case Bool = 'bool';
    case String = 'string';
    case Bytes = 'bytes';
}
