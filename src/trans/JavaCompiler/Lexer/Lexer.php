<?php


namespace trans\JavaCompiler\Lexer;


class Lexer
{
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