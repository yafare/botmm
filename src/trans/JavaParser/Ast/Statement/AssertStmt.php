<?php


namespace trans\JavaCompiler\Ast\Statement;


use trans\JavaCompiler\Output\StatementVisitor;

class AssertStmt extends Statement
{

    public function visitStatement(StatementVisitor $visitor, $context)
    {
        $visitor->visitAssertStmt($this, $context);
    }
}