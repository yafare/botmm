<?php


namespace trans\JavaParser\Ast\Expr;


use trans\JavaParser\Ast\AST;
use trans\JavaParser\Ast\AstVisitor;
use trans\JavaParser\Ast\ParseSpan;


class KeyedWrite extends AST
{
    public $obj;
    public $key;
    public $value;

    public function __construct(ParseSpan $span, AST $obj, AST $key, AST $value)
    {
        parent::__construct($span);
        $this->obj = $obj;
        $this->key = $key;
        $this->value = $value;
    }

    public function visit(AstVisitor $visitor, $context = null)
    {
        return $visitor->visitKeyedWrite($this, $context);
    }
}