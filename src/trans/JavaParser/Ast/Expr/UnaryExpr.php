<?php


namespace trans\JavaParser\Ast\Expr;


use trans\JavaParser\Ast\AST;
use trans\JavaParser\Ast\AstVisitor;
use trans\JavaParser\Ast\ParseSpan;

class UnaryExpr extends AST
{
    public static $PLUS               = '+';
    public static $MINUS              = '-';
    public static $PREFIX_INCREMENT   = '++PrefixIncrement';
    public static $PREFIX_DECREMENT   = '--PrefixIncrement';
    public static $LOGICAL_COMPLEMENT = '!';
    public static $BITWISE_COMPLEMENT = '~';
    public static $POSTFIX_INCREMENT  = 'PostfixIncrement++';
    public static $POSTFIX_DECREMENT  = 'PostfixIncrement--';

    public $string;

    public function __construct(ParseSpan $span, $string)
    {
        parent::__construct($span);
        $this->string = $string;
    }

    public function visit(AstVisitor $visitor, $context = null)
    {
        return $visitor->visitUnaryExpr($this, $context);
    }
}