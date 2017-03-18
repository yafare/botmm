<?php


namespace trans\JavaCompiler\Ast\Expr;


use trans\JavaCompiler\Ast\AST;
use trans\JavaCompiler\Ast\AstVisitor;
use trans\JavaCompiler\Ast\ParseSpan;

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