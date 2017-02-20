<?php


namespace trans\JavaCompiler\Ast\Expr;


use trans\JavaCompiler\Ast\AST;

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