<?php


namespace src\trans\JavaCompiler;


class Chars
{

    public const EOF       = 0;
    public const TAB       = 9;
    public const LF        = 10;
    public const VTAB      = 11;
    public const FF        = 12;
    public const CR        = 13;
    public const SPACE     = 32;
    public const BANG      = 33;
    public const DQ        = 34;
    public const HASH      = 35;
    public const DOLAR     = 36;
    public const PERCENT   = 37;
    public const AMPERSAND = 38;
    public const SQ        = 39;
    public const LPAREN    = 40;
    public const RPAREN    = 41;
    public const STAR      = 42;
    public const PLUS      = 43;
    public const COMMA     = 44;
    public const MINUS     = 45;
    public const PERIOD    = 46;
    public const SLASH     = 47;
    public const COLON     = 58;
    public const SEMICOLON = 59;
    public const LT        = 60;
    public const EQ        = 61;
    public const GT        = 62;
    public const QUESTION  = 63;
    public const NUM_0     = 48;
    public const NUM_9     = 57;
    public const A         = 65;
    public const E         = 69;
    public const F         = 70;
    public const X         = 88;
    public const Z         = 90;
    public const LBRACKET  = 91;
    public const BACKSLASH = 92;
    public const RBRACKET  = 93;
    public const CARET     = 94;
    public const _         = 95;
    public const a         = 97;
    public const e         = 101;
    public const f         = 102;
    public const n         = 110;
    public const r         = 114;
    public const t         = 116;
    public const u         = 117;
    public const v         = 118;
    public const x         = 120;
    public const z         = 122;
    public const LBRACE    = 123;
    public const BAR       = 124;
    public const RBRACE    = 125;
    public const NBSP      = 160;
    public const PIPE      = 124;
    public const TILDA     = 126;
    public const AT        = 64;
    public const BT        = 96;

    public function isWhitespace($code): bool
    {
        return ($code >= self::TAB && $code <= self::SPACE) || ($code == self::NBSP);
    }

    public function isDigit($code): bool
    {
        return self::NUM_0 <= $code && $code <= self::NUM_9;
    }

    public function isAsciiLetter($code): bool
    {
        return $code >= self::a && $code <= self::z || $code >= self::A && $code <= self::Z;
    }

    public function isAsciiHexDigit($code): bool
    {
        return $code >= self::a && $code <= self::f || $code >= self::A && $code <= self::F || $this->isDigit($code);
    }
}