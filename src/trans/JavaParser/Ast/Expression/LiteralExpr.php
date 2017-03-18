<?php


namespace trans\JavaCompiler\Output\Expression;


use trans\JavaCompiler\Output\Expression;
use trans\JavaCompiler\Output\ExpressionVisitor;

class LiteralExpr extends Expression
{
    public $value;

    public function __construct($value, Type $type = null, ParseSourceSpan $sourceSpan)
    {
        parent::__construct($type, $sourceSpan);
        $this->value=$value;
    }

    public function visitExpression(ExpressionVisitor $visitor, $context)
    {
        return $visitor->visitLiteralExpr($this, $context);
    }
}