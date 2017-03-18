<?php


namespace trans\JavaParser\Ast\Expr;


use trans\JavaParser\Ast\AST;
use trans\JavaParser\Ast\AstVisitor;
use trans\JavaParser\Ast\ParseSpan;


class LiteralMap extends AST
{
    public $keys;
    public $values;

    public function __construct(ParseSpan $span, array $keys, array $values)
    {
        parent::__construct($span);
        $this->keys = $keys;
        $this->values = $values;
    }

    public function visit(AstVisitor $visitor, $context = null)
    {
        return $visitor->visitLiteralMap($this, $context);
    }
}