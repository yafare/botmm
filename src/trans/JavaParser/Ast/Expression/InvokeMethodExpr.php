<?php


namespace trans\JavaCompiler\Output\Expression;


use trans\JavaCompiler\Output\Expression;
use trans\JavaCompiler\Output\ExpressionVisitor;

class InvokeMethodExpr extends Expression
{
    public $name;
    public $builtin;
    public $receiver;
    public $method;
    public $args;

    public function __construct(Expression $receiver, $method, array $args, Type $type = null, ParseSourceSpan $sourceSpan)
    {
        parent::__construct($type, $sourceSpan);
        if (gettype($method) === 'string') {
            $this->name = $method;
            $this->builtin = null;
        } else {
            $this->name = null;
            $this->builtin =/*<BuiltinMethod >  */$method;
         }
        $this->receiver=$receiver;
        $this->method=$method;
        $this->args=$args;
    }

    public function visitExpression(ExpressionVisitor $visitor, $context)
    {
        return $visitor->visitInvokeMethodExpr($this, $context);
    }
}