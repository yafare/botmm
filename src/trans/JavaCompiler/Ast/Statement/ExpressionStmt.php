<?php


namespace trans\JavaCompiler\Ast\Statement;


use trans\JavaCompiler\Ast\ParseSourceSpan;
use trans\JavaCompiler\Output\Expression;
use trans\JavaCompiler\Output\StatementVisitor;

class ExpressionStmt extends Statement
{
    public $expr;

    public function __construct(Expression $expr, ParseSourceSpan $sourceSpan)
    {
        parent::__construct(null, $sourceSpan);
        $this->expr = $expr;
    }

    public function visitStatement(StatementVisitor $visitor, $context)
    {
        return $visitor->visitExpressionStmt($this, $context);
    }
}