<?php


namespace trans\JavaParser\Ast;


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
use trans\JavaParser\Ast\Expr\MethodCall;
use trans\JavaParser\Ast\Expr\PrefixNot;
use trans\JavaParser\Ast\Expr\PropertyRead;
use trans\JavaParser\Ast\Expr\PropertyWrite;
use trans\JavaParser\Ast\Expr\Quote;
use trans\JavaParser\Ast\Expr\SafeMethodCall;
use trans\JavaParser\Ast\Expr\SafePropertyRead;

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

    /**
     * @param AST[] $asts
     * @return array
     */
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