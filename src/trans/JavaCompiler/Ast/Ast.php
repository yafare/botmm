<?php


namespace src\trans\JavaCompiler;


import {isBlank} from '../facade/lang';



class AST
{
    public $span;

    public function __construct(ParseSpan $span)
    {
        $this->span = $span;

    }

    public function visit(AstVisitor $visitor, $context = null)
    {
        return null;
    }

    public function toString(): string
    {
        return 'AST';
    }
}

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

class EmptyExpr extends AST
{
    public function visit(AstVisitor $visitor, $context = null)
    {
        // do nothing
    }
}

class ImplicitReceiver extends AST
{
    public function visit(AstVisitor $visitor, $context = null)
    {
        return $visitor->visitImplicitReceiver($this, $context);
    }
}

/**
 * Multiple expressions separated by a semicolon.
 */
class Chain extends AST
{
    public $expressions;

    public function __construct(ParseSpan $span, array $expressions)
    {
        parent::__construct($span);
    }

    public function visit(AstVisitor $visitor, $context = null)
    {
        return $visitor->visitChain($this, $context);
    }
}

class Conditional extends AST
{
    public $condition;
    public $trueExp;
    public $falseExp;

    public function __construct(ParseSpan $span, AST $condition, AST $trueExp, AST $falseExp)
    {
        parent::__construct($span);
        $this->condition=$condition;
        $this->trueExp=$trueExp;
        $this->falseExp=$falseExp;
    }

    public function visit(AstVisitor $visitor, $context = null)
    {
        return $visitor->visitConditional($this, $context);
    }
}

class PropertyRead extends AST
{
    public $receiver;
    public $name;

    public function __construct(ParseSpan $span, AST $receiver, string $name)
    {
        parent::__construct($span);
        $this->receiver = $receiver;
        $this->name = $name;
    }

    public function visit(AstVisitor $visitor, $context = null)
    {
        return $visitor->visitPropertyRead($this, $context);
    }
}

class PropertyWrite extends AST
{
    public $receiver;
    public $name;
    public $value;

    public function __construct(ParseSpan $span, $receiver, $name, $value)
    {
        parent::__construct($span);
        $this->receiver=$receiver;
        $this->name=$name;
        $this->value=$value;
    }

    public function visit(AstVisitor $visitor, $context = null)
    {
        return $visitor->visitPropertyWrite($this, $context);
    }
}

class SafePropertyRead extends AST
{
    public $receiver;
    public $name;

    public function __construct(ParseSpan $span, AST $receiver, string $name)
    {
        parent::__construct($span);
        $this->receiver = $receiver;
        $this->name = $name;
    }

    public function visit(AstVisitor $visitor, $context = null)
    {
        return $visitor->visitSafePropertyRead($this, $context);
    }
}

class KeyedRead extends AST
{
    public $obj;
    public $key;

    public function __construct(ParseSpan $span, AST $obj, AST $key)
    {
        parent::__construct($span);
        $this->obj = $obj;
        $this->key = $key;
    }

    public function visit(AstVisitor $visitor, $context = null)
    {
        return $visitor->visitKeyedRead($this, $context);
    }
}

class KeyedWrite extends AST
{
    public $obj;
    public $key;
    public $value;

    public function __construct(ParseSpan $span, AST $obj, AST $key, AST $value)
    {
        parent::__construct($span);
        $this->obj = $obj;
        $this->key = $key;
        $this->value = $value;
    }

    public function visit(AstVisitor $visitor, $context = null)
    {
        return $visitor->visitKeyedWrite($this, $context);
    }
}

class BindingPipe extends AST
{
    public $exp;
    public $name;
    public $args;

    public function __construct(ParseSpan $span, AST $exp, string $name, array $args)
    {
        parent::__construct($span);
        $this->exp = $exp;
        $this->name = $name;
        $this->args = $args;
    }

    public function visit(AstVisitor $visitor, $context = null)
    {
        return $visitor->visitPipe($this, $context);
    }
}

class LiteralPrimitive extends AST
{
    public $value;

    public function __construct(ParseSpan $span, $value)
    {
        parent::__construct($span);
        $this->value = $value;
    }

    public function visit(AstVisitor $visitor, $context = null)
    {
        return $visitor->visitLiteralPrimitive($this, $context);
    }
}

class LiteralArray extends AST
{
    public $expressions;

    public function __construct(ParseSpan $span, array $expressions)
    {
        parent::__construct($span);
        $this->expressions = $expressions;
    }

    public function visit(AstVisitor $visitor, $context = null)
    {
        return $visitor->visitLiteralArray($this, $context);
    }
}

