<?php


namespace trans\JavaParser\Parser;

use trans\JavaParser\Ast\Expr\LiteralPrimitive;
use trans\JavaParser\Ast\PrimitiveType;
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

    }

    public function parseReferenceType()
    {
        $n = $this->getNext();
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

        }
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

    public function parseReferenceType()
    {
        if()

    }

    public function parseWildcard()
    {

    }
}