<?php


namespace trans\JavaParser\Output\Visitor;


use Ds\Set;
use trans\JavaParser\Output\Expression\ReadVarExpr;

class _VariableFinder extends RecursiveExpressionVisitor
{

    public $varNames = new Set();
    public function visitReadVarExpr(ReadVarExpr $ast, $context)
    {
        $this->varNames->add($ast->name);
        return null;
    }
}