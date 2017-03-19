<?php


namespace trans\JavaParser\Parser;


use trans\JavaParser\Ast\Expr\VariableDeclarationExpr;
use trans\JavaParser\Chars;

/**
 * Class ParseVariableDeclarationExpression
 *
 * @mixin ParseAST
 * @package trans\JavaParser\Parser
 */
trait ParseVariableDeclarationExpression
{
    public function parseVariableDeclarationExpression()
    {
        $start       = $this->getInputIndex();
        $modifier    = $this->getModifier();
        $partialType = $this->parseType();
        $var         = $this->parseVariableDeclarator($partialType);
        $variables[] = $var;
        while (true) {
            if ($this->optionalCharacter(Chars::COMMA)) {
                $var         = $this->parseVariableDeclarator($partialType);
                $variables[] = $var;
            }
            break;
        }
        return new VariableDeclarationExpr(
            $this->span($start),
            $modifier['modifiers'],
            $modifier['annotations'],
            $variables
        );

    }

    public function parseVariableDeclarator($partialType)
    {



    }

}