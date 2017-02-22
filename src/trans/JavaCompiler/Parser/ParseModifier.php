<?php


namespace trans\JavaCompiler\Parser;


use PhpParser\Node\Expr\AssignOp\Mod;
use trans\JavaCompiler\Ast\Statement\Modifier;
use trans\JavaCompiler\Chars;
use trans\JavaCompiler\Lexer\Token;

trait ParseModifier
{

    public function parseModifier()
    {

        $modifier = new Modifier();
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
            } elseif ($next->isIdentifier() && $next->strValue == Chars::AT) {
                $ann           = $this->parseAnnotation();
                $annotations[] = $ann;
            } else {
                break;
            }
        }

        return ModifierHolder($modifier, $annotations);
    }

    public function parseAnnotation()
    {
        $this->expectCharacter(Chars::AT);
        $name = $this->parseName();

        $this->expectCharacter(Chars::LPAREN);
        if ($this->getNext()->isIdentifier()) {
            $this->parseMemberValuePairs();
        }

        $this->expectCharacter(Chars::RPAREN);


    }

    public function parseMemberValuePairs()
    {

    }

    public function parseMemberValuePair()
    {

    }
}