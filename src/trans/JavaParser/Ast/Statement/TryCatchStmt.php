<?php


namespace trans\JavaParser\Ast\Statement;


use trans\JavaParser\Ast\ParseSourceSpan;
use trans\JavaParser\Output\StatementVisitor;

class TryCatchStmt extends Statement
{
    public $bodyStmts;
    public $catchStmts;

    public function __construct(
        array $bodyStmts,
        array $catchStmts,
        ParseSourceSpan $sourceSpan
    ) {
        parent::__construct($sourceSpan, null);
        $this->bodyStmts  = $bodyStmts;
        $this->catchStmts = $catchStmts;
    }

    public function visitStatement(StatementVisitor $visitor, $context)
    {
        return $visitor->visitTryCatchStmt($this, $context);
    }
}
