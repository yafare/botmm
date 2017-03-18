<?php


namespace trans\JavaCompiler\Output\Expression;


use trans\JavaCompiler\Output\Expression;
use trans\JavaCompiler\Output\ExpressionVisitor;

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