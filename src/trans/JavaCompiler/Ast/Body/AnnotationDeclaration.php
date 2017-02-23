<?php


namespace trans\JavaCompiler\Ast\Body;


use trans\JavaCompiler\Ast\AST;
use trans\JavaCompiler\Ast\AstVisitor;
use trans\JavaCompiler\Ast\ParseSpan;

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