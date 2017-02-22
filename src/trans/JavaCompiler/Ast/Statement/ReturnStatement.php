<?php


namespace trans\JavaCompiler\Ast\Statement;


use trans\JavaCompiler\Ast\ParseSourceSpan;
use trans\JavaCompiler\Output\Expression;
use trans\JavaCompiler\Output\StatementVisitor;

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