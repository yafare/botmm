<?php


namespace trans\JavaParser\Ast;


class AstList extends AST
{

    public $list;
    
    public function __construct(ParseSpan $span, $list)
    {
        parent::__construct($span);
        $this->list = $list;
    }

    public function visit(AstVisitor $visitor, $context = null)
    {
        $visitor->visitAstList($this, $context);
    }
}