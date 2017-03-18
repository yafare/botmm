<?php


namespace trans\JavaParser\Ast\Expr;


use trans\JavaParser\Ast\AST;
use trans\JavaParser\Ast\AstVisitor;
use trans\JavaParser\Ast\ParseSpan;

class TypeExpr extends AST
{
    public $type;

    public function __construct(ParseSpan $span, $type)
    {
        parent::__construct($span);
        $this->type = $type;
    }

    public function visit(AstVisitor $visitor, $context = null)
    {
        return $visitor->visitTypeExpr($this, $context);
    }
}