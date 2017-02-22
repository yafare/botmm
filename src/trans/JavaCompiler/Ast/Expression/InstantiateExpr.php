<?php


namespace trans\JavaCompiler\Output\Expression;


class InstantiateExpr extends Expression
{
    public $classExpr;
    public $args;

    public function __construct(
        Expression $classExpr, array $args, Type $type,
        ParseSourceSpan $sourceSpan)
    {
        parent::__construct($type, $sourceSpan);
        $this->classExpr=$classExpr;
        $this->args=$args;
    }

    public function visitExpression(ExpressionVisitor $visitor, $context)
    {
        return $visitor->visitInstantiateExpr($this, $context);
    }
}