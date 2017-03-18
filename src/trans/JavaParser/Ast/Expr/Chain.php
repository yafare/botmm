<?php


namespace trans\JavaParser\Ast\Expr;


use trans\JavaParser\Ast\AST;
use trans\JavaParser\Ast\AstVisitor;
use trans\JavaParser\Ast\ParseSpan;


/**
 * Multiple expressions separated by a semicolon.
 */
class Chain extends AST
{
    public $expressions;

    public function __construct(ParseSpan $span, array $expressions)
    {
        parent::__construct($span);
    }

    public function visit(AstVisitor $visitor, $context = null)
    {
        return $visitor->visitChain($this, $context);
    }
}
