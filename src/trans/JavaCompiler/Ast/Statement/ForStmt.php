<?php


namespace trans\JavaCompiler\Ast\Statement;


use trans\JavaCompiler\Output\StatementVisitor;

class ForStmt extends Statement
{

    public function visitStatement(StatementVisitor $visitor, $context)
    {
        $visitor->visitForStmt($this, $context);
    }
}