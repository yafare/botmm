<?php


namespace trans\JavaParser\Output;


use trans\JavaParser\Output\Expression\BinaryOperatorExpr;
use trans\JavaParser\Output\Expression\CastExpr;
use trans\JavaParser\Output\Expression\ConditionalExpr;
use trans\JavaParser\Output\Expression\ExternalExpr;
use trans\JavaParser\Output\Expression\FunctionExpr;
use trans\JavaParser\Output\Expression\InstantiateExpr;
use trans\JavaParser\Output\Expression\InvokeFunctionExpr;
use trans\JavaParser\Output\Expression\InvokeMethodExpr;
use trans\JavaParser\Output\Expression\LiteralArrayExpr;
use trans\JavaParser\Output\Expression\LiteralExpr;
use trans\JavaParser\Output\Expression\LiteralMapExpr;
use trans\JavaParser\Output\Expression\NotExpr;
use trans\JavaParser\Output\Expression\ReadKeyExpr;
use trans\JavaParser\Output\Expression\ReadPropExpr;
use trans\JavaParser\Output\Expression\ReadVarExpr;
use trans\JavaParser\Output\Expression\WriteKeyExpr;
use trans\JavaParser\Output\Expression\WritePropExpr;
use trans\JavaParser\Output\Expression\WriteVarExpr;

interface ExpressionVisitor
{
    public function visitReadVarExpr(ReadVarExpr $ast, $context);

    public function visitWriteVarExpr(WriteVarExpr $expr, $context);

    public function visitWriteKeyExpr(WriteKeyExpr $expr, $context);

    public function visitWritePropExpr(WritePropExpr $expr, $context);

    public function visitInvokeMethodExpr(InvokeMethodExpr $ast, $context);

    public function visitInvokeFunctionExpr(InvokeFunctionExpr $ast, $context);

    public function visitInstantiateExpr(InstantiateExpr $ast, $context);

    public function visitLiteralExpr(LiteralExpr $ast, $context);

    public function visitExternalExpr(ExternalExpr $ast, $context);

    public function visitConditionalExpr(ConditionalExpr $ast, $context);

    public function visitNotExpr(NotExpr $ast, $context);

    public function visitCastExpr(CastExpr $ast, $context);

    public function visitFunctionExpr(FunctionExpr $ast, $context);

    public function visitBinaryOperatorExpr(BinaryOperatorExpr $ast, $context);

    public function visitReadPropExpr(ReadPropExpr $ast, $context);

    public function visitReadKeyExpr(ReadKeyExpr $ast, $context);

    public function visitLiteralArrayExpr(LiteralArrayExpr $ast, $context);

    public function visitLiteralMapExpr(LiteralMapExpr $ast, $context);
}