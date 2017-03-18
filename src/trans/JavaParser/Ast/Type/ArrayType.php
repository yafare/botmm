<?php


namespace trans\JavaCompiler\Ast\Type;


use trans\JavaCompiler\Ast\Type;
use trans\JavaCompiler\Ast\TypeVisitor;

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