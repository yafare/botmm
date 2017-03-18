<?php


namespace trans\JavaParser\Ast\Statement;


use trans\JavaParser\Ast\ParseSourceSpan;
use trans\JavaParser\Output\Expression;
use trans\JavaParser\Output\StatementVisitor;

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