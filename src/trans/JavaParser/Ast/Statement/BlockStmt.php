<?php


namespace trans\JavaParser\Ast\Statement;


use trans\JavaParser\Output\StatementVisitor;

class BlockStmt extends Statement
{

    public function visitStatement(StatementVisitor $visitor, $context)
    {
        $visitor->visitBlockStmt($this, $context);
    }
}