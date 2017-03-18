<?php


namespace trans\JavaParser\Output\Expression;


use trans\JavaParser\Ast\ParseSourceSpan;
use trans\JavaParser\Output\Expression;
use trans\JavaParser\Output\ExpressionVisitor;
use trans\JavaParser\Output\Type;

class ReadKeyExpr extends Expression
{
    public $receiver;
    public $index;

    public function __construct(
        Expression $receiver, Expression $index, Type $type = null,
        ParseSourceSpan $sourceSpan)
    {
        parent::__construct($type, $sourceSpan);
        $this->receiver=$receiver;
        $this->index=$index;
    }

    public function visitExpression(ExpressionVisitor $visitor, $context)
    {
        return $visitor->visitReadKeyExpr($this, $context);
    }

    public function set(Expression $value): WriteKeyExpr
    {
        return new WriteKeyExpr($this->receiver, $this->index, $value, null, $this->sourceSpan);
    }
}