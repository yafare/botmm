<?php


namespace trans\JavaCompiler\Ast\Body;


use trans\JavaCompiler\Ast\AST;
use trans\JavaCompiler\Ast\AstVisitor;
use trans\JavaCompiler\Ast\ParseSpan;

class FieldDeclaration extends AST
{

    public $modifiers;
    public $annotations;
    public $variables;

    public function __construct(ParseSpan $span, $modifiers, $annotations, $variables)
    {
        parent::__construct($span);
        $this->modifiers   = $modifiers;
        $this->annotations = $annotations;
        $this->variables   = $variables;
    }

    public function visit(AstVisitor $visitor, $context = null)
    {
        return $visitor->visitFieldDeclaration($this, $context);
    }
}