class LiteralMap extends AST
{
    public $keys;
    public $values;

    public function __construct(ParseSpan $span, array $keys, array $values)
    {
        parent::__construct($span);
        $this->keys = $keys;
        $this->values = $values;
    }

    public function visit(AstVisitor $visitor, $context = null)
    {
        return $visitor->visitLiteralMap($this, $context);
    }
}

class Interpolation extends AST
{
    public $strings;
    public $expressions;

    public function __construct(ParseSpan $span, array $strings, array $expressions)
    {
        parent::__construct($span);
        $this->strings = $strings;
        $this->expressions = $expressions;
    }

    public function visit(AstVisitor $visitor, $context = null)
    {
        return $visitor->visitInterpolation($this, $context);
    }
}

class Binary extends AST
{
    public $operation;
    public $left;
    public $right;

    public function __construct(ParseSpan $span, string $operation, AST $left, AST $right)
    {
        parent::__construct($span);
        $this->operation = $operation;
        $this->left = $left;
        $this->right = $right;
    }

    public function visit(AstVisitor $visitor, $context = null)
    {
        return $visitor->visitBinary($this, $context);
    }
}

class PrefixNot extends AST
{
    public $expression;

    public function __construct(ParseSpan $span, AST $expression)
    {
        parent::__construct($span);
        $this->expression = $expression;
    }

    public function visit(AstVisitor $visitor, $context = null)
    {
        return $visitor->visitPrefixNot($this, $context);
    }
}

class MethodCall extends AST
{
    public $receiver;
    public $name;
    public $args;

    public function __construct(ParseSpan $span, AST $receiver, string $name, array $args)
    {
        parent::__construct($span);
        $this->receiver = $receiver;
        $this->name = $name;
        $this->args = $args;
    }

    public function visit(AstVisitor $visitor, $context = null)
    {
        return $visitor->visitMethodCall($this, $context);
    }
}

class SafeMethodCall extends AST
{
    public $receiver;
    public $name;
    public $args;

    public function __construct(ParseSpan $span, AST $receiver, string $name, array $args)
    {
        parent::__construct($span);
        $this->receiver = $receiver;
        $this->name = $name;
        $this->args = $args;
    }

    public function visit(AstVisitor $visitor, $context = null)
    {
        return $visitor->visitSafeMethodCall($this, $context);
    }
}

class FunctionCall extends AST
{
    public $target;
    public $args;

    public function __construct(ParseSpan $span, AST $target, array $args)
    {
        parent::__construct($span);
        $this->target = $target;
        $this->args = $args;
    }

    public function visit(AstVisitor $visitor, $context = null)
    {
        return $visitor->visitFunctionCall($this, $context);
    }
}

class ASTWithSource extends AST
{
    public $ast;
    public $source;
    public $location;
    public $errors;

    public function __construct(
        AST $ast, string $source, string $location,
        array $errors)
    {
        parent::__construct(new ParseSpan(0, empty($source) ? 0 : strlen($source)));
    }

    public function visit(AstVisitor $visitor, $context = null)
    {
        return $this->ast->visit($visitor,$context);
    }

    public function toString(): string
    {
        return "{$this->source} in {$this->location}";
    }
}


interface AstVisitor {
visitBinary(ast: Binary, $context: any): any;
visitChain(ast: Chain, $context: any): any;
visitConditional(ast: Conditional, $context: any): any;
visitFunctionCall(ast: FunctionCall, $context: any): any;
visitImplicitReceiver(ast: ImplicitReceiver, $context: any): any;
visitInterpolation(ast: Interpolation, $context: any): any;
visitKeyedRead(ast: KeyedRead, $context: any): any;
visitKeyedWrite(ast: KeyedWrite, $context: any): any;
visitLiteralArray(ast: LiteralArray, $context: any): any;
visitLiteralMap(ast: LiteralMap, $context: any): any;
visitLiteralPrimitive(ast: LiteralPrimitive, $context: any): any;
visitMethodCall(ast: MethodCall, $context: any): any;
visitPipe(ast: BindingPipe, $context: any): any;
visitPrefixNot(ast: PrefixNot, $context: any): any;
visitPropertyRead(ast: PropertyRead, $context: any): any;
visitPropertyWrite(ast: PropertyWrite, $context: any): any;
visitQuote(ast: Quote, $context: any): any;
visitSafeMethodCall(ast: SafeMethodCall, $context: any): any;
visitSafePropertyRead(ast: SafePropertyRead, $context: any): any;
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
