<?php


namespace trans\JavaCompiler\Ast;


class SafeMethodCall extends AST
{
    public $receiver;
    public $name;
    public $args;

    public function __construct(ParseSpan $span, AST $receiver, string $name, array $args)
    {
        parent::__construct($span);
        $this->receiver = $receiver;
        $this->name = $name;
        $this->args = $args;
    }

    public function visit(AstVisitor $visitor, $context = null)
    {
        return $visitor->visitSafeMethodCall($this, $context);
    }
}

