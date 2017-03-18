<?php


namespace trans\JavaParser\Ast\Expr;


use trans\JavaParser\Ast\AST;
use trans\JavaParser\Ast\AstVisitor;
use trans\JavaParser\Ast\ParseSpan;

class MemberValuePair extends AST
{
    public $name;
    public $value;

    public function __construct(ParseSpan $span, $name, $value)
    {
        parent::__construct($span);
        $this->name  = $name;
        $this->value = $value;
    }

    public function visit(AstVisitor $visitor, $context = null)
    {
        return $visitor->visitMemberValuePair($this, $context);
    }


}