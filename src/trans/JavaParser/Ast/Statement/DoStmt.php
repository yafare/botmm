<?php


namespace trans\JavaParser\Ast\Statement;


use trans\JavaParser\Output\StatementVisitor;

class DoStmt extends Statement
{

    public function visitStatement(StatementVisitor $visitor, $context)
    {
        $visitor->visitDoStmt($this, $context);
    }
}