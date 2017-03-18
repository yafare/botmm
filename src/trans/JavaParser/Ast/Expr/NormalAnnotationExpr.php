<?php


namespace trans\JavaParser\Ast\Expr;


use trans\JavaParser\Ast\AST;
use trans\JavaParser\Ast\AstVisitor;
use trans\JavaParser\Ast\ParseSpan;

class NormalAnnotationExpr extends AST
{
    /**
     * @var Name
     */
    public $name;
    /**
     * @var LiteralArray
     */
    public $pairs;

    public function __construct(ParseSpan $span, Name $name, LiteralArray $pairs)
    {
        parent::__construct($span);

        $this->name  = $name;
        $this->pairs = $pairs;
    }

    public function visit(AstVisitor $visitor, $context = null)
    {
        return $visitor->visitNormalAnnotationExpr($this, $context);
    }

}