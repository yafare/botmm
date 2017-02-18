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

    public function isCharacter(int $code): boolean {
        return $this->type == TokenType::Character && $this->numValue == $code;
    }

    public function isNumber(): boolean {
        return $this->type == TokenType::Number;
    }

    public function isString(): boolean {
        return $this->type == TokenType::String;
    }

    public function  isOperator(string $operater): boolean {
        return $this->type == TokenType::Operator && $this->strValue == $operater;
    }

    public function isIdentifier(): boolean { return $this->type == TokenType::Identifier; }

    public function  isKeyword(): boolean { return $this->type == TokenType::Keyword; }

    public function  isKeywordLet(): boolean { return $this->type == TokenType::Keyword && $this->strValue == 'let'; }

    public function  isKeywordNull(): boolean { return $this->type == TokenType::Keyword && $this->strValue == 'null'; }

    public function  isKeywordUndefined(): boolean {
        return $this->type == TokenType::Keyword && $this->strValue == 'undefined';
    }

    public function isKeywordTrue(): boolean { return $this->type == TokenType::Keyword && $this->strValue == 'true'; }

    public function  isKeywordFalse(): boolean { return $this->type == TokenType::Keyword && $this->strValue == 'false'; }

    public function  isKeywordThis(): boolean { return $this->type == TokenType::Keyword && $this->strValue == 'this'; }

    public function  isError(): boolean { return $this->type == TokenType::Error; }

    public function toNumber(): number { return $this->type == TokenType::Number ? $this->numValue : -1; }

    public function  toString(): string {
        switch ($this->type) {
            case TokenType::Character:
            case TokenType::Identifier:
            case TokenType::Keyword:
            case TokenType::Operator:
            case TokenType::String:
            case TokenType::Error:
                return $this->strValue;
            case TokenType::Number:
                return $this->numValue.'';
            default:
                return null;
        }
    }
}