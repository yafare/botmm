<?php


namespace trans\JavaCompiler\Lexer;


class Lexer
{
    public static $KEYWORDS;
    public static $EOF;

    public function __construct()
    {
        self::$KEYWORDS = [
            'abstract',
            'continue',
            'for',
            'new',
            'switch',
            'assert',
            'default',
            'goto',
            'package',
            'synchronized',
            'boolean',
            'do',
            'if',
            'private',
            'this',
            'break',
            'double',
            'implements',
            'protected',
            'throw',
            'byte',
            'else',
            'import',
            'public',
            'throws',
            'case',
            'enum',
            'instanceof',
            'return',
            'transient',
            'catch',
            'extends',
            'int',
            'short',
            'try',
            'char',
            'final',
            'interface',
            'static',
            'void',
            'class',
            'finally',
            'long',
            'strictfp',
            'volatile',
            'const',
            'float',
            'native',
            'super',
            'while',
        ];
        self::$EOF      = new Token(-1, TokenType::Character, 0, '');
    }

    public function tokenize($text)
    {
        $scanner = new Scanner($text);
        $tokens  = [];
        $token   = $scanner->scanToken();
        while ($token != null) {
            $tokens[] = $token;
            $token    = $scanner->scanToken();
        }
        return $tokens;
    }
}