<?php


namespace trans\JavaCompiler\Output\Expression;


use trans\JavaCompiler\Output\Expression;
use trans\JavaCompiler\Output\ExpressionVisitor;

class LiteralArrayExpr extends Expression
{
    public $entries;

    public function __construct(array $entries, Type $type = null, ParseSourceSpan $sourceSpan)
    {
        parent::__construct($type, $sourceSpan);
        $this->entries = $entries;
    }

    public function visitExpression(ExpressionVisitor $visitor, $context)
    {
        return $visitor->visitLiteralArrayExpr($this, $context);
    }
}