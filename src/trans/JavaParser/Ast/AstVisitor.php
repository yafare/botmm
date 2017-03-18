<?php
/**
 * Created by IntelliJ IDEA.
 * User: hugo
 * Date: 2017/2/19
 * Time: 14:35
 */

namespace trans\JavaParser\Ast;


use src\trans\JavaParser\Ast\Body\ClassOrInterfaceDeclaration;
use trans\JavaParser\Ast\Body\AnnotationDeclaration;
use trans\JavaParser\Ast\Body\FieldDeclaration;
use trans\JavaParser\Ast\ClassPart\ImportDeclaration;
use trans\JavaParser\Ast\ClassPart\PackageDeclaration;
use trans\JavaParser\Ast\Expr\Binary;
use trans\JavaParser\Ast\Expr\BindingPipe;
use trans\JavaParser\Ast\Expr\Chain;
use trans\JavaParser\Ast\Expr\Conditional;
use trans\JavaParser\Ast\Expr\FunctionCall;
use trans\JavaParser\Ast\Expr\ImplicitReceiver;
use trans\JavaParser\Ast\Expr\Interpolation;
use trans\JavaParser\Ast\Expr\KeyedRead;
use trans\JavaParser\Ast\Expr\KeyedWrite;
use trans\JavaParser\Ast\Expr\LiteralArray;
use trans\JavaParser\Ast\Expr\LiteralMap;
use trans\JavaParser\Ast\Expr\LiteralPrimitive;
use trans\JavaParser\Ast\Expr\MarkerAnnotationExpr;
use trans\JavaParser\Ast\Expr\MemberValuePair;
use trans\JavaParser\Ast\Expr\MethodCall;
use trans\JavaParser\Ast\Expr\Name;
use trans\JavaParser\Ast\Expr\NormalAnnotationExpr;
use trans\JavaParser\Ast\Expr\PrefixNot;
use trans\JavaParser\Ast\Expr\PropertyRead;
use trans\JavaParser\Ast\Expr\PropertyWrite;
use trans\JavaParser\Ast\Expr\Quote;
use trans\JavaParser\Ast\Expr\SafeMethodCall;
use trans\JavaParser\Ast\Expr\SafePropertyRead;
use trans\JavaParser\Ast\Expr\SimpleName;
use trans\JavaParser\Ast\Expr\SingleMemberAnnotationExpr;
use trans\JavaParser\Parser\CompilationUnit;

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

    public function visitName(Name $ast, $context);

    public function visitMemberValuePair(MemberValuePair $ast, $context);

    public function visitSimpleName(SimpleName $ast, $context);

    public function visitNormalAnnotationExpr(NormalAnnotationExpr $ast, $context);

    public function visitSingleMemberAnnotationExpr(SingleMemberAnnotationExpr $ast, $context);

    public function visitMarkerAnnotationExpr(MarkerAnnotationExpr $ast, $context);

    public function visitPackageDeclaration(PackageDeclaration $ast, $context);

    public function visitImportDeclaration(ImportDeclaration $ast, $context);

    public function visitAnnotationDeclaration(AnnotationDeclaration $ast, $context);

    public function visitFieldDeclaration(FieldDeclaration $ast, $context);

    public function visitCompilationUnit(CompilationUnit $ast, $context);

    public function visitClassOrInterfaceDeclaration(ClassOrInterfaceDeclaration $ast, $context);
}