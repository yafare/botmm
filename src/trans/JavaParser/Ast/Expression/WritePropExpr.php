<?php


namespace trans\JavaParser\Output\Expression;


use trans\JavaParser\Output\Expression;
use trans\JavaParser\Output\ExpressionVisitor;

class WritePropExpr extends Expression
{
    public $value;
    public $receiver;
    public $name;

    public function __construct(Expression $receiver, string $name, Expression $value, Type $type = null,ParseSourceSpan $sourceSpan)
    {
        parent::__construct(isset($type) ? $type : $value->type, $sourceSpan);
        $this->value = $value;
        $this->receiver=$receiver;
        $this->name=$name;
    }

    public function visitExpression(ExpressionVisitor $visitor, $context)
    {
        return $visitor->visitWritePropExpr($this, $context);
    }
}