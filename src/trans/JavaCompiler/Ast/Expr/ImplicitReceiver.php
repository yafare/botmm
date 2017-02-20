<?php


namespace trans\JavaCompiler\Ast\Expr;


use trans\JavaCompiler\Ast\AST;




class ImplicitReceiver extends AST
{
    public function visit(AstVisitor $visitor, $context = null)
    {
        return $visitor->visitImplicitReceiver($this, $context);
    }
}