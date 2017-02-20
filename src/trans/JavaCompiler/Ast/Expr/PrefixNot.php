<?php


namespace trans\JavaCompiler\Ast\Expr;


use trans\JavaCompiler\Ast\AST;
use trans\JavaCompiler\Ast\AstVisitor;
use trans\JavaCompiler\Ast\ParseSpan;


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

