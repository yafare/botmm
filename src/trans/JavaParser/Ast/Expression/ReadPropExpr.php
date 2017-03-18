<?php


namespace trans\JavaCompiler\Output\Expression;


use trans\JavaCompiler\Ast\ParseSourceSpan;
use trans\JavaCompiler\Output\Expression;
use trans\JavaCompiler\Output\ExpressionVisitor;
use trans\JavaCompiler\Output\Type;

class ReadPropExpr extends Expression
{
    public $receiver;
    public $name;

    public function __construct(
        Expression $receiver, string $name, Type $type = null,
        ParseSourceSpan $sourceSpan)
    {
        parent::__construct($type, $sourceSpan);
        $this->receiver=$receiver;
        $this->name=$name;
    }

    public function visitExpression(ExpressionVisitor $visitor, $context)
    {
        return $visitor->visitReadPropExpr($this, $context);
    }

    public function set(Expression $value): WritePropExpr
    {
        return new WritePropExpr($this->receiver, $this->name, $value, null, $this->sourceSpan);
    }
}