<?php


namespace trans\JavaCompiler\Ast;


class Binary extends AST
{
    public $operation;
    public $left;
    public $right;

    public function __construct(ParseSpan $span, string $operation, AST $left, AST $right)
    {
        parent::__construct($span);
        $this->operation = $operation;
        $this->left = $left;
        $this->right = $right;
    }

    public function visit(AstVisitor $visitor, $context = null)
    {
        return $visitor->visitBinary($this, $context);
    }
}