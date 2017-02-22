<?php


namespace trans\JavaCompiler\Ast\Expr;


use trans\JavaCompiler\Ast\AST;
use trans\JavaCompiler\Ast\AstVisitor;
use trans\JavaCompiler\Ast\ParseSpan;

class Name extends AST
{

    public $qualifier;
    public $identifier;

    public function __construct(ParseSpan $span, Name $qualifier, string $identifier)
    {
        parent::__construct($span);
    }

    public function visit(AstVisitor $visitor, $context = null)
    {
        return parent::visit($visitor, $context);
    }
}