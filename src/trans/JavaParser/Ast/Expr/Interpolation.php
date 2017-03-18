<?php


namespace trans\JavaCompiler\Ast\Expr;


use trans\JavaCompiler\Ast\AST;
use trans\JavaCompiler\Ast\AstVisitor;
use trans\JavaCompiler\Ast\ParseSpan;


class Interpolation extends AST
{
    public $strings;
    public $expressions;

    public function __construct(ParseSpan $span, array $strings, array $expressions)
    {
        parent::__construct($span);
        $this->strings = $strings;
        $this->expressions = $expressions;
    }

    public function visit(AstVisitor $visitor, $context = null)
    {
        return $visitor->visitInterpolation($this, $context);
    }
}