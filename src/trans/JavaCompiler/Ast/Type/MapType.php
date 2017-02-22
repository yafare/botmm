<?php


namespace trans\JavaCompiler\Output\Type;


use trans\JavaCompiler\Output\Type;
use trans\JavaCompiler\Output\TypeVisitor;

class MapType extends Type
{
    public $valueType;

    public function __construct(Type $valueType, array $modifiers = null)
    {
        parent::__construct($modifiers);
        $this->valueType=$valueType;
    }

    public function visitType(TypeVisitor $visitor, $context)
    {
        return $visitor->visitMapType($this, $context);
    }
}