<?php


namespace trans\JavaCompiler\Output\Expression;


use trans\JavaCompiler\Ast\ParseSourceSpan;
use trans\JavaCompiler\Ast\Statement\DeclareVarStmt;
use trans\JavaCompiler\Output\Expression;
use trans\JavaCompiler\Output\ExpressionVisitor;
use trans\JavaCompiler\Output\Type;

class WriteVarExpr extends Expression
{
    public $value;
    public $name;

    public function __construct(string $name, Expression $value, Type $type = null, ParseSourceSpan $sourceSpan)
    {
        parent::__construct(isset($type) ? $type : $value->type, $sourceSpan);
        $this->value = $value;
        $this->name = $name;
    }

    public function visitExpression(ExpressionVisitor $visitor, $context)
    {
        return $visitor->visitWriteVarExpr($this, $context);
    }

    public function toDeclStmt(Type $type = null, array $modifiers = null): DeclareVarStmt
    {
        return new DeclareVarStmt($this->name, $this->value, $type, $modifiers, $this->sourceSpan);
    }
}