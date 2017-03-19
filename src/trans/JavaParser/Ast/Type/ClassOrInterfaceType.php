<?php


namespace trans\JavaParser\Ast\Type;


use trans\JavaParser\Ast\AST;
use trans\JavaParser\Ast\AstVisitor;
use trans\JavaParser\Ast\ParseSpan;

class ClassOrInterfaceType extends ReferenceType
{

    public $scope;
    public $name;
    public $typeArguments;

    public function __construct(ParseSpan $span, $scope, $name, $typeArguments)
    {
        parent::__construct($span);
        $this->scope = $scope;
        $this->name  = $name;
        $this->typeArguments = $typeArguments;

    }

    public function visit(AstVisitor $visitor, $context = null)
    {
        return $visitor->visitClassOrInterfaceType($this, $context);
    }
}