<?php


namespace trans\JavaParser\Parser;

use trans\JavaParser\Ast\Body\ClassOrInterfaceDeclaration;
use trans\JavaParser\Ast\AST;
use trans\JavaParser\Ast\Expr\EmptyExpr;
use trans\JavaParser\Ast\Expr\LiteralArray;
use trans\JavaParser\Ast\Expr\MarkerAnnotationExpr;
use trans\JavaParser\Ast\Expr\MemberValuePair;
use trans\JavaParser\Ast\Expr\NormalAnnotationExpr;
use trans\JavaParser\Ast\Expr\SingleMemberAnnotationExpr;
use trans\JavaParser\Ast\Modifier;
use trans\JavaParser\Chars;
use trans\JavaParser\Keywords;
use trans\JavaParser\Lexer\Token;

/**
 * Class ParseClass
 *
 * @mixin ParseAST
 * @package trans\JavaParser\Parser
 */
trait ParseClassOrInterfaceDeclaration
{

    public function parseClassOrInterfaceDeclaration($modifier)
    {
        $start       = $this->getInputIndex();
        $n           = $this->getNext();
        $isInterface = null;
        $typePair    = [];
        $impList     = [];
        $extendList  = [];
        if ($n->isKeywordClass()) {
            $this->advance();
            $isInterface = false;
        } elseif ($n->isKeywordInterface()) {
            $this->advance();
            $isInterface = true;
        } else {
            $this->error('not found class or interface');
        }
        $name = $this->parseSimpleName();
        if ($this->optionalCharacter(Chars::LT)) {
            $typePair = $this->getTypeParamers();
        }
        if ($this->getNext()->isKeywordExtends()) {
            $extendList = $this->getExtendsList($isInterface);

        }
        if ($this->getNext()->isKeywordImplements()) {
            $impList = $this->parseImplementsList($isInterface);
        }
        $members = $this->getClassOrInterfaceBody($isInterface);
        return new ClassOrInterfaceDeclaration($this->span($start),
                                               $modifier['modifier'],
                                               $modifier['annotations'],
                                               $isInterface,
                                               $name,
                                               $typePair,
                                               $extendList,
                                               $impList,
                                               $members);

    }

    public function getModifier()
    {

        $modifier    = new Modifier();
        $annotations = [];
        while (true) {
            /** @var Token $next */
            $next = $this->getNext();
            if ($next->isKeywordPublic()) {
                $this->advance();
                $modifier->add(Modifier::PUBLIC);
            } elseif ($next->isKeywordStatic()) {
                $this->advance();
                $modifier->add(Modifier::STATIC);
            } elseif ($next->isKeywordProtected()) {
                $this->advance();
                $modifier->add(Modifier::PROTECTED);
            } elseif ($next->isKeywordPrivate()) {
                $this->advance();
                $modifier->add(Modifier::PRIVATE);
            } elseif ($next->isKeywordFinal()) {
                $this->advance();
                $modifier->add(Modifier::FINAL);
            } elseif ($next->isKeywordAbstract()) {
                $this->advance();
                $modifier->add(Modifier::ABSTRACT);
            } elseif ($next->isKeywordSynchronized()) {
                $this->advance();
                $modifier->add(Modifier::SYNCHRONIZED);
            } elseif ($next->isKeywordNative()) {
                $this->advance();
                $modifier->add(Modifier::NATIVE);
            } elseif ($next->isKeywordTransient()) {
                $this->advance();
                $modifier->add(Modifier::TRANSIENT);
            } elseif ($next->isKeywordVolatile()) {
                $this->advance();
                $modifier->add(Modifier::VOLATILE);
            } elseif ($next->isKeywordStrictfp()) {
                $this->advance();
                $modifier->add(Modifier::STRICTFP);
            } elseif ($next->isCharacter(Chars::AT)) {
                $ann           = $this->parseAnnotation();
                $annotations[] = $ann;
            } else {
                break;
            }
        }

        return ['modifier' => $modifier, 'annotations' => $annotations];
    }

    public function parseAnnotations()
    {
        $start       = $this->getInputIndex();
        $annotations = [];
        while (true) {
            if ($this->getNext()->isCharacter(Chars::AT)) {
                $annotations[] = $this->parseAnnotation();
            } else {
                break;
            }
        }
        return new LiteralArray($this->span($start), $annotations);
    }

