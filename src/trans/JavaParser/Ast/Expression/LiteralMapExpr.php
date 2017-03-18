<?php


namespace trans\JavaParser\Output\Expression;


use trans\JavaParser\Output\Expression;
use trans\JavaParser\Output\ExpressionVisitor;

class LiteralMapExpr extends Expression
{
    public $type = null;
    public $entries;
    private $valueType;

    public function __construct(
        array $entries, MapType $type = null, ParseSourceSpan $sourceSpan)
    {
        parent::__construct($type, $sourceSpan);
        if (isset($type)) {
            $this->valueType = $type->valueType;
        }
        $this->type = $type;
        $this->entries = $entries;

    }

    public function visitExpression(ExpressionVisitor $visitor, $context)
    {
        return $visitor->visitLiteralMapExpr($this, $context);
    }
}