<?php


namespace trans\JavaCompiler\Output;


use trans\JavaCompiler\Ast\ParseSourceSpan;
use trans\JavaCompiler\Output\Expression\ReadKeyExpr;
use trans\JavaCompiler\Output\Expression\ReadPropExpr;

abstract class Expression
{
    public $type;
    public $sourceSpan;

    public function __construct(Type $type, ParseSourceSpan $sourceSpan)
    {
        $this->type = $type;
        $this->sourceSpan = $sourceSpan;
    }

    abstract public function visitExpression(ExpressionVisitor $visitor, $context);

    public function prop(string $name, ParseSourceSpan $sourceSpan): ReadPropExpr
    {
        return new ReadPropExpr($this, $name, null, $sourceSpan);
    }

    public function key(Expression $index, Type $type = null, ParseSourceSpan $sourceSpan): ReadKeyExpr
    {
        return new ReadKeyExpr($this, $index, $type, $sourceSpan);
    }

    public function callMethod($name, array $params, ParseSourceSpan $sourceSpan):
    InvokeMethodExpr
    {
        return new InvokeMethodExpr($this, $name, $params, null, $sourceSpan);
    }

    public function callFn(array $params, ParseSourceSpan $sourceSpan): InvokeFunctionExpr
    {
        return new InvokeFunctionExpr($this, $params, null, $sourceSpan);
    }

    public function instantiate(array $params, Type $type = null, ParseSourceSpan $sourceSpan):
    InstantiateExpr
    {
        return new InstantiateExpr($this, $params, $type, $sourceSpan);
    }

    public function conditional(Expression $trueCase, Expression $falseCase = null, ParseSourceSpan $sourceSpan):
    ConditionalExpr
    {
        return new ConditionalExpr($this, $trueCase, $falseCase, null, $sourceSpan);
    }

    public function equals(Expression $rhs, ParseSourceSpan $sourceSpan): BinaryOperatorExpr
    {
        return new BinaryOperatorExpr(BinaryOperator::Equals, $this, $rhs, null, $sourceSpan);
    }

    public function notEquals(Expression $rhs, ParseSourceSpan $sourceSpan): BinaryOperatorExpr
    {
        return new BinaryOperatorExpr(BinaryOperator::NotEquals, $this, $rhs, null, $sourceSpan);
    }

    public function identical(Expression $rhs, ParseSourceSpan $sourceSpan): BinaryOperatorExpr
    {
        return new BinaryOperatorExpr(BinaryOperator::Identical, $this, $rhs, null, $sourceSpan);
    }

    public function notIdentical(Expression $rhs, ParseSourceSpan $sourceSpan): BinaryOperatorExpr
    {
        return new BinaryOperatorExpr(BinaryOperator::NotIdentical, $this, $rhs, null, $sourceSpan);
    }

    public function minus(Expression $rhs, ParseSourceSpan $sourceSpan): BinaryOperatorExpr
    {
        return new BinaryOperatorExpr(BinaryOperator::Minus, $this, $rhs, null, $sourceSpan);
    }

    public function plus(Expression $rhs, ParseSourceSpan $sourceSpan): BinaryOperatorExpr
    {
        return new BinaryOperatorExpr(BinaryOperator::Plus, $this, $rhs, null, $sourceSpan);
    }

    public function divide(Expression $rhs, ParseSourceSpan $sourceSpan): BinaryOperatorExpr
    {
        return new BinaryOperatorExpr(BinaryOperator::Divide, $this, $rhs, null, $sourceSpan);
    }

    public function multiply(Expression $rhs, ParseSourceSpan $sourceSpan): BinaryOperatorExpr
    {
        return new BinaryOperatorExpr(BinaryOperator::Multiply, $this, $rhs, null, $sourceSpan);
    }

    public function modulo(Expression $rhs, ParseSourceSpan $sourceSpan): BinaryOperatorExpr
    {
        return new BinaryOperatorExpr(BinaryOperator::Modulo, $this, $rhs, null, $sourceSpan);
    }

    public function and (Expression $rhs, ParseSourceSpan $sourceSpan): BinaryOperatorExpr
    {
        return new BinaryOperatorExpr(BinaryOperator:: And, $this, $rhs, null, $sourceSpan);
    }

    public function or (Expression $rhs, ParseSourceSpan $sourceSpan): BinaryOperatorExpr
    {
        return new BinaryOperatorExpr(BinaryOperator:: Or, $this, $rhs, null, $sourceSpan);
    }

    public function lower(Expression $rhs, ParseSourceSpan $sourceSpan): BinaryOperatorExpr
    {
        return new BinaryOperatorExpr(BinaryOperator::Lower, $this, $rhs, null, $sourceSpan);
    }

    public function lowerEquals(Expression $rhs, ParseSourceSpan $sourceSpan): BinaryOperatorExpr
    {
        return new BinaryOperatorExpr(BinaryOperator::LowerEquals, $this, $rhs, null, $sourceSpan);
    }

    public function bigger(Expression $rhs, ParseSourceSpan $sourceSpan): BinaryOperatorExpr
    {
        return new BinaryOperatorExpr(BinaryOperator::Bigger, $this, $rhs, null, $sourceSpan);
    }

    public function biggerEquals(Expression $rhs, ParseSourceSpan $sourceSpan): BinaryOperatorExpr
    {
        return new BinaryOperatorExpr(BinaryOperator::BiggerEquals, $this, $rhs, null, $sourceSpan);
    }

    public function isBlank(ParseSourceSpan $sourceSpan): Expression
    {
        // Note: We use equals by purpose here to compare to null and undefined in JS.
        // We use the typed null to allow strictNullChecks to narrow types.
        return $this->equals(TYPED_NULL_EXPR, $sourceSpan);
    }

    public function cast(Type $type, ParseSourceSpan $sourceSpan): Expression
    {
        return new CastExpr($this, $type, $sourceSpan);
    }

    public function toStmt(): Statement
    {
        return new ExpressionStatement($this);
    }
}
