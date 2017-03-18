<?php


namespace trans\JavaParser\Ast\ClassPart;


use trans\JavaParser\Ast\AST;
use trans\JavaParser\Ast\AstVisitor;
use trans\JavaParser\Ast\ParseSpan;

class ImportDeclaration extends AST
{

    public $name;
    public $isStatic;
    public $isAsterisk;

    public function __construct(ParseSpan $span, $name, $isStatic, $isAsterisk)
    {
        parent::__construct($span);
        $this->name       = $name;
        $this->isStatic   = $isStatic;
        $this->isAsterisk = $isAsterisk;
    }

    public function visit(AstVisitor $visitor, $context = null)
    {
        return $visitor->visitImportDeclaration($this, $context);
    }

}