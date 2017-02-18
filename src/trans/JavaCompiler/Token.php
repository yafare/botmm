<?php
/**
 * Created by IntelliJ IDEA.
 * User: hugo
 * Date: 2017/2/18
 * Time: 21:59
 */

namespace src\trans\JavaCompiler;


class Token
{

public  $index;
public  $type;
public $numValue;
public $strValue;

function isCharacter(int $code): boolean {
    return $this->type == TokenType::Character && $this->numValue == $code;
}

function isNumber(): boolean { return $this->type == TokenType::Number; }

function isString(): boolean { return $this->type == TokenType::String; }

function  isOperator(string $operater): boolean {
    return $this->type == TokenType::Operator && $this->strValue == $operater;
}

function isIdentifier(): boolean { return $this->type == TokenType::Identifier; }

function  isKeyword(): boolean { return $this->type == TokenType::Keyword; }

function  isKeywordLet(): boolean { return $this->type == TokenType::Keyword && $this->strValue == 'let'; }

function  isKeywordNull(): boolean { return $this->type == TokenType::Keyword && $this->strValue == 'null'; }

function  isKeywordUndefined(): boolean {
    return $this->type == TokenType::Keyword && $this->strValue == 'undefined';
}

function isKeywordTrue(): boolean { return $this->type == TokenType::Keyword && $this->strValue == 'true'; }

function  isKeywordFalse(): boolean { return $this->type == TokenType::Keyword && $this->strValue == 'false'; }

function  isKeywordThis(): boolean { return $this->type == TokenType::Keyword && $this->strValue == 'this'; }

function  isError(): boolean { return $this->type == TokenType::Error; }

function toNumber(): number { return $this->type == TokenType::Number ? $this->numValue : -1; }

function  toString(): string {
    switch ($this->type) {
        case TokenType::Character:
        case TokenType::Identifier:
        case TokenType::Keyword:
        case TokenType::Operator:
        case TokenType::String:
        case TokenType::Error:
            return $this->strValue;
        case TokenType::Number:
            return $this->numValue.toString();
        default:
            return null;
    }
}
}