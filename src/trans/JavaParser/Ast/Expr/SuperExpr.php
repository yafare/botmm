<?php


namespace trans\JavaParser\Ast\Expr;


use trans\JavaParser\Ast\AST;
use trans\JavaParser\Ast\AstVisitor;
use trans\JavaParser\Ast\ParseSpan;

class SuperExpr extends AST
{
    public $classExpr;

    public function __construct(ParseSpan $span, $classExpr)
    {
        parent::__construct($span);
        $this->classExpr = $classExpr;
    }

    public function visit(AstVisitor $visitor, $context = null)
    {
        return $visitor->visitSuperExpr($this, $context);
    }
}