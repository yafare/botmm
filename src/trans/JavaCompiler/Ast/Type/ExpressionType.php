<?php


namespace trans\JavaCompiler\Ast\Type;


use trans\JavaCompiler\Ast\Type;
use trans\JavaCompiler\Ast\TypeVisitor;

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