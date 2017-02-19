<?php


namespace src\trans\JavaCompiler\Lexer;


use src\trans\JavaCompiler\StringWrapper;

class Util
{
    public static function newCharacterToken($index, $code): Token
    {
        return new Token($index, TokenType::Character, $code, StringWrapper::fromCharCode($code));
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

    public static function isIdentifierStart($code): bool
    {
        return (chars::a <= $code && $code <= chars::z) || (chars::A <= $code && $code <= chars::Z)
               || ($code == chars::_)
               || ($code == chars::DOLAR);
    }

    public static function isIdentifier($input): bool
    {
        if (strlen($input) == 0) {
            return false;
        }
        $scanner = new _Scanner($input);
        if (!Util::isIdentifierStart($scanner->peek)) {
            return false;
        }
        $scanner->advance();
        while ($scanner->peek !== chars::EOF) {
            if (!Util::isIdentifierPart($scanner->peek)) {
                return false;
            }
            $scanner->advance();
        }
        return true;
    }

    public static function isIdentifierPart($code): bool
    {
        return chars::isAsciiLetter($code) || chars::isDigit($code) || ($code == chars::_)
               || ($code == chars::DOLAR);
    }

    public static function isExponentStart($code): bool
    {
        return $code == chars::e || $code == chars::E;
    }

    public static function isExponentSign($code): bool
    {
        return $code == chars::MINUS || $code == chars::PLUS;
    }

    public static function isQuote($code): bool
    {
        return $code === chars::SQ || $code === chars::DQ || $code === chars::BT;
    }

    public static function unescape($code): number
    {
        switch ($code) {
            case chars::n:
                return chars::LF;
            case chars::f:
                return chars::FF;
            case chars::r:
                return chars::CR;
            case chars::t:
                return chars::TAB;
            case chars::v:
                return chars::VTAB;
            default:
                return $code;
        }

    }
}