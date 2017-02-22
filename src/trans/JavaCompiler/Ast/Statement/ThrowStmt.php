<?php


namespace trans\JavaCompiler\Ast\Statement;


use trans\JavaCompiler\Ast\ParseSourceSpan;
use trans\JavaCompiler\Output\Expression;
use trans\JavaCompiler\Output\StatementVisitor;

class ThrowStmt extends Statement
{
    public $error;

    public function __construct(Expression $error, ParseSourceSpan $sourceSpan)
    {
        parent::__construct(null, $sourceSpan);
        $this->error = $error;
    }

    public function visitStatement(StatementVisitor $visitor, $context)
    {
        return $visitor->visitThrowStmt($this, $context);
    }
}