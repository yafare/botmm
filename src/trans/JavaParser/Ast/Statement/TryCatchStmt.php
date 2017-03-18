<?php


namespace trans\JavaCompiler\Ast\Statement;


use trans\JavaCompiler\Ast\ParseSourceSpan;
use trans\JavaCompiler\Output\StatementVisitor;

class TryCatchStmt extends Statement
{
    public $bodyStmts;
    public $catchStmts;

    public function __construct(
        array $bodyStmts,
        array $catchStmts,
        ParseSourceSpan $sourceSpan
    ) {
        parent::__construct(null, $sourceSpan);
        $this->bodyStmts  = $bodyStmts;
        $this->catchStmts = $catchStmts;
    }

    public function visitStatement(StatementVisitor $visitor, $context)
    {
        return $visitor->visitTryCatchStmt($this, $context);
    }
}