<?php


namespace trans\JavaCompiler\Output\Expression;


class InvokeFunctionExpr extends Expression
{
    public $fn;
    public $args;

    public function __construct(
        Expression $fn, array $args, Type $type = null,
        ParseSourceSpan $sourceSpan)
    {
        parent::__construct($type, $sourceSpan);
        $this->fn=$fn;
        $this->args=$args;
    }

    public function visitExpression(ExpressionVisitor $visitor, $context)
    {
        return $visitor->visitInvokeFunctionExpr($this, $context);
    }
}