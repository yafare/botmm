<?php


namespace trans\JavaCompiler\Output;


use trans\JavaCompiler\Output\Expression\BinaryOperatorExpr;
use trans\JavaCompiler\Output\Expression\CastExpr;
use trans\JavaCompiler\Output\Expression\ConditionalExpr;
use trans\JavaCompiler\Output\Expression\ExternalExpr;
use trans\JavaCompiler\Output\Expression\FunctionExpr;
use trans\JavaCompiler\Output\Expression\InstantiateExpr;
use trans\JavaCompiler\Output\Expression\InvokeFunctionExpr;
use trans\JavaCompiler\Output\Expression\InvokeMethodExpr;
use trans\JavaCompiler\Output\Expression\LiteralArrayExpr;
use trans\JavaCompiler\Output\Expression\LiteralExpr;
use trans\JavaCompiler\Output\Expression\LiteralMapExpr;
use trans\JavaCompiler\Output\Expression\NotExpr;
use trans\JavaCompiler\Output\Expression\ReadKeyExpr;
use trans\JavaCompiler\Output\Expression\ReadPropExpr;
use trans\JavaCompiler\Output\Expression\ReadVarExpr;
use trans\JavaCompiler\Output\Expression\WriteKeyExpr;
use trans\JavaCompiler\Output\Expression\WritePropExpr;
use trans\JavaCompiler\Output\Expression\WriteVarExpr;

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