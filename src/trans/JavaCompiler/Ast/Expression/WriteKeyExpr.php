<?php


namespace trans\JavaCompiler\Output\Expression;


use trans\JavaCompiler\Ast\ParseSourceSpan;
use trans\JavaCompiler\Output\Expression;
use trans\JavaCompiler\Output\ExpressionVisitor;
use trans\JavaCompiler\Output\Type;

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