<?php


namespace trans\JavaParser\Parser;


use trans\JavaParser\Ast\AST;
use trans\JavaParser\Chars;

/**
 * Class ParseVariableDeclarationExpression
 *
 * @mixin ParseAST
 * @package trans\JavaParser\Parser
 */
trait ParseVariableDeclarationExpression extends AST
{
    public function parseVariableDeclarationExpression()
    {
        $modifier    = $this->getModifier();
        $partialType = $this->parseType();
        $var         = $this->parseVariableDeclarator($partialType);
        $variables[] = $var;
        while (true) {
            if ($this->optionalCharacter(Chars::STAR)) {
                $var = $this->parseVariableDeclarator($partialType);
                $variables[] = $var;
            }
            break;
        }
        return new VariableDeclarationExpression($span)

    }

}