<?php


namespace trans\JavaCompiler\Ast\ClassPart;


use trans\JavaCompiler\Ast\AST;
use trans\JavaCompiler\Ast\AstVisitor;
use trans\JavaCompiler\Ast\ParseSpan;

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