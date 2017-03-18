<?php


namespace trans\JavaCompiler\Ast\ClassPart;


use trans\JavaCompiler\Ast\AST;
use trans\JavaCompiler\Ast\AstVisitor;
use trans\JavaCompiler\Ast\ParseSpan;

class CompilationUnit extends AST
{
    public $package;
    public $imports;
    public $types;

    /**
     * CompilationUnit constructor.
     *
     * @param ParseSpan                                            $span
     * @param \trans\JavaCompiler\Ast\ClassPart\PackageDeclaration $package
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