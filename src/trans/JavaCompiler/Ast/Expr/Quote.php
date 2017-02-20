<?php


namespace trans\JavaCompiler\Ast\Expr;


use trans\JavaCompiler\Ast\AST;
use trans\JavaCompiler\Ast\AstVisitor;
use trans\JavaCompiler\Ast\ParseSpan;


/**
 * Represents a quoted expression of the form:
 *
 * quote = prefix `:` uninterpretedExpression
 * prefix = identifier
 * uninterpretedExpression = arbitrary string
 *
 * A quoted expression is meant to be pre-processed by an AST transformer that
 * converts it into another AST that no longer contains quoted expressions.
 * It is meant to allow third-party developers to extend Angular template
 * expression language. The `uninterpretedExpression` part of the quote is
 * therefore not interpreted by the Angular's own expression parser.
 */
class Quote extends AST
{
    public $prefix;
    public $uninterpretedExpression;
    public $location;

    public function __construct(ParseSpan $span, string $prefix, string $uninterpretedExpression, $location)
    {

        parent::__construct($span);
        $this->prefix = $prefix;
        $this->uninterpretedExpression = $uninterpretedExpression;
        $this->location = $location;
    }

    public function visit(AstVisitor $visitor, $context = null)
    {
        return $visitor->visitQuote($this, $context);
    }

    public function toString(): string
    {
        return 'Quote';
    }
}