<?php


namespace trans\JavaCompiler\Ast\Expr;


use trans\JavaCompiler\Ast\AST;
use trans\JavaCompiler\Ast\AstVisitor;
use trans\JavaCompiler\Ast\ParseSpan;

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