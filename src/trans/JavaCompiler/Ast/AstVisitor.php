<?php
/**
 * Created by IntelliJ IDEA.
 * User: hugo
 * Date: 2017/2/19
 * Time: 14:35
 */

namespace src\trans\JavaCompiler;


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
class RecursiveAstVisitor implements AstVisitor {
visitBinary(ast: Binary, $context: any): any {
ast.left.visit($this);
ast.right.visit($this);
return null;
}
visitChain(ast: Chain, $context: any): any { return this.visitAll(ast.expressions, $context); }
  visitConditional(ast: Conditional, $context: any): any {
    ast.condition.visit($this);
    ast.trueExp.visit($this);
    ast.falseExp.visit($this);
    return null;
}
  visitPipe(ast: BindingPipe, $context: any): any {
    ast.exp.visit($this);
    this.visitAll(ast.args, $context);
    return null;
}
  visitFunctionCall(ast: FunctionCall, $context: any): any {
    ast.target.visit($this);
    this.visitAll(ast.args, $context);
    return null;
}
  visitImplicitReceiver(ast: ImplicitReceiver, $context: any): any { return null; }
  visitInterpolation(ast: Interpolation, $context: any): any {
    return this.visitAll(ast.expressions, $context);
}
  visitKeyedRead(ast: KeyedRead, $context: any): any {
    ast.obj.visit($this);
    ast.key.visit($this);
    return null;
}
  visitKeyedWrite(ast: KeyedWrite, $context: any): any {
    ast.obj.visit($this);
    ast.key.visit($this);
    ast.value.visit($this);
    return null;
}
  visitLiteralArray(ast: LiteralArray, $context: any): any {
    return this.visitAll(ast.expressions, $context);
}
  visitLiteralMap(ast: LiteralMap, $context: any): any { return this.visitAll(ast.values, $context); }
  visitLiteralPrimitive(ast: LiteralPrimitive, $context: any): any { return null; }
  visitMethodCall(ast: MethodCall, $context: any): any {
    ast.receiver.visit($this);
    return this.visitAll(ast.args, $context);
}
  visitPrefixNot(ast: PrefixNot, $context: any): any {
    ast.expression.visit($this);
    return null;
}
  visitPropertyRead(ast: PropertyRead, $context: any): any {
    ast.receiver.visit($this);
    return null;
}
  visitPropertyWrite(ast: PropertyWrite, $context: any): any {
    ast.receiver.visit($this);
    ast.value.visit($this);
    return null;
}
  visitSafePropertyRead(ast: SafePropertyRead, $context: any): any {
    ast.receiver.visit($this);
    return null;
}
  visitSafeMethodCall(ast: SafeMethodCall, $context: any): any {
    ast.receiver.visit($this);
    return this.visitAll(ast.args, $context);
}
  visitAll(asts: AST[], $context: any): any {
    asts.forEach(ast => ast.visit($this, $context));
    return null;
  }
  visitQuote(ast: Quote, $context: any): any { return null; }
}

class AstTransformer implements AstVisitor {
visitImplicitReceiver(ast: ImplicitReceiver, $context: any): AST { return ast; }

  visitInterpolation(ast: Interpolation, $context: any): AST {
    return new Interpolation(ast.span, ast.strings, this.visitAll(ast.expressions));
}

  visitLiteralPrimitive(ast: LiteralPrimitive, $context: any): AST {
    return new LiteralPrimitive(ast.span, ast.value);
}

  visitPropertyRead(ast: PropertyRead, $context: any): AST {
    return new PropertyRead(ast.span, ast.receiver.visit($this), ast.name);
}

  visitPropertyWrite(ast: PropertyWrite, $context: any): AST {
    return new PropertyWrite(ast.span, ast.receiver.visit($this), ast.name, ast.value);
}

  visitSafePropertyRead(ast: SafePropertyRead, $context: any): AST {
    return new SafePropertyRead(ast.span, ast.receiver.visit($this), ast.name);
}

  visitMethodCall(ast: MethodCall, $context: any): AST {
    return new MethodCall(ast.span, ast.receiver.visit($this), ast.name, this.visitAll(ast.args));
}

  visitSafeMethodCall(ast: SafeMethodCall, $context: any): AST {
    return new SafeMethodCall(
        ast.span, ast.receiver.visit($this), ast.name, this.visitAll(ast.args));
}

  visitFunctionCall(ast: FunctionCall, $context: any): AST {
    return new FunctionCall(ast.span, ast.target.visit($this), this.visitAll(ast.args));
}

  visitLiteralArray(ast: LiteralArray, $context: any): AST {
    return new LiteralArray(ast.span, this.visitAll(ast.expressions));
}

  visitLiteralMap(ast: LiteralMap, $context: any): AST {
    return new LiteralMap(ast.span, ast.keys, this.visitAll(ast.values));
}

  visitBinary(ast: Binary, $context: any): AST {
    return new Binary(ast.span, ast.operation, ast.left.visit($this), ast.right.visit($this));
}

  visitPrefixNot(ast: PrefixNot, $context: any): AST {
    return new PrefixNot(ast.span, ast.expression.visit($this));
}

  visitConditional(ast: Conditional, $context: any): AST {
    return new Conditional(
        ast.span, ast.condition.visit($this), ast.trueExp.visit($this), ast.falseExp.visit($this));
}

  visitPipe(ast: BindingPipe, $context: any): AST {
    return new BindingPipe(ast.span, ast.exp.visit($this), ast.name, this.visitAll(ast.args));
}

  visitKeyedRead(ast: KeyedRead, $context: any): AST {
    return new KeyedRead(ast.span, ast.obj.visit($this), ast.key.visit($this));
}

  visitKeyedWrite(ast: KeyedWrite, $context: any): AST {
    return new KeyedWrite(
        ast.span, ast.obj.visit($this), ast.key.visit($this), ast.value.visit($this));
}

  visitAll(asts: any[]): any[] {
    const res = new Array(asts.length);
    for (let i = 0; i < asts.length; ++i) {
        res[i] = asts[i].visit($this);
    }
    return res;
  }

  visitChain(ast: Chain, $context: any): AST {
    return new Chain(ast.span, this.visitAll(ast.expressions));
}

  visitQuote(ast: Quote, $context: any): AST {
    return new Quote(ast.span, ast.prefix, ast.uninterpretedExpression, ast.location);
}
}