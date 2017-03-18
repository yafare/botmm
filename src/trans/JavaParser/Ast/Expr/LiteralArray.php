<?php


namespace trans\JavaParser\Ast\Expr;


use trans\JavaParser\Ast\AST;
use trans\JavaParser\Ast\AstVisitor;
use trans\JavaParser\Ast\ParseSpan;


class LiteralArray extends AST
{
    public $expressions;

    public function __construct(ParseSpan $span, array $expressions)
    {
        parent::__construct($span);
        $this->expressions = $expressions;
    }

    public function visit(AstVisitor $visitor, $context = null)
    {
        return $visitor->visitLiteralArray($this, $context);
    }
}