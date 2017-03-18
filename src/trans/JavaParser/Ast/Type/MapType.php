<?php


namespace trans\JavaParser\Ast\Type;


use trans\JavaParser\Ast\Type;
use trans\JavaParser\Ast\TypeVisitor;

class MapType extends Type
{
    public $valueType;

    public function __construct(Type $valueType, array $modifiers = null)
    {
        parent::__construct($modifiers);
        $this->valueType = $valueType;
    }

    public function visitType(TypeVisitor $visitor, $context)
    {
        return $visitor->visitMapType($this, $context);
    }
}