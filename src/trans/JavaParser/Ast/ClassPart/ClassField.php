<?php


namespace trans\JavaParser\Output\ClassPart;


use trans\JavaParser\Output\AbstractClassPart;
use trans\JavaParser\Output\Type;

class ClassField extends AbstractClassPart
{
    public $name;

    public function __construct(string $name, Type $type = null, array $modifiers = null)
    {
        parent::__construct($type, $modifiers);
        $this->name = $name;
    }
}