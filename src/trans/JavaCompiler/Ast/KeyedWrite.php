<?php


namespace trans\JavaCompiler\Ast;


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