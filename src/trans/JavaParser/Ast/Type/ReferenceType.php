<?php


namespace trans\JavaParser\Ast\Type;


use trans\JavaParser\Ast\AstVisitor;
use trans\JavaParser\Ast\ParseSpan;

abstract class ReferenceType extends TypeAst
{

    public function __construct(ParseSpan $span)
    {
        parent::__construct($span);

    }

    public function visit(AstVisitor $visitor, $context = null)
    {
        $visitor->visitReferenceType($this, $context);
    }
}