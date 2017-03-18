<?php


namespace trans\JavaParser\Ast\ClassPart;


use trans\JavaParser\Ast\AST;
use trans\JavaParser\Ast\AstVisitor;
use trans\JavaParser\Ast\ParseSpan;

class CompilationUnit extends AST
{
    public $package;
    public $imports;
    public $types;

    /**
     * CompilationUnit constructor.
     *
     * @param ParseSpan                                            $span
     * @param \trans\JavaParser\Ast\ClassPart\PackageDeclaration $package
     * @param array                                                $imports
     * @param array                                                $types
     */
    public function __construct($span, $package, $imports = [], $types = [])
    {
        parent::__construct($span);
        $this->package = $package;
        $this->imports = $imports;
        $this->types   = $types;
    }

    public function visit(AstVisitor $visitor, $context = null)
    {
        return $visitor->visitCompilationUnit($this, $context);
    }
}