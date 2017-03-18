<?php


namespace trans\JavaParser\Ast\Expr;


use trans\JavaParser\Ast\AST;
use trans\JavaParser\Ast\AstVisitor;
use trans\JavaParser\Ast\ParseSpan;


class PrefixNot extends AST
{
    public $expression;

    public function __construct(ParseSpan $span, AST $expression)
    {
        parent::__construct($span);
        $this->expression = $expression;
    }

    public function visit(AstVisitor $visitor, $context = null)
    {
        return $visitor->visitPrefixNot($this, $context);
    }
}

