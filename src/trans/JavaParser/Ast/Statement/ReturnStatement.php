<?php


namespace trans\JavaParser\Ast\Statement;


use trans\JavaParser\Ast\ParseSourceSpan;
use trans\JavaParser\Output\Expression;
use trans\JavaParser\Output\StatementVisitor;

class ReturnStatement extends Statement
{
    public $value;

    public function __construct(Expression $value, ParseSourceSpan $sourceSpan)
    {
        parent::__construct(null, $sourceSpan);
        $this->value=$value;
    }

    public function visitStatement(StatementVisitor $visitor, $context)
    {
        return $visitor->visitReturnStmt($this, $context);
    }
}