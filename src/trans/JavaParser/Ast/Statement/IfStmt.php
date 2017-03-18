<?php


namespace trans\JavaCompiler\Ast\Statement;


use trans\JavaCompiler\Ast\ParseSourceSpan;
use trans\JavaCompiler\Output\Expression;
use trans\JavaCompiler\Output\StatementVisitor;

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
        parent::__construct(null, $sourceSpan);
        $this->condition = $condition;
        $this->trueCase  = $trueCase;
        $this->falseCase = $falseCase;
    }

    public function visitStatement(StatementVisitor $visitor, $context)
    {
        return $visitor->visitIfStmt($this, $context);
    }
}