<?php
/**
 * Created by IntelliJ IDEA.
 * User: hugo
 * Date: 2017/2/18
 * Time: 21:59
 */

namespace trans\JavaCompiler\Lexer;


use trans\JavaCompiler\Keywords;

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

    //public function isKeywordLet(): bool
    //{
    //    return $this->type == TokenType::Keyword && $this->strValue == Keywords::_LET_;
    //}
    //
    //public function isKeywordNull(): bool
    //{
    //    return $this->type == TokenType::Keyword && $this->strValue == Keywords::_NULL_;
    //}
    //
    //public function isKeywordUndefined(): bool
    //{
    //    return $this->type == TokenType::Keyword && $this->strValue == Keywords::_UNDEFINED_;
    //}
    //
    //public function isKeywordTrue(): bool
    //{
    //    return $this->type == TokenType::Keyword && $this->strValue == Keywords::_TRUE_;
    //}
    //
    //public function isKeywordFalse(): bool
    //{
    //    return $this->type == TokenType::Keyword && $this->strValue == Keywords::_FALSE_;
    //}

    //region java keyword

    public function isKeywordAbstract(): bool
    {
        return $this->type == TokenType::Keyword && $this->strValue == Keywords::_ABSTRACT_;
    }
    public function isKeywordContinue(): bool
    {
        return $this->type == TokenType::Keyword && $this->strValue == Keywords::_CONTINUE_;
    }
    public function isKeywordFor(): bool
    {
        return $this->type == TokenType::Keyword && $this->strValue == Keywords::_FOR_;
    }
    public function isKeywordNew(): bool
    {
        return $this->type == TokenType::Keyword && $this->strValue == Keywords::_NEW_;
    }
    public function isKeywordSwitch(): bool
    {
        return $this->type == TokenType::Keyword && $this->strValue == Keywords::_SWITCH_;
    }
    public function isKeywordAssert(): bool
    {
        return $this->type == TokenType::Keyword && $this->strValue == Keywords::_ASSERT_;
    }
    public function isKeywordDefault(): bool
    {
        return $this->type == TokenType::Keyword && $this->strValue == Keywords::_DEFAULT_;
    }
    public function isKeywordGoto(): bool
    {
        return $this->type == TokenType::Keyword && $this->strValue == Keywords::_GOTO_;
    }
    public function isKeywordPackage(): bool
    {
        return $this->type == TokenType::Keyword && $this->strValue == Keywords::_PACKAGE_;
    }
    public function isKeywordSynchronized(): bool
    {
        return $this->type == TokenType::Keyword && $this->strValue == Keywords::_SYNCHRONIZED_;
    }
    public function isKeywordBoolean(): bool
    {
        return $this->type == TokenType::Keyword && $this->strValue == Keywords::_BOOLEAN_;
    }
    public function isKeywordDo(): bool
    {
        return $this->type == TokenType::Keyword && $this->strValue == Keywords::_DO_;
    }
    public function isKeywordIf(): bool
    {
        return $this->type == TokenType::Keyword && $this->strValue == Keywords::_IF_;
    }
    public function isKeywordPrivate(): bool
    {
        return $this->type == TokenType::Keyword && $this->strValue == Keywords::_PRIVATE_;
    }
    public function isKeywordThis(): bool
    {
        return $this->type == TokenType::Keyword && $this->strValue == Keywords::_THIS_;
    }
    public function isKeywordBreak(): bool
    {
        return $this->type == TokenType::Keyword && $this->strValue == Keywords::_BREAK_;
    }
    public function isKeywordDouble(): bool
    {
        return $this->type == TokenType::Keyword && $this->strValue == Keywords::_DOUBLE_;
    }
    public function isKeywordImplements(): bool
    {
        return $this->type == TokenType::Keyword && $this->strValue == Keywords::_IMPLEMENTS_;
    }
    public function isKeywordProtected(): bool
    {
        return $this->type == TokenType::Keyword && $this->strValue == Keywords::_PROTECTED_;
    }
    public function isKeywordThrow(): bool
    {
        return $this->type == TokenType::Keyword && $this->strValue == Keywords::_THROW_;
    }
    public function isKeywordByte(): bool
    {
        return $this->type == TokenType::Keyword && $this->strValue == Keywords::_BYTE_;
    }
    public function isKeywordElse(): bool
    {
        return $this->type == TokenType::Keyword && $this->strValue == Keywords::_ELSE_;
    }
    public function isKeywordImport(): bool
    {
        return $this->type == TokenType::Keyword && $this->strValue == Keywords::_IMPORT_;
    }
    public function isKeywordPublic(): bool
    {
        return $this->type == TokenType::Keyword && $this->strValue == Keywords::_PUBLIC_;
    }
    public function isKeywordThrows(): bool
    {
        return $this->type == TokenType::Keyword && $this->strValue == Keywords::_THROWS_;
    }
    public function isKeywordCase(): bool
    {
        return $this->type == TokenType::Keyword && $this->strValue == Keywords::_CASE_;
    }
    public function isKeywordEnum(): bool
    {
        return $this->type == TokenType::Keyword && $this->strValue == Keywords::_ENUM_;
    }
    public function isKeywordInstanceof(): bool
    {
        return $this->type == TokenType::Keyword && $this->strValue == Keywords::_INSTANCEOF_;
    }
    public function isKeywordReturn(): bool
    {
        return $this->type == TokenType::Keyword && $this->strValue == Keywords::_RETURN_;
    }
    public function isKeywordTransient(): bool
    {
        return $this->type == TokenType::Keyword && $this->strValue == Keywords::_TRANSIENT_;
    }
    public function isKeywordCatch(): bool
    {
        return $this->type == TokenType::Keyword && $this->strValue == Keywords::_CATCH_;
    }
    public function isKeywordExtends(): bool
    {
        return $this->type == TokenType::Keyword && $this->strValue == Keywords::_EXTENDS_;
    }
    public function isKeywordInt(): bool
    {
        return $this->type == TokenType::Keyword && $this->strValue == Keywords::_INT_;
    }
    public function isKeywordShort(): bool
    {
        return $this->type == TokenType::Keyword && $this->strValue == Keywords::_SHORT_;
    }
    public function isKeywordTry(): bool
    {
        return $this->type == TokenType::Keyword && $this->strValue == Keywords::_TRY_;
    }
    public function isKeywordChar(): bool
    {
        return $this->type == TokenType::Keyword && $this->strValue == Keywords::_CHAR_;
    }
    public function isKeywordFinal(): bool
    {
        return $this->type == TokenType::Keyword && $this->strValue == Keywords::_FINAL_;
    }
    public function isKeywordInterface(): bool
    {
        return $this->type == TokenType::Keyword && $this->strValue == Keywords::_INTERFACE_;
    }
    public function isKeywordStatic(): bool
    {
        return $this->type == TokenType::Keyword && $this->strValue == Keywords::_STATIC_;
    }
    public function isKeywordVoid(): bool
    {
        return $this->type == TokenType::Keyword && $this->strValue == Keywords::_VOID_;
    }
    public function isKeywordClass(): bool
    {
        return $this->type == TokenType::Keyword && $this->strValue == Keywords::_CLASS_;
    }
    public function isKeywordFinally(): bool
    {
        return $this->type == TokenType::Keyword && $this->strValue == Keywords::_FINALLY_;
    }
    public function isKeywordLong(): bool
    {
        return $this->type == TokenType::Keyword && $this->strValue == Keywords::_LONG_;
    }
    public function isKeywordStrictfp(): bool
    {
        return $this->type == TokenType::Keyword && $this->strValue == Keywords::_STRICTFP_;
    }
    public function isKeywordVolatile(): bool
    {
        return $this->type == TokenType::Keyword && $this->strValue == Keywords::_VOLATILE_;
    }
    public function isKeywordConst(): bool
    {
        return $this->type == TokenType::Keyword && $this->strValue == Keywords::_CONST_;
    }
    public function isKeywordFloat(): bool
    {
        return $this->type == TokenType::Keyword && $this->strValue == Keywords::_FLOAT_;
    }
    public function isKeywordNative(): bool
    {
        return $this->type == TokenType::Keyword && $this->strValue == Keywords::_NATIVE_;
    }
    public function isKeywordSuper(): bool
    {
        return $this->type == TokenType::Keyword && $this->strValue == Keywords::_SUPER_;
    }
    public function isKeywordWhile(): bool
    {
        return $this->type == TokenType::Keyword && $this->strValue == Keywords::_WHILE_;
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