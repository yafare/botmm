<?php


namespace trans\JavaCompiler\Output\Expression;


use trans\JavaCompiler\Ast\ParseSourceSpan;
use trans\JavaCompiler\Output\Expression;
use trans\JavaCompiler\Output\ExpressionVisitor;
use trans\JavaCompiler\Output\Type;

class ReadVarExpr extends Expression
{
    public $name;
    public $builtin;

    public function __construct($name, Type $type = null, ParseSourceSpan $sourceSpan = null)
    {
        parent::__construct($type, $sourceSpan);
        if (gettype($name)  === 'string') {
            $this->name = $name;
            $this->builtin = null;
        } else {
            $this->name = null;
            $this->builtin = /*<BuiltinVar > */$name;
    }
    }

    public function visitExpression(ExpressionVisitor $visitor, $context)
    {
        return $visitor->visitReadVarExpr($this, $context);
    }

    public function set(Expression $value): WriteVarExpr
    {
        return new WriteVarExpr($this->name, $value, null, $this->sourceSpan);
    }
}