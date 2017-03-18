<?php


namespace trans\JavaCompiler\Ast\Expr;


use trans\JavaCompiler\Ast\AST;
use trans\JavaCompiler\Ast\AstVisitor;
use trans\JavaCompiler\Ast\ParseSpan;


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