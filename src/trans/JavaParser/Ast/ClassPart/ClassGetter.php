<?php


namespace trans\JavaParser\Output\ClassPart;


use trans\JavaParser\Output\AbstractClassPart;
use trans\JavaParser\Output\Type;

class ClassGetter extends AbstractClassPart
{
    public $name;
    public $body;

    public function __construct(
        string $name,
        array $body,
        Type $type = null,
        array $modifiers = null
    ) {
        parent::__construct($type, $modifiers);
        $this->name = $name;
        $this->body = $body;
    }
}
