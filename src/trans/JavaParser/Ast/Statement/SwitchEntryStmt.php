<?php


namespace trans\JavaParser\Ast\Statement;


use trans\JavaParser\Output\StatementVisitor;

class SwitchEntryStmt extends Statement
{

    public function visitStatement(StatementVisitor $visitor, $context)
    {
        $visitor->visitSwitchEntryStmt($this, $context);
    }
}