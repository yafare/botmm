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

    //region java keyword

    public function isKeywordAbstract(): bool
    {
        return $this->type == TokenType::Keyword && $this->strValue == 'abstract';
    }
    public function isKeywordContinue(): bool
    {
        return $this->type == TokenType::Keyword && $this->strValue == 'continue';
    }
    public function isKeywordFor(): bool
    {
        return $this->type == TokenType::Keyword && $this->strValue == 'for';
    }
    public function isKeywordNew(): bool
    {
        return $this->type == TokenType::Keyword && $this->strValue == 'new';
    }
    public function isKeywordSwitch(): bool
    {
        return $this->type == TokenType::Keyword && $this->strValue == 'switch';
    }
    public function isKeywordAssert(): bool
    {
        return $this->type == TokenType::Keyword && $this->strValue == 'assert';
    }
    public function isKeywordDefault(): bool
    {
        return $this->type == TokenType::Keyword && $this->strValue == 'default';
    }
    public function isKeywordGoto(): bool
    {
        return $this->type == TokenType::Keyword && $this->strValue == 'goto';
    }
    public function isKeywordPackage(): bool
    {
        return $this->type == TokenType::Keyword && $this->strValue == 'package';
    }
    public function isKeywordSynchronized(): bool
    {
        return $this->type == TokenType::Keyword && $this->strValue == 'synchronized';
    }
    public function isKeywordBoolean(): bool
    {
        return $this->type == TokenType::Keyword && $this->strValue == 'boolean';
    }
    public function isKeywordDo(): bool
    {
        return $this->type == TokenType::Keyword && $this->strValue == 'do';
    }
    public function isKeywordIf(): bool
    {
        return $this->type == TokenType::Keyword && $this->strValue == 'if';
    }
    public function isKeywordPrivate(): bool
    {
        return $this->type == TokenType::Keyword && $this->strValue == 'private';
    }
    public function isKeywordThis(): bool
    {
        return $this->type == TokenType::Keyword && $this->strValue == 'this';
    }
    public function isKeywordBreak(): bool
    {
        return $this->type == TokenType::Keyword && $this->strValue == 'break';
    }
    public function isKeywordDouble(): bool
    {
        return $this->type == TokenType::Keyword && $this->strValue == 'double';
    }
    public function isKeywordImplements(): bool
    {
        return $this->type == TokenType::Keyword && $this->strValue == 'implements';
    }
    public function isKeywordProtected(): bool
    {
        return $this->type == TokenType::Keyword && $this->strValue == 'protected';
    }
    public function isKeywordThrow(): bool
    {
        return $this->type == TokenType::Keyword && $this->strValue == 'throw';
    }
    public function isKeywordByte(): bool
    {
        return $this->type == TokenType::Keyword && $this->strValue == 'byte';
    }
    public function isKeywordElse(): bool
    {
        return $this->type == TokenType::Keyword && $this->strValue == 'else';
    }
    public function isKeywordImport(): bool
    {
        return $this->type == TokenType::Keyword && $this->strValue == 'import';
    }
    public function isKeywordPublic(): bool
    {
        return $this->type == TokenType::Keyword && $this->strValue == 'public';
    }
    public function isKeywordThrows(): bool
    {
        return $this->type == TokenType::Keyword && $this->strValue == 'throws';
    }
    public function isKeywordCase(): bool
    {
        return $this->type == TokenType::Keyword && $this->strValue == 'case';
    }
    public function isKeywordEnum(): bool
    {
        return $this->type == TokenType::Keyword && $this->strValue == 'enum';
    }
    public function isKeywordInstanceof(): bool
    {
        return $this->type == TokenType::Keyword && $this->strValue == 'instanceof';
    }
    public function isKeywordReturn(): bool
    {
        return $this->type == TokenType::Keyword && $this->strValue == 'return';
    }
    public function isKeywordTransient(): bool
    {
        return $this->type == TokenType::Keyword && $this->strValue == 'transient';
    }
    public function isKeywordCatch(): bool
    {
        return $this->type == TokenType::Keyword && $this->strValue == 'catch';
    }
    public function isKeywordExtends(): bool
    {
        return $this->type == TokenType::Keyword && $this->strValue == 'extends';
    }
    public function isKeywordInt(): bool
    {
        return $this->type == TokenType::Keyword && $this->strValue == 'int';
    }
    public function isKeywordShort(): bool
    {
        return $this->type == TokenType::Keyword && $this->strValue == 'short';
    }
    public function isKeywordTry(): bool
    {
        return $this->type == TokenType::Keyword && $this->strValue == 'try';
    }
    public function isKeywordChar(): bool
    {
        return $this->type == TokenType::Keyword && $this->strValue == 'char';
    }
    public function isKeywordFinal(): bool
    {
        return $this->type == TokenType::Keyword && $this->strValue == 'final';
    }
    public function isKeywordInterface(): bool
    {
        return $this->type == TokenType::Keyword && $this->strValue == 'interface';
    }
    public function isKeywordStatic(): bool
    {
        return $this->type == TokenType::Keyword && $this->strValue == 'static';
    }
    public function isKeywordVoid(): bool
    {
        return $this->type == TokenType::Keyword && $this->strValue == 'void';
    }
    public function isKeywordClass(): bool
    {
        return $this->type == TokenType::Keyword && $this->strValue == 'class';
    }
    public function isKeywordFinally(): bool
    {
        return $this->type == TokenType::Keyword && $this->strValue == 'finally';
    }
    public function isKeywordLong(): bool
    {
        return $this->type == TokenType::Keyword && $this->strValue == 'long';
    }
    public function isKeywordStrictfp(): bool
    {
        return $this->type == TokenType::Keyword && $this->strValue == 'strictfp';
    }
    public function isKeywordVolatile(): bool
    {
        return $this->type == TokenType::Keyword && $this->strValue == 'volatile';
    }
    public function isKeywordConst(): bool
    {
        return $this->type == TokenType::Keyword && $this->strValue == 'const';
    }
    public function isKeywordFloat(): bool
    {
        return $this->type == TokenType::Keyword && $this->strValue == 'float';
    }
    public function isKeywordNative(): bool
    {
        return $this->type == TokenType::Keyword && $this->strValue == 'native';
    }
    public function isKeywordSuper(): bool
    {
        return $this->type == TokenType::Keyword && $this->strValue == 'super';
    }
    public function isKeywordWhil(): bool
    {
        return $this->type == TokenType::Keyword && $this->strValue == 'whil';
    }

    //endregion

    public function isError(): bool
    {
        return $this->type == TokenType::Error;
    }

    public function toNumber(): number
    {
        return $this->type == TokenType::Number ? $this->numValue : -1;
    }

    public function toString(): string {
        return strval($this);
    }

    public function __toString(): string
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
                return strval($this->numValue);
            default:
                return null;
        }
    }
}