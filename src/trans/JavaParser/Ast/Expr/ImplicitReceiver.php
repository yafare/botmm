<?php


namespace trans\JavaParser\Ast\Expr;


use trans\JavaParser\Ast\AST;
use trans\JavaParser\Ast\AstVisitor;


class ImplicitReceiver extends AST
{
    public function visit(AstVisitor $visitor, $context = null)
    {
        return $visitor->visitImplicitReceiver($this, $context);
    }
}