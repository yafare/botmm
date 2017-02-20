<?php


namespace trans\JavaCompiler\Ast\Expr;


use trans\JavaCompiler\Ast\AST;
use trans\JavaCompiler\Ast\AstVisitor;


class ImplicitReceiver extends AST
{
    public function visit(AstVisitor $visitor, $context = null)
    {
        return $visitor->visitImplicitReceiver($this, $context);
    }
}