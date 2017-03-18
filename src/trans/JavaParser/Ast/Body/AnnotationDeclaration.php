<?php


namespace trans\JavaParser\Ast\Body;


use trans\JavaParser\Ast\AST;
use trans\JavaParser\Ast\AstVisitor;
use trans\JavaParser\Ast\ParseSpan;

class AnnotationDeclaration extends AST
{
    public function __construct(ParseSpan $span)
    {
        parent::__construct($span);
    }

    public function visit(AstVisitor $visitor, $context = null)
    {
        return $visitor->visitAnnotationDeclaration($this, $context);
    }

}