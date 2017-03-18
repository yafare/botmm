<?php


namespace trans\JavaParser\Ast\Expr;


use trans\JavaParser\Ast\AST;
use trans\JavaParser\Ast\AstVisitor;
use trans\JavaParser\Ast\ParseSpan;

class SimpleName extends AST
{

    public $name;
    public function __construct(ParseSpan $span, string $name)
    {
        parent::__construct($span);
        $this->name = $name;
    }

    public function visit(AstVisitor $visitor, $context = null)
    {
        return $visitor->visitSimpleName($this, $context);
    }
}