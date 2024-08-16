<?php

declare(strict_types=1);

/**
 * @var array{
 *     initial: array-key,
 *     tokens: array{
 *         default: array<non-empty-string, non-empty-string>,
 *         ...
 *     },
 *     skip: list<non-empty-string>,
 *     grammar: array<array-key, \Phplrt\Parser\Grammar\RuleInterface>,
 *     reducers: array<array-key, callable(\Phplrt\Parser\Context, mixed):mixed>,
 *     transitions?: array<array-key, mixed>
 * }
 */
return [
    'initial' => 'Proto',
    'tokens' => [
        'default' => [
            'T_SYNTAX' => 'syntax',
            'T_PACKAGE' => 'package',
            'T_IMPORT' => 'import',
            'T_MESSAGE' => 'message',
            'T_ENUM' => 'enum',
            'T_SERVICE' => 'service',
            'T_RPC' => 'rpc',
            'T_RETURNS' => 'returns',
            'T_STREAM' => 'stream',
            'T_REPEATED' => 'repeated',
            'T_OPTIONAL' => 'optional',
            'T_OPTION' => 'option',
            'T_REQUIRED' => 'required',
            'T_RESERVED' => 'reserved',
            'T_MAX' => 'max',
            'T_WEAK' => 'weak',
            'T_PUBLIC' => 'public',
            'T_MAP' => 'map',
            'T_ONEOF' => 'oneof',
            'T_DOUBLE' => 'double',
            'T_FLOAT' => 'float',
            'T_INT32' => 'int32',
            'T_INT64' => 'int64',
            'T_UINT32' => 'uint32',
            'T_UINT64' => 'uint64',
            'T_SINT32' => 'sint32',
            'T_SINT64' => 'sint64',
            'T_FIXED32' => 'fixed32',
            'T_FIXED64' => 'fixed64',
            'T_SFIXED32' => 'sfixed32',
            'T_SFIXED64' => 'sfixed64',
            'T_BOOL' => 'bool',
            'T_STRING' => 'string',
            'T_BYTES' => 'bytes',
            'T_INT_LITERAL' => '-?[0-9]+',
            'T_FLOAT_LITERAL' => '-?[0-9]*\\.[0-9]+([eE][+-]?[0-9]+)?',
            'T_STRING_LITERAL' => '"([^"\\\\]*(?:\\\\.[^"\\\\]*)*)"',
            'T_BOOL_LITERAL' => 'true|false',
            'T_COMMENT' => '//.*?$|/\\*(.|\\n)*?\\*/',
            'T_COLON' => ':',
            'T_SEMICOLON' => ';',
            'T_EQUALS' => '=',
            'T_LPAREN' => '\\(',
            'T_RPAREN' => '\\)',
            'T_LBRACE' => '{',
            'T_RBRACE' => '}',
            'T_LBRACK' => '\\[',
            'T_RBRACK' => '\\]',
            'T_LT' => '<',
            'T_GT' => '>',
            'T_COMMA' => ',',
            'T_DOT' => '\\.',
            'T_TO' => 'to',
            'T_IDENTIFIER' => '[a-zA-Z_][a-zA-Z0-9_]*',
            'T_WHITESPACE' => '\\s+',
        ],
    ],
    'skip' => [
        'T_WHITESPACE',
    ],
    'transitions' => [],
    'grammar' => [
        0 => new \Phplrt\Parser\Grammar\Alternation(['MessageDef', 'EnumDef', 'ServiceDef']),
        1 => new \Phplrt\Parser\Grammar\Alternation(['ImportDecl', 'PackageDecl', 'OptionDecl', 0]),
        2 => new \Phplrt\Parser\Grammar\Repetition(1, 0, INF),
        3 => new \Phplrt\Parser\Grammar\Repetition('Comment', 0, INF),
        4 => new \Phplrt\Parser\Grammar\Lexeme('T_SYNTAX', false),
        5 => new \Phplrt\Parser\Grammar\Lexeme('T_EQUALS', false),
        6 => new \Phplrt\Parser\Grammar\Lexeme('T_STRING_LITERAL', true),
        7 => new \Phplrt\Parser\Grammar\Lexeme('T_SEMICOLON', false),
        8 => new \Phplrt\Parser\Grammar\Alternation([14, 15]),
        9 => new \Phplrt\Parser\Grammar\Repetition('Comment', 0, INF),
        10 => new \Phplrt\Parser\Grammar\Lexeme('T_IMPORT', false),
        11 => new \Phplrt\Parser\Grammar\Optional(8),
        12 => new \Phplrt\Parser\Grammar\Lexeme('T_STRING_LITERAL', true),
        13 => new \Phplrt\Parser\Grammar\Lexeme('T_SEMICOLON', false),
        14 => new \Phplrt\Parser\Grammar\Lexeme('T_WEAK', true),
        15 => new \Phplrt\Parser\Grammar\Lexeme('T_PUBLIC', true),
        16 => new \Phplrt\Parser\Grammar\Concatenation([203, 204]),
        17 => new \Phplrt\Parser\Grammar\Repetition('Comment', 0, INF),
        18 => new \Phplrt\Parser\Grammar\Lexeme('T_PACKAGE', false),
        19 => new \Phplrt\Parser\Grammar\Lexeme('T_SEMICOLON', false),
        20 => new \Phplrt\Parser\Grammar\Concatenation([31, 32]),
        21 => new \Phplrt\Parser\Grammar\Alternation([33, 34]),
        22 => new \Phplrt\Parser\Grammar\Repetition('Comment', 0, INF),
        23 => new \Phplrt\Parser\Grammar\Lexeme('T_OPTION', false),
        24 => new \Phplrt\Parser\Grammar\Lexeme('T_EQUALS', false),
        25 => new \Phplrt\Parser\Grammar\Lexeme('T_SEMICOLON', false),
        26 => new \Phplrt\Parser\Grammar\Lexeme('T_LPAREN', false),
        27 => new \Phplrt\Parser\Grammar\Lexeme('T_RPAREN', false),
        28 => new \Phplrt\Parser\Grammar\Concatenation([26, 16, 27]),
        29 => new \Phplrt\Parser\Grammar\Lexeme('T_DOT', false),
        30 => new \Phplrt\Parser\Grammar\Concatenation([29, 16]),
        31 => new \Phplrt\Parser\Grammar\Alternation([28, 16]),
        32 => new \Phplrt\Parser\Grammar\Repetition(30, 0, INF),
        33 => new \Phplrt\Parser\Grammar\Alternation([98, 99, 100, 101, 16]),
        34 => new \Phplrt\Parser\Grammar\Concatenation([41, 42, 43]),
        35 => new \Phplrt\Parser\Grammar\Concatenation([44, 20, 45, 46, 47]),
        36 => new \Phplrt\Parser\Grammar\Lexeme('T_COMMA', false),
        37 => new \Phplrt\Parser\Grammar\Concatenation([36, 35]),
        38 => new \Phplrt\Parser\Grammar\Repetition(35, 0, INF),
        39 => new \Phplrt\Parser\Grammar\Repetition(37, 0, INF),
        40 => new \Phplrt\Parser\Grammar\Concatenation([38, 39]),
        41 => new \Phplrt\Parser\Grammar\Lexeme('T_LBRACE', false),
        42 => new \Phplrt\Parser\Grammar\Optional(40),
        43 => new \Phplrt\Parser\Grammar\Lexeme('T_RBRACE', false),
        44 => new \Phplrt\Parser\Grammar\Repetition('Comment', 0, INF),
        45 => new \Phplrt\Parser\Grammar\Lexeme('T_COLON', false),
        46 => new \Phplrt\Parser\Grammar\Alternation([33, 34]),
        47 => new \Phplrt\Parser\Grammar\Repetition('Comment', 0, INF),
        48 => new \Phplrt\Parser\Grammar\Alternation(['FieldDecl', 'EnumDef', 'MessageDef', 'OptionDecl', 'OneofDecl', 'MapFieldDecl', 'Reserved']),
        49 => new \Phplrt\Parser\Grammar\Repetition('Comment', 0, INF),
        50 => new \Phplrt\Parser\Grammar\Lexeme('T_MESSAGE', false),
        51 => new \Phplrt\Parser\Grammar\Lexeme('T_IDENTIFIER', true),
        52 => new \Phplrt\Parser\Grammar\Lexeme('T_LBRACE', false),
        53 => new \Phplrt\Parser\Grammar\Repetition(48, 0, INF),
        54 => new \Phplrt\Parser\Grammar\Lexeme('T_RBRACE', false),
        55 => new \Phplrt\Parser\Grammar\Alternation([66, 67, 68]),
        56 => new \Phplrt\Parser\Grammar\Alternation(['BuiltInType', 69]),
        57 => new \Phplrt\Parser\Grammar\Concatenation([79, 'FieldOption', 80, 81]),
        58 => new \Phplrt\Parser\Grammar\Repetition('Comment', 0, INF),
        59 => new \Phplrt\Parser\Grammar\Optional(55),
        60 => new \Phplrt\Parser\Grammar\Lexeme('T_IDENTIFIER', true),
        61 => new \Phplrt\Parser\Grammar\Lexeme('T_EQUALS', false),
        62 => new \Phplrt\Parser\Grammar\Lexeme('T_INT_LITERAL', true),
        63 => new \Phplrt\Parser\Grammar\Optional(57),
        64 => new \Phplrt\Parser\Grammar\Lexeme('T_SEMICOLON', false),
        65 => new \Phplrt\Parser\Grammar\Repetition('Comment', 0, INF),
        66 => new \Phplrt\Parser\Grammar\Lexeme('T_REPEATED', false),
        67 => new \Phplrt\Parser\Grammar\Lexeme('T_OPTIONAL', false),
        68 => new \Phplrt\Parser\Grammar\Lexeme('T_REQUIRED', false),
        69 => new \Phplrt\Parser\Grammar\Concatenation([74, 75, 76]),
        70 => new \Phplrt\Parser\Grammar\Lexeme('T_DOT', true),
        71 => new \Phplrt\Parser\Grammar\Lexeme('T_DOT', true),
        72 => new \Phplrt\Parser\Grammar\Lexeme('T_IDENTIFIER', true),
        73 => new \Phplrt\Parser\Grammar\Concatenation([71, 72]),
        74 => new \Phplrt\Parser\Grammar\Optional(70),
        75 => new \Phplrt\Parser\Grammar\Lexeme('T_IDENTIFIER', true),
        76 => new \Phplrt\Parser\Grammar\Repetition(73, 0, INF),
        77 => new \Phplrt\Parser\Grammar\Lexeme('T_COMMA', false),
        78 => new \Phplrt\Parser\Grammar\Concatenation([77, 'FieldOption']),
        79 => new \Phplrt\Parser\Grammar\Lexeme('T_LBRACK', false),
        80 => new \Phplrt\Parser\Grammar\Repetition(78, 0, INF),
        81 => new \Phplrt\Parser\Grammar\Lexeme('T_RBRACK', false),
        82 => new \Phplrt\Parser\Grammar\Alternation([33, 84, 85, 86]),
        83 => new \Phplrt\Parser\Grammar\Lexeme('T_EQUALS', false),
        84 => new \Phplrt\Parser\Grammar\Concatenation([92, 93, 94]),
        85 => new \Phplrt\Parser\Grammar\Lexeme('T_STRING_LITERAL', true),
        86 => new \Phplrt\Parser\Grammar\Lexeme('T_BOOL_LITERAL', true),
        87 => new \Phplrt\Parser\Grammar\Concatenation([95, 96, 97]),
        88 => new \Phplrt\Parser\Grammar\Lexeme('T_COMMA', false),
        89 => new \Phplrt\Parser\Grammar\Concatenation([88, 87]),
        90 => new \Phplrt\Parser\Grammar\Repetition(89, 0, INF),
        91 => new \Phplrt\Parser\Grammar\Concatenation([87, 90]),
        92 => new \Phplrt\Parser\Grammar\Lexeme('T_LBRACE', false),
        93 => new \Phplrt\Parser\Grammar\Optional(91),
        94 => new \Phplrt\Parser\Grammar\Lexeme('T_RBRACE', false),
        95 => new \Phplrt\Parser\Grammar\Lexeme('T_IDENTIFIER', true),
        96 => new \Phplrt\Parser\Grammar\Lexeme('T_COLON', false),
        97 => new \Phplrt\Parser\Grammar\Alternation([33, 84]),
        98 => new \Phplrt\Parser\Grammar\Lexeme('T_INT_LITERAL', true),
        99 => new \Phplrt\Parser\Grammar\Lexeme('T_FLOAT_LITERAL', true),
        100 => new \Phplrt\Parser\Grammar\Lexeme('T_STRING_LITERAL', true),
        101 => new \Phplrt\Parser\Grammar\Lexeme('T_BOOL_LITERAL', true),
        102 => new \Phplrt\Parser\Grammar\Alternation(['OptionDecl', 'OneofField']),
        103 => new \Phplrt\Parser\Grammar\Repetition('Comment', 0, INF),
        104 => new \Phplrt\Parser\Grammar\Lexeme('T_ONEOF', false),
        105 => new \Phplrt\Parser\Grammar\Lexeme('T_IDENTIFIER', true),
        106 => new \Phplrt\Parser\Grammar\Lexeme('T_LBRACE', false),
        107 => new \Phplrt\Parser\Grammar\Repetition(102, 0, INF),
        108 => new \Phplrt\Parser\Grammar\Lexeme('T_RBRACE', false),
        109 => new \Phplrt\Parser\Grammar\Lexeme('T_IDENTIFIER', true),
        110 => new \Phplrt\Parser\Grammar\Lexeme('T_EQUALS', false),
        111 => new \Phplrt\Parser\Grammar\Lexeme('T_INT_LITERAL', true),
        112 => new \Phplrt\Parser\Grammar\Optional(57),
        113 => new \Phplrt\Parser\Grammar\Lexeme('T_SEMICOLON', false),
        114 => new \Phplrt\Parser\Grammar\Repetition('Comment', 0, INF),
        115 => new \Phplrt\Parser\Grammar\Lexeme('T_MAP', false),
        116 => new \Phplrt\Parser\Grammar\Lexeme('T_LT', false),
        117 => new \Phplrt\Parser\Grammar\Lexeme('T_COMMA', false),
        118 => new \Phplrt\Parser\Grammar\Lexeme('T_GT', false),
        119 => new \Phplrt\Parser\Grammar\Lexeme('T_IDENTIFIER', true),
        120 => new \Phplrt\Parser\Grammar\Lexeme('T_EQUALS', false),
        121 => new \Phplrt\Parser\Grammar\Lexeme('T_INT_LITERAL', true),
        122 => new \Phplrt\Parser\Grammar\Optional(57),
        123 => new \Phplrt\Parser\Grammar\Lexeme('T_SEMICOLON', false),
        124 => new \Phplrt\Parser\Grammar\Concatenation(['Range', 131]),
        125 => new \Phplrt\Parser\Grammar\Concatenation([138, 139]),
        126 => new \Phplrt\Parser\Grammar\Lexeme('T_RESERVED', false),
        127 => new \Phplrt\Parser\Grammar\Alternation([124, 125]),
        128 => new \Phplrt\Parser\Grammar\Lexeme('T_SEMICOLON', false),
        129 => new \Phplrt\Parser\Grammar\Lexeme('T_COMMA', false),
        130 => new \Phplrt\Parser\Grammar\Concatenation([129, 'Range']),
        131 => new \Phplrt\Parser\Grammar\Repetition(130, 0, INF),
        132 => new \Phplrt\Parser\Grammar\Concatenation([198, 199]),
        133 => new \Phplrt\Parser\Grammar\Lexeme('T_INT_LITERAL', true),
        134 => new \Phplrt\Parser\Grammar\Optional(132),
        135 => new \Phplrt\Parser\Grammar\Lexeme('T_COMMA', false),
        136 => new \Phplrt\Parser\Grammar\Lexeme('T_STRING_LITERAL', true),
        137 => new \Phplrt\Parser\Grammar\Concatenation([135, 136]),
        138 => new \Phplrt\Parser\Grammar\Lexeme('T_STRING_LITERAL', true),
        139 => new \Phplrt\Parser\Grammar\Repetition(137, 0, INF),
        140 => new \Phplrt\Parser\Grammar\Alternation(['OptionDecl', 'EnumField', 'Reserved']),
        141 => new \Phplrt\Parser\Grammar\Repetition('Comment', 0, INF),
        142 => new \Phplrt\Parser\Grammar\Lexeme('T_ENUM', false),
        143 => new \Phplrt\Parser\Grammar\Lexeme('T_IDENTIFIER', true),
        144 => new \Phplrt\Parser\Grammar\Lexeme('T_LBRACE', false),
        145 => new \Phplrt\Parser\Grammar\Repetition(140, 0, INF),
        146 => new \Phplrt\Parser\Grammar\Lexeme('T_RBRACE', false),
        147 => new \Phplrt\Parser\Grammar\Repetition('Comment', 0, INF),
        148 => new \Phplrt\Parser\Grammar\Lexeme('T_IDENTIFIER', true),
        149 => new \Phplrt\Parser\Grammar\Lexeme('T_EQUALS', false),
        150 => new \Phplrt\Parser\Grammar\Lexeme('T_INT_LITERAL', true),
        151 => new \Phplrt\Parser\Grammar\Optional(57),
        152 => new \Phplrt\Parser\Grammar\Lexeme('T_SEMICOLON', false),
        153 => new \Phplrt\Parser\Grammar\Alternation(['OptionDecl', 'RpcDecl']),
        154 => new \Phplrt\Parser\Grammar\Repetition('Comment', 0, INF),
        155 => new \Phplrt\Parser\Grammar\Lexeme('T_SERVICE', false),
        156 => new \Phplrt\Parser\Grammar\Lexeme('T_IDENTIFIER', true),
        157 => new \Phplrt\Parser\Grammar\Lexeme('T_LBRACE', false),
        158 => new \Phplrt\Parser\Grammar\Repetition(153, 0, INF),
        159 => new \Phplrt\Parser\Grammar\Lexeme('T_RBRACE', false),
        160 => new \Phplrt\Parser\Grammar\Lexeme('T_LBRACE', false),
        161 => new \Phplrt\Parser\Grammar\Repetition('OptionDecl', 0, INF),
        162 => new \Phplrt\Parser\Grammar\Lexeme('T_RBRACE', false),
        163 => new \Phplrt\Parser\Grammar\Concatenation([160, 161, 162]),
        164 => new \Phplrt\Parser\Grammar\Lexeme('T_SEMICOLON', false),
        165 => new \Phplrt\Parser\Grammar\Repetition('Comment', 0, INF),
        166 => new \Phplrt\Parser\Grammar\Lexeme('T_RPC', false),
        167 => new \Phplrt\Parser\Grammar\Lexeme('T_IDENTIFIER', true),
        168 => new \Phplrt\Parser\Grammar\Lexeme('T_LPAREN', false),
        169 => new \Phplrt\Parser\Grammar\Lexeme('T_RPAREN', false),
        170 => new \Phplrt\Parser\Grammar\Lexeme('T_RETURNS', false),
        171 => new \Phplrt\Parser\Grammar\Lexeme('T_LPAREN', false),
        172 => new \Phplrt\Parser\Grammar\Lexeme('T_RPAREN', false),
        173 => new \Phplrt\Parser\Grammar\Alternation([163, 164]),
        174 => new \Phplrt\Parser\Grammar\Lexeme('T_STREAM', true),
        175 => new \Phplrt\Parser\Grammar\Lexeme('T_DOT', false),
        176 => new \Phplrt\Parser\Grammar\Lexeme('T_DOT', false),
        177 => new \Phplrt\Parser\Grammar\Concatenation([176, 69]),
        178 => new \Phplrt\Parser\Grammar\Optional(174),
        179 => new \Phplrt\Parser\Grammar\Optional(175),
        180 => new \Phplrt\Parser\Grammar\Repetition(177, 0, INF),
        181 => new \Phplrt\Parser\Grammar\Lexeme('T_DOUBLE', false),
        182 => new \Phplrt\Parser\Grammar\Lexeme('T_FLOAT', false),
        183 => new \Phplrt\Parser\Grammar\Lexeme('T_INT32', false),
        184 => new \Phplrt\Parser\Grammar\Lexeme('T_INT64', false),
        185 => new \Phplrt\Parser\Grammar\Lexeme('T_UINT32', false),
        186 => new \Phplrt\Parser\Grammar\Lexeme('T_UINT64', false),
        187 => new \Phplrt\Parser\Grammar\Lexeme('T_SINT32', false),
        188 => new \Phplrt\Parser\Grammar\Lexeme('T_SINT64', false),
        189 => new \Phplrt\Parser\Grammar\Lexeme('T_FIXED32', false),
        190 => new \Phplrt\Parser\Grammar\Lexeme('T_FIXED64', false),
        191 => new \Phplrt\Parser\Grammar\Lexeme('T_SFIXED32', false),
        192 => new \Phplrt\Parser\Grammar\Lexeme('T_SFIXED64', false),
        193 => new \Phplrt\Parser\Grammar\Lexeme('T_BOOL', false),
        194 => new \Phplrt\Parser\Grammar\Lexeme('T_STRING', false),
        195 => new \Phplrt\Parser\Grammar\Lexeme('T_BYTES', false),
        196 => new \Phplrt\Parser\Grammar\Lexeme('T_MAX', true),
        197 => new \Phplrt\Parser\Grammar\Lexeme('T_INT_LITERAL', true),
        198 => new \Phplrt\Parser\Grammar\Lexeme('T_TO', false),
        199 => new \Phplrt\Parser\Grammar\Alternation([196, 197]),
        200 => new \Phplrt\Parser\Grammar\Lexeme('T_DOT', true),
        201 => new \Phplrt\Parser\Grammar\Lexeme('T_IDENTIFIER', true),
        202 => new \Phplrt\Parser\Grammar\Concatenation([200, 201]),
        203 => new \Phplrt\Parser\Grammar\Lexeme('T_IDENTIFIER', true),
        204 => new \Phplrt\Parser\Grammar\Repetition(202, 0, INF),
        'BuiltInType' => new \Phplrt\Parser\Grammar\Alternation([181, 182, 183, 184, 185, 186, 187, 188, 189, 190, 191, 192, 193, 194, 195]),
        'Comment' => new \Phplrt\Parser\Grammar\Lexeme('T_COMMENT', true),
        'EnumDef' => new \Phplrt\Parser\Grammar\Concatenation([141, 142, 143, 144, 145, 146]),
        'EnumField' => new \Phplrt\Parser\Grammar\Concatenation([147, 148, 149, 150, 151, 152]),
        'FieldDecl' => new \Phplrt\Parser\Grammar\Concatenation([58, 59, 56, 60, 61, 62, 63, 64, 65]),
        'FieldOption' => new \Phplrt\Parser\Grammar\Concatenation([20, 83, 82]),
        'ImportDecl' => new \Phplrt\Parser\Grammar\Concatenation([9, 10, 11, 12, 13]),
        'MapFieldDecl' => new \Phplrt\Parser\Grammar\Concatenation([114, 115, 116, 56, 117, 56, 118, 119, 120, 121, 122, 123]),
        'MessageDef' => new \Phplrt\Parser\Grammar\Concatenation([49, 50, 51, 52, 53, 54]),
        'MessageType' => new \Phplrt\Parser\Grammar\Concatenation([178, 179, 69, 180]),
        'OneofDecl' => new \Phplrt\Parser\Grammar\Concatenation([103, 104, 105, 106, 107, 108]),
        'OneofField' => new \Phplrt\Parser\Grammar\Concatenation([56, 109, 110, 111, 112, 113]),
        'OptionDecl' => new \Phplrt\Parser\Grammar\Concatenation([22, 23, 20, 24, 21, 25]),
        'PackageDecl' => new \Phplrt\Parser\Grammar\Concatenation([17, 18, 16, 19]),
        'Proto' => new \Phplrt\Parser\Grammar\Concatenation(['SyntaxDecl', 2]),
        'Range' => new \Phplrt\Parser\Grammar\Concatenation([133, 134]),
        'Reserved' => new \Phplrt\Parser\Grammar\Concatenation([126, 127, 128]),
        'RpcDecl' => new \Phplrt\Parser\Grammar\Concatenation([165, 166, 167, 168, 'MessageType', 169, 170, 171, 'MessageType', 172, 173]),
        'ServiceDef' => new \Phplrt\Parser\Grammar\Concatenation([154, 155, 156, 157, 158, 159]),
        'SyntaxDecl' => new \Phplrt\Parser\Grammar\Concatenation([3, 4, 5, 6, 7]),
    ],
    'reducers' => [
        8 => static function (\Phplrt\Parser\Context $ctx, $children) {
            // The "$token" variable is an auto-generated
            $token = $ctx->lastProcessedToken;

            if ($token->getValue() === 'public') {
                return \Butschster\ProtoParser\Ast\ImportModifier::Public;
            } elseif ($token->getValue() === 'weak') {
                return \Butschster\ProtoParser\Ast\ImportModifier::Weak;
            }
            return null;
        },
        20 => static function (\Phplrt\Parser\Context $ctx, $children) {
            $parts = \array_filter(array_map(fn($child) => $child->getValue(), $children), fn($part) => $part !== '.');
            return implode('.', $parts);
        },
        33 => static function (\Phplrt\Parser\Context $ctx, $children) {
            $el = \is_array($children) ? $children[0] : $children;

            if ($el instanceof \Phplrt\Contracts\Lexer\TokenInterface) {
                $value = $el->getValue();
                $el = match (true) {
                    $el->getName() === 'T_INT_LITERAL' => (int)$value,
                    $el->getName() === 'T_FLOAT_LITERAL' => (float)$value,
                    $el->getName() === 'T_BOOL_LITERAL' => $value === 'true',
                    $value === 'null' => null,
                    $value === 'true' => true,
                    $value === 'false' => false,
                    default => trim($value, '"\'')
                };
            }

            return $el;
        },
        34 => static function (\Phplrt\Parser\Context $ctx, $children) {
            $result = [];
            foreach ($children as $child) {
                if ($child instanceof \Butschster\ProtoParser\Ast\OptionNode) {
                    $result[$child->name] = $child;
                }
            }
            return $result;
        },
        35 => static function (\Phplrt\Parser\Context $ctx, $children) {
            $comments = array_filter($children, fn($child) => $child instanceof \Butschster\ProtoParser\Ast\CommentNode);
            $children = array_values(array_filter($children, fn($child) => !$child instanceof \Butschster\ProtoParser\Ast\CommentNode));

            return new \Butschster\ProtoParser\Ast\OptionNode(
                name: $children[0],
                value: $children[1],
                comments: array_values($comments),
            );
        },
        55 => static function (\Phplrt\Parser\Context $ctx, $children) {
            // The "$token" variable is an auto-generated
            $token = $ctx->lastProcessedToken;

            return match ($token->getValue()) {
                'repeated' => \Butschster\ProtoParser\Ast\FieldModifier::Repeated,
                'optional' => \Butschster\ProtoParser\Ast\FieldModifier::Optional,
                'required' => \Butschster\ProtoParser\Ast\FieldModifier::Required,
                default => null
            };
        },
        56 => static function (\Phplrt\Parser\Context $ctx, $children) {
            if ($children instanceof \Butschster\ProtoParser\Ast\BuiltInType) {
                return new \Butschster\ProtoParser\Ast\FieldType($children->value);
            }

            $isDotFirst = $children[0] instanceof \Phplrt\Contracts\Lexer\TokenInterface && $children[0]->getValue() === '.';
            $parts = \array_filter(array_map(fn($child) => $child->getValue(), $children), fn($part) => $part !== '.');

            $type = implode('.', $parts);
            if ($isDotFirst) {
                $type = '.' . $type;
            }

            return new \Butschster\ProtoParser\Ast\FieldType($type);
        },
        57 => static function (\Phplrt\Parser\Context $ctx, $children) {
            $result = [];
            foreach ($children as $child) {
                if ($child instanceof \Butschster\ProtoParser\Ast\OptionNode) {
                    $result[$child->name] = $child;
                }
            }
            return ['FieldOptions' => $result];
        },
        84 => static function (\Phplrt\Parser\Context $ctx, $children) {
            $result = [];
            foreach ($children as $child) {
                if ($child instanceof \Butschster\ProtoParser\Ast\OptionNode) {
                    $result[$child->name] = $child;
                }
            }
            return $result;
        },
        87 => static function (\Phplrt\Parser\Context $ctx, $children) {
            return new \Butschster\ProtoParser\Ast\OptionNode(
                name: $children[0],
                value: $children[1]
            );
        },
        124 => static function (\Phplrt\Parser\Context $ctx, $children) {
            return $children;
        },
        125 => static function (\Phplrt\Parser\Context $ctx, $children) {
            return array_map(function($child) {
                return trim($child->getValue(), '"\'');
            }, $children);
        },
        132 => static function (\Phplrt\Parser\Context $ctx, $children) {
            return $children[0] instanceof \Butschster\ProtoParser\Ast\ReservedNumber
                ? null
                : $children[0];
        },
        'BuiltInType' => static function (\Phplrt\Parser\Context $ctx, $children) {
            // The "$token" variable is an auto-generated
            $token = $ctx->lastProcessedToken;

            return \Butschster\ProtoParser\Ast\BuiltInType::tryFrom($token->getValue());
        },
        'Comment' => static function (\Phplrt\Parser\Context $ctx, $children) {
            $comment = $children->getValue();
            // remove /** */ and //
            $comment = trim(preg_replace('/^\/\*+|\*+\/$|^\s*\/\/+/', '', $comment));
            return new \Butschster\ProtoParser\Ast\CommentNode($comment);
        },
        'EnumDef' => static function (\Phplrt\Parser\Context $ctx, $children) {
            $comments = array_filter($children, fn($child) => $child instanceof \Butschster\ProtoParser\Ast\CommentNode);
            $children = array_values(array_filter($children, fn($child) => !$child instanceof \Butschster\ProtoParser\Ast\CommentNode));

            $name = $children[0]->getValue();
            $fields = [];

            foreach (array_slice($children, 1) as $child) {
                if ($child instanceof \Butschster\ProtoParser\Ast\OptionDeclNode ||
                    $child instanceof \Butschster\ProtoParser\Ast\EnumFieldNode ||
                    $child instanceof \Butschster\ProtoParser\Ast\ReservedNode) {
                    $fields[] = $child;
                }
            }

            return new \Butschster\ProtoParser\Ast\EnumDefNode(
                name: $name,
                fields: $fields,
                comments: array_values($comments),
            );
        },
        'EnumField' => static function (\Phplrt\Parser\Context $ctx, $children) {
            $comments = array_filter($children, fn($child) => $child instanceof \Butschster\ProtoParser\Ast\CommentNode);
            $children = array_values(array_filter($children, fn($child) => !$child instanceof \Butschster\ProtoParser\Ast\CommentNode));

            $name = $children[0]->getValue();
            $number = (int)$children[1]->getValue();
            $options = isset($children[2]) ? $children[2] : [];

            return new \Butschster\ProtoParser\Ast\EnumFieldNode(
                name: $name,
                number: $number,
                options: $options,
                comments: array_values($comments),
            );
        },
        'FieldDecl' => static function (\Phplrt\Parser\Context $ctx, $children) {
            $comments = array_filter($children, fn($child) => $child instanceof \Butschster\ProtoParser\Ast\CommentNode);
            $children = array_values(array_filter($children, fn($child) => !$child instanceof \Butschster\ProtoParser\Ast\CommentNode));

            if ($children[0] instanceof \Butschster\ProtoParser\Ast\FieldModifier) {
                $modifier = $children[0];
                $children = array_slice($children, 1);
            }

            $type = $children[0];
            $name = $children[1]->getValue();
            $number = (int)$children[2]->getValue();
            $options = isset($children[3]) ? $children[3] : [];

            return new \Butschster\ProtoParser\Ast\FieldDeclNode(
                modifier: $modifier,
                type: $type,
                name: $name,
                number: $number,
                options: $options,
                comments: array_values($comments),
            );
        },
        'FieldOption' => static function (\Phplrt\Parser\Context $ctx, $children) {
            return new \Butschster\ProtoParser\Ast\OptionNode(
                name: $children[0],
                value: $children[1]
            );
        },
        'ImportDecl' => static function (\Phplrt\Parser\Context $ctx, $children) {
            // TODO: refactor
            $comments = array_filter($children, fn($child) => $child instanceof \Butschster\ProtoParser\Ast\CommentNode);
            $children = array_values(array_filter($children, fn($child) => !$child instanceof \Butschster\ProtoParser\Ast\CommentNode));

            $modifier = $children[0] instanceof \Butschster\ProtoParser\Ast\ImportModifier
                ? $children[0]
                : null;
            $pathToken = $modifier ? $children[1] : $children[0];
            $path = trim($pathToken->getValue(), '"\'');
            $path = preg_replace('/\\\\{2,}/', '\\', $path);

            return new \Butschster\ProtoParser\Ast\ImportDeclNode(
                path: $path,
                modifier: $modifier,
                comments: array_values($comments),
            );
        },
        'MapFieldDecl' => static function (\Phplrt\Parser\Context $ctx, $children) {
            $comments = array_filter($children, fn($child) => $child instanceof \Butschster\ProtoParser\Ast\CommentNode);
            $children = array_values(array_filter($children, fn($child) => !$child instanceof \Butschster\ProtoParser\Ast\CommentNode));

            $keyType = $children[0];
            $type = $children[1];
            $name = $children[2]->getValue();
            $number = (int)$children[3]->getValue();

            return new \Butschster\ProtoParser\Ast\MapFieldDeclNode(
                keyType: $keyType,
                valueType: $type,
                name: $name,
                number: $number,
                options: isset($children[4]) ? $children[4] : [],
                comments: array_values($comments),
            );
        },
        'MessageDef' => static function (\Phplrt\Parser\Context $ctx, $children) {
            $comments = array_filter($children, fn($child) => $child instanceof \Butschster\ProtoParser\Ast\CommentNode);
            $children = array_values(array_filter($children, fn($child) => !$child instanceof \Butschster\ProtoParser\Ast\CommentNode));

            $name = $children[0]->getValue();
            $fields = [];
            $enums = [];
            $messages = [];

            foreach(array_slice($children, 1) as $child) {
                if (
                $child instanceof \Butschster\ProtoParser\Ast\FieldDeclNode
                || $child instanceof \Butschster\ProtoParser\Ast\MapFieldDeclNode
                || $child instanceof \Butschster\ProtoParser\Ast\OneofDeclNode
                ) {
                    $fields[] = $child;
                } elseif ($child instanceof \Butschster\ProtoParser\Ast\EnumDefNode) {
                    $enums[] = $child;
                } elseif ($child instanceof \Butschster\ProtoParser\Ast\MessageDefNode) {
                    $messages[] = $child;
                }
            }

            return new \Butschster\ProtoParser\Ast\MessageDefNode(
                name: $name,
                fields: $fields,
                messages: $messages,
                enums: $enums,
                comments: array_values($comments),
            );
        },
        'MessageType' => static function (\Phplrt\Parser\Context $ctx, $children) {
            $isStream = false;
            if ($children[0]->getName() === 'T_STREAM') {
                $isStream = true;
                $children = array_slice($children, 1);
            }

            $parts = \array_filter(array_map(fn($child) => $child->getValue(), $children), fn($part) => $part !== '.');
            return new \Butschster\ProtoParser\Ast\RpcMessageType(implode('.', $parts), $isStream);
        },
        'OneofDecl' => static function (\Phplrt\Parser\Context $ctx, $children) {
            $comments = array_filter($children, fn($child) => $child instanceof \Butschster\ProtoParser\Ast\CommentNode);
            $children = array_values(array_filter($children, fn($child) => !$child instanceof \Butschster\ProtoParser\Ast\CommentNode));

            return new \Butschster\ProtoParser\Ast\OneofDeclNode(
                name: $children[0]->getValue(),
                fields: array_values(array_filter($children, fn($child) => $child instanceof \Butschster\ProtoParser\Ast\OneofFieldNode)),
                options: array_values(array_filter($children, fn($child) => $child instanceof \Butschster\ProtoParser\Ast\OptionDeclNode)),
                comments: array_values($comments),
            );
        },
        'OneofField' => static function (\Phplrt\Parser\Context $ctx, $children) {
            return new \Butschster\ProtoParser\Ast\OneofFieldNode(
                type: $children[0],
                name: $children[1]->getValue(),
                number: (int)$children[2]->getValue(),
                options: isset($children['FieldOptions']) ? $children['FieldOptions'] : []
            );
        },
        'OptionDecl' => static function (\Phplrt\Parser\Context $ctx, $children) {
            $comments = array_filter($children, fn($child) => $child instanceof \Butschster\ProtoParser\Ast\CommentNode);
            $children = array_values(array_filter($children, fn($child) => !$child instanceof \Butschster\ProtoParser\Ast\CommentNode));

            $name = $children[0];
            $values = \array_map(
                fn(mixed $child) => $child instanceof \Butschster\ProtoParser\Ast\OptionNode ? $child : new \Butschster\ProtoParser\Ast\OptionNode($name, $child),
                \array_slice($children, 1)
            );

            return new \Butschster\ProtoParser\Ast\OptionDeclNode(
                name: $name,
                comments: array_values($comments),
                options: \array_values($values),
            );
        },
        'PackageDecl' => static function (\Phplrt\Parser\Context $ctx, $children) {
            // TODO: refactor
            $comments = array_filter($children, fn($child) => $child instanceof \Butschster\ProtoParser\Ast\CommentNode);
            $children = array_values(array_filter($children, fn($child) => !$child instanceof \Butschster\ProtoParser\Ast\CommentNode));

            $parts = \array_filter(array_map(fn($child) => $child->getValue(), $children), fn($part) => $part !== '.');
            $fullIdent = implode('.', $parts);
            return new \Butschster\ProtoParser\Ast\PackageDeclNode($fullIdent, $comments);
        },
        'Proto' => static function (\Phplrt\Parser\Context $ctx, $children) {
            $syntaxDecl = $children[0];
            $imports = [];
            $package = null;
            $options = [];
            $topLevelDefs = [];

            foreach (array_slice($children, 1) as $child) {
                if ($child instanceof \Butschster\ProtoParser\Ast\ImportDeclNode) {
                    $imports[] = $child;
                } elseif ($child instanceof \Butschster\ProtoParser\Ast\PackageDeclNode) {
                    $package = $child;
                } elseif ($child instanceof \Butschster\ProtoParser\Ast\OptionDeclNode) {
                    $options[] = $child;
                } else {
                    $topLevelDefs[] = $child;
                }
            }

            return new \Butschster\ProtoParser\Ast\ProtoNode(
                syntax: $syntaxDecl,
                imports: $imports,
                package: $package,
                options: $options,
                topLevelDefs: $topLevelDefs
            );
        },
        'Range' => static function (\Phplrt\Parser\Context $ctx, $children) {
            if (count($children) === 1) {
                return new \Butschster\ProtoParser\Ast\ReservedNumber((int)$children[0]->getValue());
            } else {
                $start = (int)$children[0]->getValue();
                $end = $children[1]->getValue() === 'max' ? 'max' : (int)$children[1]->getValue();
                return new \Butschster\ProtoParser\Ast\ReservedRange($start, $end);
            }
        },
        'Reserved' => static function (\Phplrt\Parser\Context $ctx, $children) {
            return new \Butschster\ProtoParser\Ast\ReservedNode(
                ranges: $children
            );
        },
        'RpcDecl' => static function (\Phplrt\Parser\Context $ctx, $children) {
            $comments = array_filter($children, fn($child) => $child instanceof \Butschster\ProtoParser\Ast\CommentNode);
            $children = array_values(array_filter($children, fn($child) => !$child instanceof \Butschster\ProtoParser\Ast\CommentNode));

            $name = $children[0]->getValue();
            $inputType = $children[1];
            $outputType = $children[2];
            $options = array_filter($children, fn($child) => $child instanceof \Butschster\ProtoParser\Ast\OptionDeclNode);

            return new \Butschster\ProtoParser\Ast\RpcDeclNode(
                name: $name,
                inputType: $inputType,
                outputType: $outputType,
                options: \array_values($options),
                comments: array_values($comments),
            );
        },
        'ServiceDef' => static function (\Phplrt\Parser\Context $ctx, $children) {
            $comments = array_filter($children, fn($child) => $child instanceof \Butschster\ProtoParser\Ast\CommentNode);
            $children = array_values(array_filter($children, fn($child) => !$child instanceof \Butschster\ProtoParser\Ast\CommentNode));

            $name = $children[0]->getValue();
            $methods = [];
            $options = [];

            foreach (array_slice($children, 1) as $child) {
                if ($child instanceof \Butschster\ProtoParser\Ast\RpcDeclNode) {
                    $methods[] = $child;
                } elseif ($child instanceof \Butschster\ProtoParser\Ast\OptionDeclNode) {
                    $options[] = $child;
                }
            }

            return new \Butschster\ProtoParser\Ast\ServiceDefNode(
                name: $name,
                methods: $methods,
                options: $options,
                comments: array_values($comments),
            );
        },
        'SyntaxDecl' => static function (\Phplrt\Parser\Context $ctx, $children) {
            // TODO: refactor
            $comments = array_filter($children, fn($child) => $child instanceof \Butschster\ProtoParser\Ast\CommentNode);
            $children = array_values(array_filter($children, fn($child) => !$child instanceof \Butschster\ProtoParser\Ast\CommentNode));

            $syntax = trim($children[0]->getValue(), '"\'');
            return new \Butschster\ProtoParser\Ast\SyntaxDeclNode($syntax, $comments);
        },
    ],
];