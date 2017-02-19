<?php


namespace trans\JavaCompiler\Lexer;


class Lexer
{
    public static $KEYWORDS;
    public static $EOF;

    public function __construct()
    {
        self::$KEYWORDS = ['var', 'let', 'null', 'undefined', 'true', 'false', 'if', 'else', 'this'];
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