<?php


namespace trans\JavaParser\Lexer;


use trans\JavaParser\Chars;
use trans\JavaParser\Wrapper\StringWrapper;

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
        return (Chars::a <= $code && $code <= Chars::z) || (Chars::A <= $code && $code <= Chars::Z)
               || ($code == Chars::_)
               || ($code == Chars::DOLAR);
    }

    public static function isIdentifier($input): bool
    {
        if (strlen($input) == 0) {
            return false;
        }
        $scanner = new Scanner($input);
        if (!Util::isIdentifierStart($scanner->peek)) {
            return false;
        }
        $scanner->advance();
        while ($scanner->peek !== Chars::EOF) {
            if (!Util::isIdentifierPart($scanner->peek)) {
                return false;
            }
            $scanner->advance();
        }
        return true;
    }

    public static function isIdentifierPart($code): bool
    {
        return Chars::isAsciiLetter($code) || Chars::isDigit($code) || ($code == Chars::_)
               || ($code == Chars::DOLAR);
    }

    public static function isExponentStart($code): bool
    {
        return $code == Chars::e || $code == Chars::E;
    }

    public static function isExponentSign($code): bool
    {
        return $code == Chars::MINUS || $code == Chars::PLUS;
    }

    public static function isQuote($code): bool
    {
        return $code === Chars::SQ || $code === Chars::DQ || $code === Chars::BT;
    }

    public static function unescape($code): number
    {
        switch ($code) {
            case Chars::n:
                return Chars::LF;
            case Chars::f:
                return Chars::FF;
            case Chars::r:
                return Chars::CR;
            case Chars::t:
                return Chars::TAB;
            case Chars::v:
                return Chars::VTAB;
            default:
                return $code;
        }

    }
}