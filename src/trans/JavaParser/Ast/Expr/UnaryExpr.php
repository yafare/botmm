<?php


namespace trans\JavaParser\Ast\Expr;


use trans\JavaParser\Ast\AST;
use trans\JavaParser\Ast\AstVisitor;
use trans\JavaParser\Ast\ParseSpan;

class UnaryExpr extends AST
{
    public $string;

    public function __construct(ParseSpan $span, $string)
    {
        parent::__construct($span);
        $this->string = $string;
    }

    public function visit(AstVisitor $visitor, $context = null)
    {
        return $visitor->visitUnaryExpr($this, $context);
    }
}