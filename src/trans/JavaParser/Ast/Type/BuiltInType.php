<?php


namespace trans\JavaParser\Ast\Type;


use trans\JavaParser\Ast\Type;
use trans\JavaParser\Ast\TypeVisitor;

class BuiltinType extends Type
{
    public $name;

    public function __construct(string $name, array $modifiers = null)
    {
        parent::__construct($modifiers);
        $this->name = $name;
    }

    public function visitType(TypeVisitor $visitor, $context)
    {
        return $visitor->visitBuiltintType($this, $context);
    }
}