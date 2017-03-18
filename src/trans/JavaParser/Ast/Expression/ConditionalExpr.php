<?php


namespace trans\JavaCompiler\Output\Expression;


class ConditionalExpr extends Expression
{
    public $trueCase;
    public $condition;
    public $falseCase;

    public function __construct(
        Expression $condition, Expression $trueCase, Expression $falseCase = null,
        Type $type = null, ParseSourceSpan $sourceSpan)
    {
        parent::__construct(isset($type) ? $type : $trueCase->type, $sourceSpan);
        $this->trueCase = $trueCase;
        $this->condition=$condition;
        $this->falseCase=$falseCase;
    }

    public function visitExpression(ExpressionVisitor $visitor, $context)
    {
        return $visitor->visitConditionalExpr($this, $context);
    }
}