<?php


namespace trans\JavaCompiler\Output\ClassPart;


use trans\JavaCompiler\Output\AbstractClassPart;
use trans\JavaCompiler\Output\Type;

class ClassField extends AbstractClassPart
{
    public $name;

    public function __construct(string $name, Type $type = null, array $modifiers = null)
    {
        parent::__construct($type, $modifiers);
        $this->name = $name;
    }
}