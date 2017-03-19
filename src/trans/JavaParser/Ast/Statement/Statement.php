<?php


namespace trans\JavaParser\Ast\Statement;


use trans\JavaParser\Ast\AST;
use trans\JavaParser\Ast\AstVisitor;
use trans\JavaParser\Ast\StmtModifier;
use trans\JavaParser\Output\StatementVisitor;
use trans\JavaParser\Wrapper\ArrayWrapper;

abstract class Statement extends AST
{
    /**
     * @var StmtModifier[]
     */
    public $modifiers;
    /**
     * @var ParseSourceSpan
     */
    public $sourceSpan;

    public function __construct($sourceSpan, $modifiers = null)
    {
        parent::__construct($sourceSpan);
        $this->modifiers  = $modifiers;
        $this->sourceSpan = $sourceSpan;
        if (!$modifiers) {
            $this->modifiers = [];
        }
    }

    public function visit(AstVisitor $visitor, $context = null)
    {
        $this->visitStatement($visitor, $context);
    }

    public abstract function visitStatement(StatementVisitor $visitor, $context);

    public function hasModifier(StmtModifier $modifier): bool
    {
        return ArrayWrapper::indexOf($this->modifiers, $modifier) !== -1;
    }
}







