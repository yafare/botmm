<?php


namespace trans\JavaCompiler\Output\Expression;

use trans\JavaCompiler\Output\Expression;

class CastExpr extends Expression
{
    public $value;

    public function __construct(Expression $value, Type $type, ParseSourceSpan $sourceSpan)
    {
        parent::__construct($type, $sourceSpan);
        $this->value=$value;
    }

    public function visitExpression(ExpressionVisitor $visitor, $context)
    {
        return $visitor->visitCastExpr($this, $context);
    }
}