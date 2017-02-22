<?php


namespace trans\JavaCompiler\Output\Type;


use trans\JavaCompiler\Output\Type;
use trans\JavaCompiler\Output\TypeVisitor;

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