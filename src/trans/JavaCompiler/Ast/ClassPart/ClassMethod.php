<?php


namespace trans\JavaCompiler\Output\ClassPart;


use trans\JavaCompiler\Output\AbstractClassPart;
use trans\JavaCompiler\Output\Type;

class ClassMethod extends AbstractClassPart
{
    public $name;
    public $params;
    public $body;

    public function __construct(
        string $name,
        array $params,
        array $body,
        Type $type = null,
        array $modifiers = null
    ) {
        parent::__construct($type, $modifiers);
        $this->name   = $name;
        $this->params = $params;
        $this->body   = $body;
    }
}