<?php


namespace trans\JavaParser\Ast\ClassPart;


use trans\JavaParser\Ast\AST;
use trans\JavaParser\Ast\AstVisitor;
use trans\JavaParser\Ast\ParseSpan;

class PackageDeclaration extends AST
{
    public $annotations;
    public $name;

    public function __construct(ParseSpan $span, $annotations, $name)
    {
        parent::__construct($span);
        $this->annotations = $annotations;
        $this->name        = $name;
    }

    public function visit(AstVisitor $visitor, $context = null)
    {
        return $visitor->visitPackageDeclaration($this, $context);
    }

}