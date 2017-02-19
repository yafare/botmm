<?php


namespace trans\JavaCompiler\Ast;


class Conditional extends AST
{
    public $condition;
    public $trueExp;
    public $falseExp;

    public function __construct(ParseSpan $span, AST $condition, AST $trueExp, AST $falseExp)
    {
        parent::__construct($span);
        $this->condition=$condition;
        $this->trueExp=$trueExp;
        $this->falseExp=$falseExp;
    }

    public function visit(AstVisitor $visitor, $context = null)
    {
        return $visitor->visitConditional($this, $context);
    }
}