<?php


namespace trans\JavaParser\Output\Expression;


use trans\JavaParser\Output\Expression;
use trans\JavaParser\Output\ExpressionVisitor;

class NotExpr extends Expression
{
    public $condition;

    public function __construct(Expression $condition, ParseSourceSpan $sourceSpan)
    {
        parent::__construct(BOOL_TYPE, $sourceSpan);
        $this->condition=$condition;
    }

    public function visitExpression(ExpressionVisitor $visitor, $context)
    {
        return $visitor->visitNotExpr($this, $context);
    }
}