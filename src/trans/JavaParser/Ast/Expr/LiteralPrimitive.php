<?php


namespace trans\JavaParser\Ast\Expr;


use trans\JavaParser\Ast\AST;
use trans\JavaParser\Ast\AstVisitor;
use trans\JavaParser\Ast\ParseSpan;


class LiteralPrimitive extends AST
{
    public $value;

    public function __construct(ParseSpan $span, $value)
    {
        parent::__construct($span);
        $this->value = $value;
    }

    public function visit(AstVisitor $visitor, $context = null)
    {
        return $visitor->visitLiteralPrimitive($this, $context);
    }
}