<?php


namespace trans\JavaParser\Ast\Expr;


use trans\JavaParser\Ast\AST;
use trans\JavaParser\Ast\AstVisitor;
use trans\JavaParser\Ast\ParseSpan;

class Name extends AST
{

    public $qualifier;
    public $identifier;

    public function __construct(ParseSpan $span, ?Name $qualifier, string $identifier)
    {
        parent::__construct($span);
        $this->qualifier  = $qualifier;
        $this->identifier = $identifier;
    }

    public function visit(AstVisitor $visitor, $context = null)
    {
        return $visitor->visitName($this, $context);
    }
}