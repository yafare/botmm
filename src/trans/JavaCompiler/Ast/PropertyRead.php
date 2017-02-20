<?php


namespace trans\JavaCompiler\Ast;


class PropertyRead extends AST
{
    public $receiver;
    public $name;

    public function __construct(ParseSpan $span, AST $receiver, string $name)
    {
        parent::__construct($span);
        $this->receiver = $receiver;
        $this->name = $name;
    }

    public function visit(AstVisitor $visitor, $context = null)
    {
        return $visitor->visitPropertyRead($this, $context);
    }
}