<?php


namespace trans\JavaCompiler\Ast\Statement;


use trans\JavaCompiler\Output\StatementVisitor;
use trans\JavaCompiler\Wrapper\ArrayWrapper;

abstract class Statement
{
    /**
     * @var StmtModifier[]
     */
    public $modifiers;
    /**
     * @var ParseSourceSpan
     */
    public $sourceSpan;

    public function __construct($modifiers, $sourceSpan = null)
    {
        $this->modifiers  = $modifiers;
        $this->sourceSpan = $sourceSpan;
        if (!$modifiers) {
            $this->modifiers = [];
        }
    }

    public abstract function visitStatement(StatementVisitor $visitor, $context);

    public function hasModifier(StmtModifier $modifier): bool
    {
        return ArrayWrapper::indexOf($this->modifiers, $modifier) !== -1;
    }
}







