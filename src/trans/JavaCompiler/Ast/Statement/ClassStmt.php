<?php


namespace trans\JavaCompiler\Ast\Statement;


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