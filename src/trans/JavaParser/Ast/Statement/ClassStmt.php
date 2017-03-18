<?php


namespace trans\JavaParser\Ast\Statement;


use trans\JavaParser\Ast\ParseSourceSpan;
use trans\JavaParser\Output\ClassPart\ClassMethod;
use trans\JavaParser\Output\Expression;
use trans\JavaParser\Output\StatementVisitor;

class ClassStmt extends Statement
{
    public $name;
    public $parent;
    public $fields;
    public $getters;
    public $constructorMethod;
    public $methods;

    public function __construct(
        string $name,
        Expression $parent,
        array $fields,
        array $getters,
        ClassMethod $constructorMethod,
        array $methods,
        $modifiers = null,
        ParseSourceSpan $sourceSpan
    ) {
        parent::__construct($modifiers, $sourceSpan);
        $this->name              = $name;
        $this->parent            = $parent;
        $this->fields            = $fields;
        $this->getters           = $getters;
        $this->constructorMethod = $constructorMethod;
        $this->methods           = $methods;
    }

    public function visitStatement(StatementVisitor $visitor, $context)
    {
        return $visitor->visitDeclareClassStmt($this, $context);
    }
}