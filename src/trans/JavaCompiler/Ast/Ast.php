<?php


namespace trans\JavaCompiler\Ast;


class AST
{
    /**
     * @var ParseSpan
     */
    public $span;

    public function __construct(ParseSpan $span)
    {
        $this->span = $span;

    }

    public function visit(AstVisitor $visitor, $context = null)
    {
        return null;
    }

    public function toString(): string
    {
        return 'AST';
    }
}
