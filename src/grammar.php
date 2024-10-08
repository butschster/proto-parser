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
            'T_SYNTAX' => '(?<=^|\\s)syntax\\b',
            'T_PACKAGE' => '(?<=^|\\s)package\\b',
            'T_IMPORT' => '(?<=^|\\s)import\\b',
            'T_MESSAGE' => '(?<=^|\\s)message\\b',
            'T_ENUM' => '(?<=^|\\s)enum\\b',
            'T_SERVICE' => '(?<=^|\\s)service\\b',
            'T_RPC' => '(?<=^|\\s)rpc\\b',
            'T_RETURNS' => '(?<=^|\\s)returns\\b',
            'T_STREAM' => '(?<=^|\\s|\\()stream\\b',
            'T_REPEATED' => '(?<=^|\\s)repeated\\b',
            'T_OPTIONAL' => '(?<=^|\\s)optional\\b',
            'T_OPTION' => '(?<=^|\\s)option\\b',
            'T_REQUIRED' => '(?<=^|\\s)required\\b',
            'T_RESERVED' => '(?<=^|\\s)reserved\\b',
            'T_WEAK' => '(?<=^|\\s)weak\\b',
            'T_PUBLIC' => '(?<=^|\\s)public\\b',
            'T_MAP' => '(?<=^|\\s)map\\b',
            'T_ONEOF' => '(?<=^|\\s)oneof\\b',
            'T_DOUBLE' => '(?<=^|\\s)double\\b',
            'T_FLOAT' => '(?<=^|\\s)float\\b',
            'T_INT32' => '(?<=^|\\s)int32\\b',
            'T_INT64' => '(?<=^|\\s)int64\\b',
            'T_UINT32' => '(?<=^|\\s)uint32\\b',
            'T_UINT64' => '(?<=^|\\s)uint64\\b',
            'T_SINT32' => '(?<=^|\\s)sint32\\b',
            'T_SINT64' => '(?<=^|\\s)sint64\\b',
            'T_FIXED32' => '(?<=^|\\s)fixed32\\b',
            'T_FIXED64' => '(?<=^|\\s)fixed64\\b',
            'T_SFIXED32' => '(?<=^|\\s)sfixed32\\b',
            'T_SFIXED64' => '(?<=^|\\s)sfixed64\\b',
            'T_BOOL' => '(?<=^|\\s)bool\\b',
            'T_BYTES' => '(?<=^|\\s)bytes\\b',
            'T_ANY' => '(?<=^|\\s)any\\b',
            'T_FLOAT_LITERAL' => '-?[0-9]*\\.[0-9]+([eE][+-]?[0-9]+)?',
            'T_INT_LITERAL' => '-?[0-9]+',
            'T_STRING_LITERAL' => '"([^"\\\\]*(?:\\\\.[^"\\\\]*)*)"',
            'T_BOOL_LITERAL' => '\\b(?i)(?:true|false)\\b',
            'T_NULL_LITERAL' => '\\b(?i)(?:null)\\b',
            'T_INLINE_COMMENT' => '//.*?$',
            'T_BLOCK_COMMENT' => '/\\*(.|\\n)*?\\*/',
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
            'T_TO' => '(?<=^|\\s)to\\b',
            'T_STRING' => '(?<=^|\\s)string\\b',
            'T_MAX' => '(?<=^|\\s)max\\b',
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
        16 => new \Phplrt\Parser\Grammar\Concatenation([205, 206]),
        17 => new \Phplrt\Parser\Grammar\Repetition('Comment', 0, INF),
        18 => new \Phplrt\Parser\Grammar\Lexeme('T_PACKAGE', false),
        19 => new \Phplrt\Parser\Grammar\Lexeme('T_SEMICOLON', false),
        20 => new \Phplrt\Parser\Grammar\Concatenation([31, 32]),
        21 => new \Phplrt\Parser\Grammar\Alternation([33, 34, 35]),
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
        34 => new \Phplrt\Parser\Grammar\Concatenation([42, 43, 44]),
        35 => new \Phplrt\Parser\Grammar\Lexeme('T_FLOAT_LITERAL', true),
        36 => new \Phplrt\Parser\Grammar\Concatenation([45, 20, 46, 47, 48]),
        37 => new \Phplrt\Parser\Grammar\Lexeme('T_COMMA', false),
        38 => new \Phplrt\Parser\Grammar\Concatenation([37, 36]),
        39 => new \Phplrt\Parser\Grammar\Repetition(36, 0, INF),
        40 => new \Phplrt\Parser\Grammar\Repetition(38, 0, INF),
        41 => new \Phplrt\Parser\Grammar\Concatenation([39, 40]),
        42 => new \Phplrt\Parser\Grammar\Lexeme('T_LBRACE', false),
        43 => new \Phplrt\Parser\Grammar\Optional(41),
        44 => new \Phplrt\Parser\Grammar\Lexeme('T_RBRACE', false),
        45 => new \Phplrt\Parser\Grammar\Repetition('Comment', 0, INF),
        46 => new \Phplrt\Parser\Grammar\Lexeme('T_COLON', false),
        47 => new \Phplrt\Parser\Grammar\Alternation([33, 34]),
        48 => new \Phplrt\Parser\Grammar\Repetition('Comment', 0, INF),
        49 => new \Phplrt\Parser\Grammar\Alternation([207, 208, 209, 210, 211, 212, 213, 214, 215, 216, 217, 218, 219, 220, 221, 222, 223, 224, 225]),
        50 => new \Phplrt\Parser\Grammar\Alternation(['FieldDecl', 'EnumDef', 'MessageDef', 'OptionDecl', 'OneofDecl', 'MapFieldDecl', 'Reserved', 'Comment']),
        51 => new \Phplrt\Parser\Grammar\Repetition('Comment', 0, INF),
        52 => new \Phplrt\Parser\Grammar\Lexeme('T_MESSAGE', false),
        53 => new \Phplrt\Parser\Grammar\Lexeme('T_LBRACE', false),
        54 => new \Phplrt\Parser\Grammar\Repetition(50, 0, INF),
        55 => new \Phplrt\Parser\Grammar\Lexeme('T_RBRACE', false),
        56 => new \Phplrt\Parser\Grammar\Alternation([65, 66, 67]),
        57 => new \Phplrt\Parser\Grammar\Alternation(['BuiltInType', 68, 69]),
        58 => new \Phplrt\Parser\Grammar\Concatenation([79, 'FieldOption', 80, 81]),
        59 => new \Phplrt\Parser\Grammar\Repetition('Comment', 0, INF),
        60 => new \Phplrt\Parser\Grammar\Optional(56),
        61 => new \Phplrt\Parser\Grammar\Lexeme('T_EQUALS', false),
        62 => new \Phplrt\Parser\Grammar\Lexeme('T_INT_LITERAL', true),
        63 => new \Phplrt\Parser\Grammar\Optional(58),
        64 => new \Phplrt\Parser\Grammar\Lexeme('T_SEMICOLON', false),
        65 => new \Phplrt\Parser\Grammar\Lexeme('T_REPEATED', false),
        66 => new \Phplrt\Parser\Grammar\Lexeme('T_OPTIONAL', false),
        67 => new \Phplrt\Parser\Grammar\Lexeme('T_REQUIRED', false),
        68 => new \Phplrt\Parser\Grammar\Lexeme('T_ANY', true),
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
        98 => new \Phplrt\Parser\Grammar\Lexeme('T_FLOAT_LITERAL', true),
        99 => new \Phplrt\Parser\Grammar\Lexeme('T_INT_LITERAL', true),
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
        112 => new \Phplrt\Parser\Grammar\Optional(58),
        113 => new \Phplrt\Parser\Grammar\Lexeme('T_SEMICOLON', false),
        114 => new \Phplrt\Parser\Grammar\Repetition('Comment', 0, INF),
        115 => new \Phplrt\Parser\Grammar\Lexeme('T_MAP', false),
        116 => new \Phplrt\Parser\Grammar\Lexeme('T_LT', false),
        117 => new \Phplrt\Parser\Grammar\Lexeme('T_COMMA', false),
        118 => new \Phplrt\Parser\Grammar\Lexeme('T_GT', false),
        119 => new \Phplrt\Parser\Grammar\Lexeme('T_IDENTIFIER', true),
        120 => new \Phplrt\Parser\Grammar\Lexeme('T_EQUALS', false),
        121 => new \Phplrt\Parser\Grammar\Lexeme('T_INT_LITERAL', true),
        122 => new \Phplrt\Parser\Grammar\Optional(58),
        123 => new \Phplrt\Parser\Grammar\Lexeme('T_SEMICOLON', false),
        124 => new \Phplrt\Parser\Grammar\Concatenation(['Range', 132]),
        125 => new \Phplrt\Parser\Grammar\Concatenation([139, 140]),
        126 => new \Phplrt\Parser\Grammar\Repetition('Comment', 0, INF),
        127 => new \Phplrt\Parser\Grammar\Lexeme('T_RESERVED', false),
        128 => new \Phplrt\Parser\Grammar\Alternation([124, 125]),
        129 => new \Phplrt\Parser\Grammar\Lexeme('T_SEMICOLON', false),
        130 => new \Phplrt\Parser\Grammar\Lexeme('T_COMMA', false),
        131 => new \Phplrt\Parser\Grammar\Concatenation([130, 'Range']),
        132 => new \Phplrt\Parser\Grammar\Repetition(131, 0, INF),
        133 => new \Phplrt\Parser\Grammar\Concatenation([200, 201]),
        134 => new \Phplrt\Parser\Grammar\Lexeme('T_INT_LITERAL', true),
        135 => new \Phplrt\Parser\Grammar\Optional(133),
        136 => new \Phplrt\Parser\Grammar\Lexeme('T_COMMA', false),
        137 => new \Phplrt\Parser\Grammar\Lexeme('T_STRING_LITERAL', true),
        138 => new \Phplrt\Parser\Grammar\Concatenation([136, 137]),
        139 => new \Phplrt\Parser\Grammar\Lexeme('T_STRING_LITERAL', true),
        140 => new \Phplrt\Parser\Grammar\Repetition(138, 0, INF),
        141 => new \Phplrt\Parser\Grammar\Alternation(['OptionDecl', 'EnumField', 'Reserved', 'InlineComment']),
        142 => new \Phplrt\Parser\Grammar\Repetition('Comment', 0, INF),
        143 => new \Phplrt\Parser\Grammar\Lexeme('T_ENUM', false),
        144 => new \Phplrt\Parser\Grammar\Lexeme('T_LBRACE', false),
        145 => new \Phplrt\Parser\Grammar\Repetition(141, 0, INF),
        146 => new \Phplrt\Parser\Grammar\Lexeme('T_RBRACE', false),
        147 => new \Phplrt\Parser\Grammar\Lexeme('T_IDENTIFIER', true),
        148 => new \Phplrt\Parser\Grammar\Lexeme('T_EQUALS', false),
        149 => new \Phplrt\Parser\Grammar\Lexeme('T_INT_LITERAL', true),
        150 => new \Phplrt\Parser\Grammar\Optional(58),
        151 => new \Phplrt\Parser\Grammar\Lexeme('T_SEMICOLON', false),
        152 => new \Phplrt\Parser\Grammar\Optional('InlineComment'),
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
        196 => new \Phplrt\Parser\Grammar\Lexeme('T_INLINE_COMMENT', true),
        197 => new \Phplrt\Parser\Grammar\Lexeme('T_BLOCK_COMMENT', true),
        198 => new \Phplrt\Parser\Grammar\Lexeme('T_MAX', true),
        199 => new \Phplrt\Parser\Grammar\Lexeme('T_INT_LITERAL', true),
        200 => new \Phplrt\Parser\Grammar\Lexeme('T_TO', false),
        201 => new \Phplrt\Parser\Grammar\Alternation([198, 199]),
        202 => new \Phplrt\Parser\Grammar\Lexeme('T_DOT', true),
        203 => new \Phplrt\Parser\Grammar\Lexeme('T_IDENTIFIER', true),
        204 => new \Phplrt\Parser\Grammar\Concatenation([202, 203]),
        205 => new \Phplrt\Parser\Grammar\Lexeme('T_IDENTIFIER', true),
        206 => new \Phplrt\Parser\Grammar\Repetition(204, 0, INF),
        207 => new \Phplrt\Parser\Grammar\Lexeme('T_IDENTIFIER', true),
        208 => new \Phplrt\Parser\Grammar\Lexeme('T_MESSAGE', false),
        209 => new \Phplrt\Parser\Grammar\Lexeme('T_ENUM', false),
        210 => new \Phplrt\Parser\Grammar\Lexeme('T_ONEOF', false),
        211 => new \Phplrt\Parser\Grammar\Lexeme('T_MAP', false),
        212 => new \Phplrt\Parser\Grammar\Lexeme('T_RESERVED', false),
        213 => new \Phplrt\Parser\Grammar\Lexeme('T_SYNTAX', false),
        214 => new \Phplrt\Parser\Grammar\Lexeme('T_PACKAGE', false),
        215 => new \Phplrt\Parser\Grammar\Lexeme('T_IMPORT', false),
        216 => new \Phplrt\Parser\Grammar\Lexeme('T_SERVICE', false),
        217 => new \Phplrt\Parser\Grammar\Lexeme('T_RPC', false),
        218 => new \Phplrt\Parser\Grammar\Lexeme('T_RETURNS', false),
        219 => new \Phplrt\Parser\Grammar\Lexeme('T_STREAM', false),
        220 => new \Phplrt\Parser\Grammar\Lexeme('T_REPEATED', false),
        221 => new \Phplrt\Parser\Grammar\Lexeme('T_OPTIONAL', false),
        222 => new \Phplrt\Parser\Grammar\Lexeme('T_OPTION', false),
        223 => new \Phplrt\Parser\Grammar\Lexeme('T_REQUIRED', false),
        224 => new \Phplrt\Parser\Grammar\Lexeme('T_WEAK', false),
        225 => new \Phplrt\Parser\Grammar\Lexeme('T_PUBLIC', false),
        'BuiltInType' => new \Phplrt\Parser\Grammar\Alternation([181, 182, 183, 184, 185, 186, 187, 188, 189, 190, 191, 192, 193, 194, 195]),
        'Comment' => new \Phplrt\Parser\Grammar\Alternation([196, 197]),
        'EnumDef' => new \Phplrt\Parser\Grammar\Concatenation([142, 143, 49, 144, 145, 146]),
        'EnumField' => new \Phplrt\Parser\Grammar\Concatenation([147, 148, 149, 150, 151, 152]),
        'FieldDecl' => new \Phplrt\Parser\Grammar\Concatenation([59, 60, 57, 49, 61, 62, 63, 64]),
        'FieldOption' => new \Phplrt\Parser\Grammar\Concatenation([20, 83, 82]),
        'ImportDecl' => new \Phplrt\Parser\Grammar\Concatenation([9, 10, 11, 12, 13]),
        'InlineComment' => new \Phplrt\Parser\Grammar\Lexeme('T_INLINE_COMMENT', true),
        'MapFieldDecl' => new \Phplrt\Parser\Grammar\Concatenation([114, 115, 116, 57, 117, 57, 118, 119, 120, 121, 122, 123]),
        'MessageDef' => new \Phplrt\Parser\Grammar\Concatenation([51, 52, 49, 53, 54, 55]),
        'MessageType' => new \Phplrt\Parser\Grammar\Concatenation([178, 179, 69, 180]),
        'OneofDecl' => new \Phplrt\Parser\Grammar\Concatenation([103, 104, 105, 106, 107, 108]),
        'OneofField' => new \Phplrt\Parser\Grammar\Concatenation([57, 109, 110, 111, 112, 113]),
        'OptionDecl' => new \Phplrt\Parser\Grammar\Concatenation([22, 23, 20, 24, 21, 25]),
        'PackageDecl' => new \Phplrt\Parser\Grammar\Concatenation([17, 18, 16, 19]),
        'Proto' => new \Phplrt\Parser\Grammar\Concatenation(['SyntaxDecl', 2]),
        'Range' => new \Phplrt\Parser\Grammar\Concatenation([134, 135]),
        'Reserved' => new \Phplrt\Parser\Grammar\Concatenation([126, 127, 128, 129]),
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
        36 => static function (\Phplrt\Parser\Context $ctx, $children) {
            $comments = array_filter($children, fn($child) => $child instanceof \Butschster\ProtoParser\Ast\CommentNode);
            $children = array_values(array_filter($children, fn($child) => !$child instanceof \Butschster\ProtoParser\Ast\CommentNode));

            return new \Butschster\ProtoParser\Ast\OptionNode(
                name: $children[0],
                value: $children[1],
                comments: array_values($comments),
            );
        },
        49 => static function (\Phplrt\Parser\Context $ctx, $children) {
            // The "$token" variable is an auto-generated
            $token = $ctx->lastProcessedToken;

            return $token->getValue();
        },
        56 => static function (\Phplrt\Parser\Context $ctx, $children) {
            // The "$token" variable is an auto-generated
            $token = $ctx->lastProcessedToken;

            return match ($token->getValue()) {
                'repeated' => \Butschster\ProtoParser\Ast\FieldModifier::Repeated,
                'optional' => \Butschster\ProtoParser\Ast\FieldModifier::Optional,
                'required' => \Butschster\ProtoParser\Ast\FieldModifier::Required,
                default => null
            };
        },
        57 => static function (\Phplrt\Parser\Context $ctx, $children) {
            // The "$token" variable is an auto-generated
            $token = $ctx->lastProcessedToken;

            if ($children instanceof \Butschster\ProtoParser\Ast\BuiltInType) {
                return new \Butschster\ProtoParser\Ast\FieldType($children->value);
            }

            if ($token->getName() === 'T_ANY') {
                return new \Butschster\ProtoParser\Ast\FieldType('any');
            }

            $isDotFirst = $children[0] instanceof \Phplrt\Contracts\Lexer\TokenInterface && $children[0]->getValue() === '.';
            $parts = \array_filter(array_map(fn($child) => $child->getValue(), $children), fn($part) => $part !== '.');

            $type = implode('.', $parts);
            if ($isDotFirst) {
                $type = '.' . $type;
            }

            return new \Butschster\ProtoParser\Ast\FieldType($type);
        },
        58 => static function (\Phplrt\Parser\Context $ctx, $children) {
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

            return new \Butschster\ProtoParser\Ast\OptionDeclNode(
                name: null,
                options: $result
            );
        },
        87 => static function (\Phplrt\Parser\Context $ctx, $children) {
            return new \Butschster\ProtoParser\Ast\OptionNode(
                name: $children[0] instanceof Phplrt\Lexer\Token\Token ? $children[0]->getValue() : $children[0],
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
        133 => static function (\Phplrt\Parser\Context $ctx, $children) {
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

            $name = $children[0];
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

            $modifier = null;
            if ($children[0] instanceof \Butschster\ProtoParser\Ast\FieldModifier) {
                $modifier = $children[0];
                $children = array_slice($children, 1);
            }

            $type = $children[0];
            $name = $children[1];
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
            $name = $children[0];

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
        'InlineComment' => static function (\Phplrt\Parser\Context $ctx, $children) {
            $comment = $children->getValue();
            // remove /
            $comment = trim(preg_replace('/^\/\*+|\*+\/$|^\s*\/\/+/', '', $comment));
            return new \Butschster\ProtoParser\Ast\CommentNode($comment);
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

            $name = $children[0];
            $fields = [];
            $enums = [];
            $messages = [];

            foreach(array_slice($children, 1) as $child) {
                if (
                $child instanceof \Butschster\ProtoParser\Ast\FieldDeclNode
                || $child instanceof \Butschster\ProtoParser\Ast\MapFieldDeclNode
                || $child instanceof \Butschster\ProtoParser\Ast\OneofDeclNode
                || $child instanceof \Butschster\ProtoParser\Ast\ReservedNode
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
            $comments = array_filter($children, fn($child) => $child instanceof \Butschster\ProtoParser\Ast\CommentNode);
            $children = array_values(array_filter($children, fn($child) => !$child instanceof \Butschster\ProtoParser\Ast\CommentNode));

            return new \Butschster\ProtoParser\Ast\ReservedNode(
                ranges: $children,
                comments: array_values($comments),
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