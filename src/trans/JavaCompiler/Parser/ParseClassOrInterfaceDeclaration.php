<?php


namespace trans\JavaCompiler\Parser;

use trans\JavaCompiler\Ast\AST;
use trans\JavaCompiler\Ast\Expr\LiteralArray;
use trans\JavaCompiler\Ast\Expr\MarkerAnnotationExpr;
use trans\JavaCompiler\Ast\Expr\MemberValuePair;
use trans\JavaCompiler\Ast\Expr\NormalAnnotationExpr;
use trans\JavaCompiler\Ast\Expr\SingleMemberAnnotationExpr;
use trans\JavaCompiler\Ast\Statement\Modifier;
use trans\JavaCompiler\Chars;
use trans\JavaCompiler\Lexer\Token;

/**
 * Class ParseClass
 *
 * @mixin ParseAST
 * @package trans\JavaCompiler\Parser
 */
trait ParseClassOrInterface
{

    public function parseClass()
    {
        $next = $this->getNext();
        //if($next->);

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
}