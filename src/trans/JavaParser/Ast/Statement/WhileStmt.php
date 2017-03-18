<?php


namespace trans\JavaParser\Ast\Statement;


use trans\JavaParser\Output\StatementVisitor;

class WhileStmt extends Statement
{

    public function visitStatement(StatementVisitor $visitor, $context)
    {
        $visitor->visitWhileStmt($this, $context);
    }
}