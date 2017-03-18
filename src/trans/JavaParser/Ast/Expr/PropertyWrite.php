<?php


namespace trans\JavaParser\Ast\Expr;


use trans\JavaParser\Ast\AST;
use trans\JavaParser\Ast\AstVisitor;
use trans\JavaParser\Ast\ParseSpan;


class PropertyWrite extends AST
{
    /**
     * @var AST
     */
    public $receiver;
    /**
     * @var string
     */
    public $name;
    /**
     * @var AST
     */
    public $value;

    public function __construct(ParseSpan $span, $receiver, $name, $value)
    {
        parent::__construct($span);
        $this->receiver=$receiver;
        $this->name=$name;
        $this->value=$value;
    }

    public function visit(AstVisitor $visitor, $context = null)
    {
        return $visitor->visitPropertyWrite($this, $context);
    }
}