<?php


namespace trans\JavaParser\Ast\Expr;


use trans\JavaParser\Ast\AST;
use trans\JavaParser\Ast\AstVisitor;
use trans\JavaParser\Ast\ParseSpan;

class SingleMemberAnnotationExpr extends AST
{

    public $name;
    public $memberValue;

    public function __construct(ParseSpan $span, $name, $memberValue)
    {
        parent::__construct($span);
        $this->name        = $name;
        $this->memberValue = $memberValue;
    }

    public function visit(AstVisitor $visitor, $context = null)
    {
        return $visitor->visitSingleMemberAnnotationExpr($this, $context);
    }
}