<?php


namespace trans\JavaCompiler\Ast;


class KeyedRead extends AST
{
    public $obj;
    public $key;

    public function __construct(ParseSpan $span, AST $obj, AST $key)
    {
        parent::__construct($span);
        $this->obj = $obj;
        $this->key = $key;
    }

    public function visit(AstVisitor $visitor, $context = null)
    {
        return $visitor->visitKeyedRead($this, $context);
    }
}