<?php


namespace trans\JavaParser\Parser;

use trans\JavaParser\Ast\Body\AnnotationDeclaration;
use trans\JavaParser\Ast\Expr\LiteralArray;
use trans\JavaParser\Chars;
use trans\JavaParser\Keywords;


/**
 * Class ParseAnnotationTypeDeclaration
 *
 * @mixin ParseAST
 * @mixin ParseAnnotationTypeDeclaration
 * @package trans\JavaParser\Parser
 */
trait ParseAnnotationTypeDeclaration
{
    public function parseAnnotationTypeDeclaration($modifier)
    {
        $start = $this->getInputIndex();
        $this->expectCharacter(Chars::AT);
        $this->expectKeyword(Keywords::_INTERFACE_);
        $name    = $this->parseSimpleName();
        $members = $this->parseAnnotationTypeBody();
        return new AnnotationDeclaration($this->span($start), $modifier['modifiers'], $modifier['annotations'], $name,
                                         $members);
    }

    public function parseAnnotationTypeBody(): LiteralArray
    {
        $members = [];
        $start   = $this->getInputIndex();
        $this->expectCharacter(Chars::LBRACE);
        while (true) {
            $member = $this->parseAnnotationBodyDeclaration();
            if (!$member) {
                break;
            } else {
                $members[] = $member;
            }
        }
        $this->expectCharacter(Chars::RBRACE);
        return new LiteralArray($this->span($start), $members);
    }

    public function parseAnnotationBodyDeclaration()
    {
        $ret = null;
        $n   = $this->getNext();
        if ($n->isCharacter(Chars::SEMICOLON)) {
            $this->advance();
        }
        $modifier = $this->getModifier();

        $n = $this->getNext();
        if ($n->isKeywordClass()
            || $n->isKeywordInterface()
        ) {
            return $this->parseAnnotationTypeMemberDeclaration($modifier);
        } elseif ($n->isKeywordEnum()) {
            return $this->parseEnumDeclaration($modifier);
        } elseif ($n->isCharacter(Chars::AT)) {
            return $this->parseAnnotationTypeDeclaration($modifier);
        } elseif ($n->isKeywordBoolean()
                  || $n->iskeywordByte()
                  || $n->isKeywordChar()
                  || $n->isKeywordDouble()
                  || $n->isKeywordFloat()
                  || $n->isKeywordInt()
                  || $n->isKeywordLong()
                  || $n->isKeywordShort()
                  || $n->isIdentifier()
        ) {
            return $this->parseFieldDeclaration($modifier);

        }

    }

    public function parseAnnotationTypeMemberDeclaration($modifier)
    {

    }

    public function parseAnnotatedClassOrInterfaceType()
    {
        $start = $this->getInputIndex();
        $annotations = $this->parseAnnotations();
        $cit = $this->parseClassOrInterfaceType();

    }
}