<?php


namespace trans\JavaParser\Output\Expression;


class BinaryOperatorExpr extends Expression
{
    public $lhs;
    public $operator;
    public $rhs;

    public function __construct(
        BinaryOperator $operator, Expression $lhs, Expression $rhs, Type $type = null,
        ParseSourceSpan $sourceSpan)
    {
        parent::__construct(isset($type) ? $type : $lhs->type, $sourceSpan);
        $this->lhs = $lhs;
        $this->operator=$operator;
        $this->rhs=$rhs;
    }

    public function visitExpression(ExpressionVisitor $visitor, $context)
    {
        return $visitor->visitBinaryOperatorExpr($this, $context);
    }
}