<?php


namespace trans\JavaCompiler\Ast\Statement;


use trans\JavaCompiler\Output\StatementVisitor;

class SwitchStmt extends Statement
{

    public function visitStatement(StatementVisitor $visitor, $context)
    {
        $visitor->visitSwitchStmt($this, $context);
    }
}