    public function parseAnnotation()
    {
        $this->expectCharacter(Chars::AT);
        $start = $this->getInputIndex();
        $name  = $this->parseName();

        $this->expectCharacter(Chars::LPAREN);
        if ($this->getNext()->isIdentifier() && $this->peek(1)->isCharacter(Chars::EQ)) {
            $pairs = $this->parseMemberValuePairs();
            $this->expectCharacter(Chars::RPAREN);
            return new NormalAnnotationExpr($this->span($start), $name, $pairs);
        } elseif ($this->getNext()->isIdentifier() && $this->peek(1)->isCharacter(Chars::RPAREN)) {
            $memberValue = $this->parseMemberValue();
            $this->expectCharacter(Chars::RPAREN);
            return new SingleMemberAnnotationExpr($this->span($start), $name, $memberValue);
        } else {
            $this->expectCharacter(Chars::RPAREN);
            return new MarkerAnnotationExpr($this->span($start), $name);
        }
    }

    public function parseMemberValuePairs(): LiteralArray
    {
        $start   = $this->getInputIndex();
        $pairs   = [];
        $pairs[] = $this->parseMemberValuePair();
        while (true) {
            if ($this->optionalCharacter(Chars::COMMA)) {
                $this->advance();
                $pairs[] = $this->parseMemberValuePair();
            } else {
                break;
            }
        }
        return new LiteralArray($this->span($start), $pairs);

    }

    public function parseMemberValuePair(): MemberValuePair
    {
        $name  = $this->parseSimpleName();
        $start = $this->getInputIndex();
        $this->expectCharacter(Chars::EQ);
        $value = $this->parseMemberValue();

        return new MemberValuePair($this->span($start), $name, $value);
    }

    public function parseMemberValue(): AST
    {
        $n = $this->getNext();
        if ($n->isCharacter(Chars::AT)) {
            return $this->parseAnnotation();
        } elseif ($n->isCharacter(Chars::LBRACE)) {
            return $this->parseMemberValueArrayInitializer();
        } else {
            return $this->parseExpression();
        }
    }

    public function parseMemberValueArrayInitializer(): AST
    {
        $values = [];
        $this->expectCharacter(Chars::LBRACE);
        $start = $this->getInputIndex();

        $values[] = $this->parseMemberValue();
        while (true) {
            if ($this->optionalCharacter(Chars::COMMA)) {
                $values[] = $this->parseMemberValue();
            }
        }
        $this->expectCharacter(Chars::RBRACE);
        return new LiteralArray($this->span($start), $values);

    }

    public function getClassOrInterfaceBody($isInterface)
    {
        $body = [];
        $this->expectCharacter(Chars::LBRACE);
        while (true) {
            $n = $this->getNext();
            if (
                $n->isKeywordAbstract()
                || $n->isKeywordBoolean()
                || $n->isKeywordByte()
                || $n->isKeywordChar()
                || $n->isKeywordClass()
                || $n->isKeywordDefault()
                || $n->isKeywordDouble()
                || $n->isKeywordEnum()
                || $n->isKeywordFinal()
                || $n->isKeywordFloat()
                || $n->isKeywordInt()
                || $n->isKeywordInterface()
                || $n->isKeywordLong()
                || $n->isKeywordNative()
                || $n->isKeywordPrivate()
                || $n->isKeywordProtected()
                || $n->isKeywordPublic()
                || $n->isKeywordShort()
                || $n->isKeywordStatic()
                || $n->isKeywordStrictfp()
                || $n->isKeywordSynchronized()
                || $n->isKeywordTransient()
                || $n->isKeywordVoid()
                || $n->isKeywordVolatile()
                || $n->isIdentifier()
                || $n->isCharacter(Chars::LBRACE)
                || $n->isCharacter(Chars::SEMICOLON)
                || $n->isCharacter(Chars::AT)
                || $n->isCharacter(Chars::LT)
            ) {
                $member = $this->parseClassOrInterfaceBodyDeclaration($isInterface);
                $body[] = $member;
            } else {
                break;
            }
        }
        $this->expectCharacter(Chars::RBRACE);
        return $body;
    }

    public function parseClassOrInterfaceBodyDeclaration($isInterface): AST
    {
        return new EmptyExpr($this->span(0));

    }

    public function getExtendsList($isInterface)
    {
        $start              = $this->getInputIndex();
        $extendList         = [];
        $extendsMoreThanOne = false;
        $this->expectKeyword(Keywords::_EXTENDS_);
        $this->parseAnnotatedClassOrInterfaceType();
        while (true) {
            if ($this->optionalCharacter(Chars::COMMA)) {
                $this->parseAnnotatedClassOrInterfaceType();
                $extendsMoreThanOne = true;
            } else {
                break;
            }
        }
        if ($extendsMoreThanOne && !$isInterface) {
            $this->error("A class cannot extend more than one other class");
        }
        return $extendList;
    }

    public function parseClassOrInterfaceType()
    {
        $start    = $this->getInputIndex();
        $name     = $this->parseSimpleName();
        if($this->optionalCharacter(Chars::LT)){
            $typeArgs = $this->getTypeArguments();
        }

    }
}