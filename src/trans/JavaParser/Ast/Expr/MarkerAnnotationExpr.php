<?php


namespace trans\JavaCompiler\Ast\Expr;


use trans\JavaCompiler\Ast\AST;
use trans\JavaCompiler\Ast\AstVisitor;
use trans\JavaCompiler\Ast\ParseSpan;

class MarkerAnnotationExpr extends AST
{
    public $name;

    public function __construct(ParseSpan $span, $name)
    {
        parent::__construct($span);
        $this->name = $name;
    }

    public function visit(AstVisitor $visitor, $context = null)
    {
        return $visitor->visitMarkerAnnotationExpr($this, $context);
    }

}