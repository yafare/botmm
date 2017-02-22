<?php


namespace trans\JavaCompiler\Output\Type;


use trans\JavaCompiler\Output\Expression;
use trans\JavaCompiler\Output\Type;
use trans\JavaCompiler\Output\TypeVisitor;

class ExpressionType extends Type
{
    public $value;

    public function __construct(Expression $value, array $modifiers = null)
    {
        parent::__construct($modifiers);
        $this->value=$value;
    }

    public function visitType(TypeVisitor $visitor, $context)
    {
        return $visitor->visitExpressionType($this, $context);
    }
}