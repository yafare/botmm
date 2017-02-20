<?php


namespace trans\JavaCompiler\Ast\Expr;


use trans\JavaCompiler\Ast\AST;
use trans\JavaCompiler\Ast\AstVisitor;
use trans\JavaCompiler\Ast\ParseSpan;


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




