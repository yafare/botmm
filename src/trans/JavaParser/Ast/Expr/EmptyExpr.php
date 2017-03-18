<?php


namespace trans\JavaParser\Ast\Expr;



use trans\JavaParser\Ast\AST;
use trans\JavaParser\Ast\AstVisitor;

class EmptyExpr extends AST
{
    public function visit(AstVisitor $visitor, $context = null)
    {
        // do nothing
    }
}