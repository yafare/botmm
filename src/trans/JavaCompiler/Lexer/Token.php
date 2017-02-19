<?php
/**
 * Created by IntelliJ IDEA.
 * User: hugo
 * Date: 2017/2/18
 * Time: 21:59
 */

namespace trans\JavaCompiler\Lexer;


class Token
{

    public $index;
    public $type;
    public $numValue;
    public $strValue;

    public function __construct($index, $type, $numValue, $strValue)
    {
        $this->index    = $index;
        $this->type     = $type;
        $this->numValue = $numValue;
        $this->strValue = $strValue;
    }

    public function isCharacter(int $code): bool
    {
        return $this->type == TokenType::Character && $this->numValue == $code;
    }

    public function isNumber(): bool
    {
        return $this->type == TokenType::Number;
    }

    public function isString(): bool
    {
        return $this->type == TokenType::String;
    }

    public function isOperator(string $operater): bool
    {
        return $this->type == TokenType::Operator && $this->strValue == $operater;
    }

    public function isIdentifier(): bool
    {
        return $this->type == TokenType::Identifier;
    }

    public function isKeyword(): bool
    {
        return $this->type == TokenType::Keyword;
    }

    public function isKeywordLet(): bool
    {
        return $this->type == TokenType::Keyword && $this->strValue == 'let';
    }

    public function isKeywordNull(): bool
    {
        return $this->type == TokenType::Keyword && $this->strValue == 'null';
    }

    public function isKeywordUndefined(): bool
    {
        return $this->type == TokenType::Keyword && $this->strValue == 'undefined';
    }

    public function isKeywordTrue(): bool
    {
        return $this->type == TokenType::Keyword && $this->strValue == 'true';
    }

    public function isKeywordFalse(): bool
    {
        return $this->type == TokenType::Keyword && $this->strValue == 'false';
    }

    public function isKeywordThis(): bool
    {
        return $this->type == TokenType::Keyword && $this->strValue == 'this';
    }

    public function isError(): bool
    {
        return $this->type == TokenType::Error;
    }

    public function toNumber(): number
    {
        return $this->type == TokenType::Number ? $this->numValue : -1;
    }

    public function toString(): string
    {
        switch ($this->type) {
            case TokenType::Character:
            case TokenType::Identifier:
            case TokenType::Keyword:
            case TokenType::Operator:
            case TokenType::String:
            case TokenType::Error:
                return $this->strValue;
            case TokenType::Number:
                return $this->numValue . '';
            default:
                return null;
        }
    }
}