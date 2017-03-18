<?php


namespace trans\JavaParser\Output\Expression;


use trans\JavaParser\Ast\ParseSourceSpan;
use trans\JavaParser\Output\Expression;
use trans\JavaParser\Output\ExpressionVisitor;
use trans\JavaParser\Output\Type;

class WriteKeyExpr extends Expression
{
    public $value;
    public $receiver;
    public $index;

    public function __construct( Expression $receiver, Expression $index, Expression $value, Type $type = null,ParseSourceSpan $sourceSpan)
    {
        parent::__construct(isset($type) ? $type : $value->type, $sourceSpan);
        $this->value = $value;
        $this->receiver=$receiver;
        $this->index=$index;
    }

    public function visitExpression(ExpressionVisitor $visitor, $context)
    {
        return $visitor->visitWriteKeyExpr($this, $context);
    }
}