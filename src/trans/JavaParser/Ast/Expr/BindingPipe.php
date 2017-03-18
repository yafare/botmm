<?php


namespace trans\JavaParser\Ast\Expr;


use trans\JavaParser\Ast\AST;
use trans\JavaParser\Ast\AstVisitor;
use trans\JavaParser\Ast\ParseSpan;

class BindingPipe extends AST
{
    public $exp;
    public $name;
    public $args;

    public function __construct(ParseSpan $span, AST $exp, string $name, array $args)
    {
        parent::__construct($span);
        $this->exp = $exp;
        $this->name = $name;
        $this->args = $args;
    }

    public function visit(AstVisitor $visitor, $context = null)
    {
        return $visitor->visitPipe($this, $context);
    }
}