<?php


namespace src\trans\JavaCompiler;


class Util
{


    public static function newCharacterToken($index, $code): Token
    {
        return new Token($index, TokenType::Character, $code, chr($code));
    }

    public static function newIdentifierToken($index, $text): Token
    {
        return new Token($index, TokenType::Identifier, 0, $text);
    }

    public static function newKeywordToken($index, $text): Token
    {
        return new Token($index, TokenType::Keyword, 0, $text);
    }

    public static function newOperatorToken($index, $text): Token
    {
        return new Token($index, TokenType::Operator, 0, $text);
    }

    public static function newStringToken($index, $text): Token
    {
        return new Token($index, TokenType::String, 0, $text);
    }

    public static function newNumberToken($index, $n): Token
    {
        return new Token($index, TokenType::Number, $n, '');
    }

    public static function newErrorToken($index, $message): Token
    {
        return new Token($index, TokenType::Error, 0, $message);
    }
}