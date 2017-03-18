<?php


namespace trans\JavaParser\Ast\Type;


use trans\JavaParser\Ast\Type;
use trans\JavaParser\Ast\TypeVisitor;

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