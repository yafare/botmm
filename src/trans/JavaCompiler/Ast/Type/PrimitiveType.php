<?php


namespace trans\JavaCompiler\Ast\Type;


use trans\JavaCompiler\Ast\Type;
use trans\JavaCompiler\Ast\TypeVisitor;

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