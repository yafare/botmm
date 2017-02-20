<?php


namespace trans\JavaCompiler\Ast\Expr;


use trans\JavaCompiler\Ast\AST;
use trans\JavaCompiler\Ast\AstVisitor;
use trans\JavaCompiler\Ast\ParseSpan;


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
