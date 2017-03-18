<?php


namespace trans\JavaParser\Ast\Expr;


use trans\JavaParser\Ast\AST;
use trans\JavaParser\Ast\AstVisitor;
use trans\JavaParser\Ast\ParseSpan;


class FunctionCall extends AST
{
    public $target;
    public $args;

    public function __construct(ParseSpan $span, AST $target, array $args)
    {
        parent::__construct($span);
        $this->target = $target;
        $this->args = $args;
    }

    public function visit(AstVisitor $visitor, $context = null)
    {
        return $visitor->visitFunctionCall($this, $context);
    }
}




