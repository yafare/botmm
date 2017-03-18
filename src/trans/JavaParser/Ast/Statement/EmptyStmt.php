<?php


namespace trans\JavaParser\Ast\Statement;


use trans\JavaParser\Output\StatementVisitor;

class EmptyStmt extends Statement
{

    public function visitStatement(StatementVisitor $visitor, $context)
    {
        $visitor->visitEmptyStmt($this, $context);
    }
}