<?php


namespace trans\JavaParser\Ast\Statement;


use trans\JavaParser\Ast\ParseSourceSpan;
use trans\JavaParser\Output\Expression;
use trans\JavaParser\Output\StatementVisitor;

class IfStmt extends Statement
{
    public $condition;
    public $trueCase;
    public $falseCase;

    public function __construct(
        Expression $condition,
        array $trueCase,
        array $falseCase = [],
        ParseSourceSpan $sourceSpan
    ) {
        parent::__construct($sourceSpan, null);
        $this->condition = $condition;
        $this->trueCase  = $trueCase;
        $this->falseCase = $falseCase;
    }

    public function visitStatement(StatementVisitor $visitor, $context)
    {
        return $visitor->visitIfStmt($this, $context);
    }
}