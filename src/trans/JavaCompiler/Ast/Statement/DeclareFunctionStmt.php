<?php


namespace trans\JavaCompiler\Ast\Statement;


use trans\JavaCompiler\Ast\ParseSourceSpan;
use trans\JavaCompiler\Output\StatementVisitor;
use trans\JavaCompiler\Output\Type;

class DeclareFunctionStmt extends Statement
{
    public $name;
    public $params;
    public $statements;
    public $type;

    public function __construct(
        string $name, array $params, array $statements,
        Type $type = null, array $modifiers = null, ParseSourceSpan $sourceSpan)
    {
        parent::__construct($modifiers, $sourceSpan);
        $this->name=$name;
        $this->params=$params;
        $this->statements=$statements;
        $this->type=$type;

    }

    public function visitStatement(StatementVisitor $visitor, $context)
    {
        return $visitor->visitDeclareFunctionStmt($this, $context);
    }
}