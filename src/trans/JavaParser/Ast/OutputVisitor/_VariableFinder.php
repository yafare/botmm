<?php


namespace trans\JavaCompiler\Output\Visitor;


use Ds\Set;
use trans\JavaCompiler\Output\Expression\ReadVarExpr;

class _VariableFinder extends RecursiveExpressionVisitor
{

    public $varNames = new Set();
    public function visitReadVarExpr(ReadVarExpr $ast, $context)
    {
        $this->varNames->add($ast->name);
        return null;
    }
}