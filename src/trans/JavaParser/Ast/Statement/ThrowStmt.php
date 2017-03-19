<?php


namespace trans\JavaParser\Ast\Statement;


use trans\JavaParser\Ast\ParseSourceSpan;
use trans\JavaParser\Output\Expression;
use trans\JavaParser\Output\StatementVisitor;

class ThrowStmt extends Statement
{
    public $error;

    public function __construct(Expression $error, ParseSourceSpan $sourceSpan)
    {
        parent::__construct($sourceSpan, null);
        $this->error = $error;
    }

    public function visitStatement(StatementVisitor $visitor, $context)
    {
        return $visitor->visitThrowStmt($this, $context);
    }
}