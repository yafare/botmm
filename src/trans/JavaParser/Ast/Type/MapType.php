<?php


namespace trans\JavaCompiler\Ast\Type;


use trans\JavaCompiler\Ast\Type;
use trans\JavaCompiler\Ast\TypeVisitor;

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