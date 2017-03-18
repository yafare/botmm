<?php


namespace trans\JavaParser\Output\Visitor;


class _ReplaceVariableTransformer extends ExpressionTransformer
{
    private $name;
    private $value;

    public function __construct(_varstring $name, _newExpression $value)
    {
        parent::__construct();
        $this->name  = $name;
        $this->value = $value;
    }

    public function visitReadVarExpr(ReadVarExpr $ast, $context)
    {
        return $ast->name == $this->_varName ? $this->_newValue : $ast;
    }
}