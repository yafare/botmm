<?php


namespace trans\JavaCompiler\Ast\Expr;


use trans\JavaCompiler\Ast\AST;
use trans\JavaCompiler\Ast\AstVisitor;
use trans\JavaCompiler\Ast\ParseSpan;


class SafePropertyRead extends AST
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
        return $visitor->visitSafePropertyRead($this, $context);
    }
}