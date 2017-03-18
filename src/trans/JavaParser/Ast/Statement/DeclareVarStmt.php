<?php


namespace trans\JavaCompiler\Ast\Statement;


use trans\JavaCompiler\Ast\ParseSourceSpan;
use trans\JavaCompiler\Output\Expression;
use trans\JavaCompiler\Output\StatementVisitor;
use trans\JavaCompiler\Output\Type;

class DeclareVarStmt extends Statement
{
    public $type;
    public $name;
    public $value;

    public function __construct(
        string $name, Expression $value, Type $type = null,
        array $modifiers = null, ParseSourceSpan $sourceSpan)
    {
        parent::__construct($modifiers, $sourceSpan);
        $this->type = isset($type) ? $type : $value->type;
        $this->name = $name;
        $this->value = $value;
    }

    public function visitStatement(StatementVisitor $visitor, $context)
    {
        return $visitor->visitDeclareVarStmt($this, $context);
    }
}