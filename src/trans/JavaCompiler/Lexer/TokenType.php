<?php


namespace src\trans\JavaCompiler\Lexer;


class TokenType
{
    public const Character  = 1;
    public const Identifier = 2;
    public const Keyword    = 3;
    public const String     = 4;
    public const Operator   = 5;
    public const Number     = 6;
    public const Error      = 7;

}