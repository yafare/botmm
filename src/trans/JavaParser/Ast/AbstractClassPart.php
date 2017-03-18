<?php


namespace trans\JavaParser\Output;


class AbstractClassPart
{
    public $type;
    public $modifiers;

    public function __construct(Type $type = null, array $modifiers)
    {
        if (!$modifiers) {
            $this->modifiers = [];
        }
        $this->type      = $type;
        $this->modifiers = $modifiers;
    }

    public function hasModifier(StmtModifier $modifier): boolean
    {
        return $this->modifiers . indexOf($modifier) !== -1;
    }
}