<?php


namespace trans\JavaCompiler\Ast\Statement;


use trans\JavaCompiler\Output\StatementVisitor;

class LocalClassDeclarationStmt extends Statement
{

    public function visitStatement(StatementVisitor $visitor, $context)
    {
        $visitor->visitLocalClassDeclarationStmt($this, $context);
    }
}