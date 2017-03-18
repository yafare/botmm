<?php


namespace trans\JavaParser\Ast\Expr;


use trans\JavaParser\Ast\AST;
use trans\JavaParser\Ast\AstVisitor;
use trans\JavaParser\Ast\ParseSpan;

class VariableDeclarationExpr extends AST
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
        return $visitor->visitVariableDeclarationExpr($this, $context);
    }
}