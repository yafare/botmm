<?php


namespace trans\JavaCompiler\Output\Type;



use trans\JavaCompiler\Output\BuiltinTypeName;
use trans\JavaCompiler\Output\Type;
use trans\JavaCompiler\Output\TypeVisitor;

class BuiltinType extends Type
{
    public $name;

    public function __construct(BuiltinTypeName $name, array $modifiers = null)
    {
        parent::__construct($modifiers);
        $this->name=$name;
    }

    public function visitType(TypeVisitor $visitor, $context)
    {
        return $visitor->visitBuiltintType($this, $context);
    }
}