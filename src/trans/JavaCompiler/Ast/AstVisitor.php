<?php
/**
 * Created by IntelliJ IDEA.
 * User: hugo
 * Date: 2017/2/19
 * Time: 14:35
 */

namespace trans\JavaCompiler\Ast;


use trans\JavaCompiler\Ast\Expr\Binary;
use trans\JavaCompiler\Ast\Expr\BindingPipe;
use trans\JavaCompiler\Ast\Expr\Chain;
use trans\JavaCompiler\Ast\Expr\Conditional;
use trans\JavaCompiler\Ast\Expr\FunctionCall;
use trans\JavaCompiler\Ast\Expr\ImplicitReceiver;
use trans\JavaCompiler\Ast\Expr\Interpolation;
use trans\JavaCompiler\Ast\Expr\KeyedRead;
use trans\JavaCompiler\Ast\Expr\KeyedWrite;
use trans\JavaCompiler\Ast\Expr\LiteralArray;
use trans\JavaCompiler\Ast\Expr\LiteralMap;
use trans\JavaCompiler\Ast\Expr\LiteralPrimitive;
use trans\JavaCompiler\Ast\Expr\MethodCall;
use trans\JavaCompiler\Ast\Expr\PrefixNot;
use trans\JavaCompiler\Ast\Expr\PropertyRead;
use trans\JavaCompiler\Ast\Expr\PropertyWrite;
use trans\JavaCompiler\Ast\Expr\Quote;
use trans\JavaCompiler\Ast\Expr\SafeMethodCall;
use trans\JavaCompiler\Ast\Expr\SafePropertyRead;

interface AstVisitor
{
    public function visitBinary(Binary $ast, $context);

    public function visitChain(Chain $ast, $context);

    public function visitConditional(Conditional $ast, $context);

    public function visitFunctionCall(FunctionCall $ast, $context);

    public function visitImplicitReceiver(ImplicitReceiver $ast, $context);

    public function visitInterpolation(Interpolation $ast, $context);

    public function visitKeyedRead(KeyedRead $ast, $context);

    public function visitKeyedWrite(KeyedWrite $ast, $context);

    public function visitLiteralArray(LiteralArray $ast, $context);

    public function visitLiteralMap(LiteralMap $ast, $context);

    public function visitLiteralPrimitive(LiteralPrimitive $ast, $context);

    public function visitMethodCall(MethodCall $ast, $context);

    public function visitPipe(BindingPipe $ast, $context);

    public function visitPrefixNot(PrefixNot $ast, $context);

    public function visitPropertyRead(PropertyRead $ast, $context);

    public function visitPropertyWrite(PropertyWrite $ast, $context);

    public function visitQuote(Quote $ast, $context);

    public function visitSafeMethodCall(SafeMethodCall $ast, $context);

    public function visitSafePropertyRead(SafePropertyRead $ast, $context);
}