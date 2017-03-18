<?php


namespace trans\JavaParser\Output\Expression;


class ExternalExpr extends Expression
{
    public $value;
    public $typeParams;

    public function __construct(
        CompileIdentifierMetadata $value, Type $type = null, array $typeParams = null,
        ParseSourceSpan $sourceSpan)
    {
        parent::__construct($type, $sourceSpan);
        $this->value=$value;
        $this->typeParams=$typeParams;
    }

    public function visitExpression(ExpressionVisitor $visitor, $context)
    {
        return $visitor->visitExternalExpr($this, $context);
    }
}