<?php


namespace trans\JavaParser\Ast\Expr;


use trans\JavaParser\Ast\AST;
use trans\JavaParser\Ast\AstVisitor;
use trans\JavaParser\Ast\ParseSpan;


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
