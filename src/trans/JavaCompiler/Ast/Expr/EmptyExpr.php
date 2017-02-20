<?php


namespace trans\JavaCompiler\Ast\Expr;



use trans\JavaCompiler\Ast\AST;

class EmptyExpr extends AST
{
    public function visit(AstVisitor $visitor, $context = null)
    {
        // do nothing
    }
}