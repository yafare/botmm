<?php


namespace trans\JavaParser\Output\Expression;


class FunctionExpr extends Expression
{
    public $params;
    public $statements;

    public function __construct(
        array $params, array $statements, Type $type = null,
        ParseSourceSpan $sourceSpan)
    {
        parent::__construct($type, $sourceSpan);
        $this->params=$params;
        $this->statements=$statements;
    }

    public function visitExpression(ExpressionVisitor $visitor, $context)
    {
        return $visitor->visitFunctionExpr($this, $context);
    }

    public function toDeclStmt(string $name, array $modifiers = null): DeclareFunctionStmt
    {
        return new DeclareFunctionStmt(
            $name, $this->params, $this->statements, $this->type, $modifiers, $this->sourceSpan);
    }
}