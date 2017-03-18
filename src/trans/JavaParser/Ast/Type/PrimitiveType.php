<?php


namespace trans\JavaParser\Ast\Type;


use trans\JavaParser\Ast\Type;
use trans\JavaParser\Ast\TypeVisitor;

class PrimitiveType extends Type
{

    public function __construct(array $modifiers = null)
    {
        parent::__construct($modifiers);
    }

    public function visitType(TypeVisitor $visitor, $context)
    {

    }
}