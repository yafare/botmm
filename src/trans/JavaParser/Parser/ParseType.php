<?php


namespace trans\JavaParser\Parser;

use trans\JavaParser\Ast\Expr\LiteralPrimitive;
use trans\JavaParser\Ast\PrimitiveType;
use trans\JavaParser\Ast\Type\ArrayBracketPair;
use trans\JavaParser\Ast\Type\ArrayType;
use trans\JavaParser\Chars;


/**
 * Class ParseType
 *
 * @mixin ParseAST
 * @package trans\JavaParser\Parser
 */
trait ParseType
{

    public function parseType()
    {
        if (
            $this->getNext()->isKeyword()
            && $this->peek(1)->isCharacter(Chars::LBRACKET)
        ) {
            return $this->parseReferenceType();
        } else {
            return $this->parsePrimitiveType();
        }
    }

    public function parsePrimitiveType()
    {
        $start = $this->getInputIndex();
        $n     = $this->getNext();
        if ($n->isKeywordBoolean()) {
            return new PrimitiveType($this->span($start), PrimitiveType::BOOLEAN);
        } elseif ($n->isKeywordChar()) {
            return new PrimitiveType($this->span($start), PrimitiveType::CHAR);
        } elseif ($n->isKeywordByte()) {
            return new PrimitiveType($this->span($start), PrimitiveType::BYTE);
        } elseif ($n->isKeywordShort()) {
            return new PrimitiveType($this->span($start), PrimitiveType::SHORT);
        } elseif ($n->isKeywordInt()) {
            return new PrimitiveType($this->span($start), PrimitiveType::INT);
        } elseif ($n->isKeywordLong()) {
            return new PrimitiveType($this->span($start), PrimitiveType::LONG);
        } elseif ($n->isKeywordFloat()) {
            return new PrimitiveType($this->span($start), PrimitiveType::FLOAT);
        } elseif ($n->isKeywordDouble()) {
            return new PrimitiveType($this->span($start), PrimitiveType::DOUBLE);
        }

    }

    public function parseReferenceType()
    {
        $start             = $this->getInputIndex();
        $n                 = $this->getNext();
        $arrayBracketPairs = [];
        if ($n->isKeywordBoolean()
            || $n->iskeywordByte()
            || $n->iskeywordChar()
            || $n->isKeywordDouble()
            || $n->isKeywordFloat()
            || $n->isKeywordInt()
            || $n->isKeywordLong()
            || $n->iskeywordShort()
        ) {
            $type = $this->parsePrimary();
        } elseif ($this->getNext()->isIdentifier()) {
            $type = $this->parseClassOrInterfaceType();
        } else {
            throw new \Exception('parse error');
        }
        while (true) {
            $arrayBracketPairs[] = $this->parseArrayBracketPair();
            if ($this->getNext()->isCharacter(Chars::LBRACKET)
                || $this->getNext()->isCharacter(Chars::AT)
            ) {

            } else {
                break;
            }
        }
        return $this->wrapInArrayTypes($type, $arrayBracketPairs);
    }

    public function parseArrayBracketPair()
    {
        $start       = $this->getInputIndex();
        $annotations = $this->parseAnnotations();
        $this->expectCharacter(Chars::LBRACKET);
        $this->expectCharacter(Chars::RBRACKET);
        return new ArrayBracketPair($this->span($start), $annotations);
    }

    public function parsePrimaryType()
    {
        $start = $this->getInputIndex();
        $n     = $this->getNext();
        if ($n->isKeywordBoolean()) {
            $this->advance();
            return new LiteralPrimitive($this->span($start), PrimitiveType::BOOLEAN);
        } elseif ($n->isKeywordChar()) {
            $this->advance();
            return new LiteralPrimitive($this->span($start), PrimitiveType::CHAR);
        } elseif ($n->isKeywordByte()) {
            $this->advance();
            return new LiteralPrimitive($this->span($start), PrimitiveType::BYTE);
        } elseif ($n->isKeywordShort()) {
            $this->advance();
            return new LiteralPrimitive($this->span($start), PrimitiveType::SHORT);
        } elseif ($n->isKeywordInt()) {
            $this->advance();
            return new LiteralPrimitive($this->span($start), PrimitiveType::INT);
        } elseif ($n->isKeywordLong()) {
            $this->advance();
            return new LiteralPrimitive($this->span($start), PrimitiveType::LONG);
        } elseif ($n->isKeywordFloat()) {
            $this->advance();
            return new LiteralPrimitive($this->span($start), PrimitiveType::FLOAT);
        } elseif ($n->isKeywordDouble()) {
            $this->advance();
            return new LiteralPrimitive($this->span($start), PrimitiveType::DOUBLE);
        }

    }

    public function getTypeParamers()
    {
        $paramers = [];
        $this->expectCharacter(Chars::LT);
        $annotations = $this->parseAnnotations();
        $tp          = $this->parseTypeParamer();
        $tp->setAnnotations($annotations);
        $paramers[] = $tp;
        if ($this->optionalCharacter(Chars::COMMA)) {
            $annotations = $this->parseAnnotations();
            $tp          = $this->parseTypeParamer();
            $tp->setAnnotations($annotations);
            $paramers[] = $tp;
        }
        $this->expectCharacter(Chars::GT);
        return $paramers;
    }

    public function getTypeArguments()
    {
        $arguments = [];
        $this->expectCharacter(Chars::LT);
        $n = $this->getNext();
        if ($n->isKeywordBoolean()
            || $n->iskeywordByte()
            || $n->isKeywordChar()
            || $n->isKeywordDouble()
            || $n->isKeywordFloat()
            || $n->isKeywordInt()
            || $n->isKeywordLong()
            || $n->isKeywordShort()
            || $n->isIdentifier()
            || $n->isCharacter(Chars::AT)
            || $n->isCharacter(Chars::QUESTION)
        ) {
            $arguments[] = $this->parseTypeArgument();
            while (true) {
                if ($this->optionalCharacter(Chars::COMMA)) {
                    $arguments[] = $this->parseTypeArgument();
                } else {
                    break;
                }
            }
        }
        $this->expectCharacter(Chars::GT);
        return $arguments;
    }

    public function parseTypeArgument()
    {
        $annotations = $this->parseAnnotations();
        $n           = $this->getNext();
        if (
            $n->isKeywordBoolean()
            || $n->isKeywordByte()
            || $n->isKeywordChar()
            || $n->isKeywordDouble()
            || $n->isKeywordFloat()
            || $n->isKeywordInt()
            || $n->isKeywordLong()
            || $n->isKeywordShort()
            || $n->isIdentifier()
        ) {
            $ret = $this->parseReferenceType();
        } elseif ($n->isCharacter(Chars::QUESTION)) {
            $ret = $this->parseWildcard();
        }
        $ret->setAnnotations($annotations);
        return $ret;
    }

    public function parseWildcard()
    {

    }
}