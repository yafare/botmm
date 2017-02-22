<?php


namespace trans\JavaCompiler\Ast\Statement;


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