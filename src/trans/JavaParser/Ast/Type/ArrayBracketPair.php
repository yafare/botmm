<?php


namespace trans\JavaParser\Ast\Type;


use trans\JavaParser\Ast\AST;
use trans\JavaParser\Ast\AstVisitor;
use trans\JavaParser\Ast\ParseSpan;

class ArrayBracketPair extends AST
{

    public $annotations;

    public function __construct(ParseSpan $span, $annotations)
    {
        parent::__construct($span);
        $this->annotations = $annotations;
    }

    public function visit(AstVisitor $visitor, $context = null)
    {
        $visitor->visitArrayBracketPair($this, $context);
    }

}