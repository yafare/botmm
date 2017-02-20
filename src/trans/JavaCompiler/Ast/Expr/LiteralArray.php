<?php


namespace trans\JavaCompiler\Ast\Expr;


use trans\JavaCompiler\Ast\AST;
use trans\JavaCompiler\Ast\AstVisitor;
use trans\JavaCompiler\Ast\ParseSpan;


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