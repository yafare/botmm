<?php


namespace trans\JavaCompiler\Ast\Statement;


use trans\JavaCompiler\Output\StatementVisitor;

class BlockStmt extends Statement
{

    public function visitStatement(StatementVisitor $visitor, $context)
    {
        $visitor->visitBlockStmt($this, $context);
    }
}