<?php


namespace trans\JavaParser\Ast\Statement;


use trans\JavaParser\Ast\ParseSourceSpan;
use trans\JavaParser\Output\Expression;
use trans\JavaParser\Output\StatementVisitor;
use trans\JavaParser\Output\Type;

class DeclareVarStmt extends Statement
{
    public $type;
    public $name;
    public $value;

    public function __construct(
        string $name, Expression $value, Type $type = null,
        array $modifiers = null, ParseSourceSpan $sourceSpan)
    {
        parent::__construct($sourceSpan, $modifiers);
        $this->type = isset($type) ? $type : $value->type;
        $this->name = $name;
        $this->value = $value;
    }

    public function visitStatement(StatementVisitor $visitor, $context)
    {
        return $visitor->visitDeclareVarStmt($this, $context);
    }
}
