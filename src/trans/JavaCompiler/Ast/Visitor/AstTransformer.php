<?php


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

class AstTransformer implements AstVisitor
{
    public function visitImplicitReceiver(ImplicitReceiver $ast, $context): AST
    {
        return $ast;
    }

    public function visitInterpolation(Interpolation $ast, $context): AST
    {
        return new Interpolation($ast->span, $ast->strings, $this->visitAll($ast->expressions));
    }

    public function visitLiteralPrimitive(LiteralPrimitive $ast, $context): AST
    {
        return new LiteralPrimitive($ast->span, $ast->value);
    }

    public function visitPropertyRead(PropertyRead $ast, $context): AST
    {
        return new PropertyRead($ast->span, $ast->receiver->visit($this), $ast->name);
    }

    public function visitPropertyWrite(PropertyWrite $ast, $context): AST
    {
        return new PropertyWrite($ast->span, $ast->receiver->visit($this), $ast->name, $ast->value);
    }

    public function visitSafePropertyRead(SafePropertyRead $ast, $context): AST
    {
        return new SafePropertyRead($ast->span, $ast->receiver->visit($this), $ast->name);
    }

    public function visitMethodCall(MethodCall $ast, $context): AST
    {
        return new MethodCall($ast->span, $ast->receiver->visit($this), $ast->name, $this->visitAll($ast->args));
    }

    public function visitSafeMethodCall(SafeMethodCall $ast, $context): AST
    {
        return new SafeMethodCall(
            $ast->span, $ast->receiver->visit($this), $ast->name, $this->visitAll($ast->args));
    }

    public function visitFunctionCall(FunctionCall $ast, $context): AST
    {
        return new FunctionCall($ast->span, $ast->target->visit($this), $this->visitAll($ast->args));
    }

    public function visitLiteralArray(LiteralArray $ast, $context): AST
    {
        return new LiteralArray($ast->span, $this->visitAll($ast->expressions));
    }

    public function visitLiteralMap(LiteralMap $ast, $context): AST
    {
        return new LiteralMap($ast->span, $ast->keys, $this->visitAll($ast->values));
    }

    public function visitBinary(Binary $ast, $context): AST
    {
        return new Binary($ast->span, $ast->operation, $ast->left->visit($this), $ast->right->visit($this));
    }

    public function visitPrefixNot(PrefixNot $ast, $context): AST
    {
        return new PrefixNot($ast->span, $ast->expression->visit($this));
    }

    public function visitConditional(Conditional $ast, $context): AST
    {
        return new Conditional(
            $ast->span, $ast->condition->visit($this), $ast->trueExp->visit($this), $ast->falseExp->visit($this));
    }

    public function visitPipe(BindingPipe $ast, $context): AST
    {
        return new BindingPipe($ast->span, $ast->exp->visit($this), $ast->name, $this->visitAll($ast->args));
    }

    public function visitKeyedRead(KeyedRead $ast, $context): AST
    {
        return new KeyedRead($ast->span, $ast->obj->visit($this), $ast->key->visit($this));
    }

    public function visitKeyedWrite(KeyedWrite $ast, $context): AST
    {
        return new KeyedWrite(
            $ast->span, $ast->obj->visit($this), $ast->key->visit($this), $ast->value->visit($this));
    }

    public function visitAll($asts)
    {
        $res = [];
        foreach ($asts as $ast) {
            $res[] = $ast->visit($this);
        }
        return $res;
    }

    public function visitChain(Chain $ast, $context): AST
    {
        return new Chain($ast->span, $this->visitAll($ast->expressions));
    }

    public function visitQuote(Quote $ast, $context): AST
    {
        return new Quote($ast->span, $ast->prefix, $ast->uninterpretedExpression, $ast->location);
    }
}