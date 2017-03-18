<?php


namespace trans\JavaParser\Ast\Body;


use trans\JavaParser\Ast\AST;
use trans\JavaParser\Ast\AstVisitor;
use trans\JavaParser\Ast\ParseSpan;

class ClassOrInterfaceDeclaration extends AST
{
    public $modifiers;
    public $annotations;
    public $isInterface;
    public $name;
    public $typeParameters;
    public $extendedTypes;
    public $implementedTypes;
    public $members;

    public function __construct(
        ParseSpan $span,
        $modifiers,
        $annotations,
        $isInterface,
        $name,
        $typeParameters,
        $extendedTypes,
        $implementedTypes,
        $members
    ) {
        parent::__construct($span);
        $this->modifiers        = $modifiers;
        $this->annotations      = $annotations;
        $this->isInterface      = $isInterface;
        $this->name             = $name;
        $this->typeParameters   = $typeParameters;
        $this->extendedTypes    = $extendedTypes;
        $this->implementedTypes = $implementedTypes;
        $this->members          = $members;
    }

    public function visit(AstVisitor $visitor, $context = null)
    {
        return $visitor->visitClassOrInterfaceDeclaration($this, $context);
    }

}