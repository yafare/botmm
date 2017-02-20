<?php


namespace trans\JavaCompiler\Ast\Expr;


use trans\JavaCompiler\Ast\AST;




class LiteralMap extends AST
{
    public $keys;
    public $values;

    public function __construct(ParseSpan $span, array $keys, array $values)
    {
        parent::__construct($span);
        $this->keys = $keys;
        $this->values = $values;
    }

    public function visit(AstVisitor $visitor, $context = null)
    {
        return $visitor->visitLiteralMap($this, $context);
    }
}