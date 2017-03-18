<?php


namespace trans\JavaParser\Ast\Type;


use trans\JavaParser\Ast\Type;
use trans\JavaParser\Ast\TypeVisitor;

class ArrayType extends Type
{
    public $of;

    public function __construct(Type $of, array $modifiers = null)
    {
        parent::__construct($modifiers);
        $this->of=$of;
    }

    public function visitType(TypeVisitor $visitor, $context)
    {
        return $visitor->visitArrayType($this, $context);
    }
}