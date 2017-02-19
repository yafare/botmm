<?php


namespace trans\JavaCompiler\Ast;



use trans\JavaCompiler\AstVisitor;
use trans\JavaCompiler\Binary;

class RecursiveAstVisitor implements AstVisitor {
    public function visitBinary(Binary $ast, $context): any {
        $ast->left->visit($this);
        $ast->right->visit($this);
        return null;
    }
    public function visitChain(Chain $ast, $context): any {
        return $this->visitAll($ast->expressions, $context);
    }
    public function visitConditional(Conditional $ast, $context): any {
        $ast->condition->visit($this);
        $ast->trueExp->visit($this);
        $ast->falseExp->visit($this);
        return null;
    }
    public function visitPipe(BindingPipe $ast , $context): any {
        $ast->exp->visit($this);
        $this->visitAll($ast->args, $context);
        return null;
    }
    public function visitFunctionCall(FunctionCall $ast, $context): any {
        $ast->target->visit($this);
        $this->visitAll($ast->args, $context);
        return null;
    }
    public function visitImplicitReceiver(ImplicitReceiver $ast , $context): any {
        return null;
    }
    public function visitInterpolation(Interpolation $ast, $context): any {
        return $this->visitAll($ast->expressions, $context);
    }
    public function visitKeyedRead(KeyedRead $ast, $context): any {
        $ast->obj->visit($this);
        $ast->key->visit($this);
        return null;
    }
    public function visitKeyedWrite(KeyedWrite $ast, $context): any {
        $ast->obj->visit($this);
        $ast->key->visit($this);
        $ast->value->visit($this);
        return null;
    }
    public function visitLiteralArray(LiteralArray $ast, $context): any {
        return $this->visitAll($ast->expressions, $context);
    }
    public function visitLiteralMap(LiteralMap $ast, $context): any {
        return $this->visitAll($ast->values, $context);
    }
    public function visitLiteralPrimitive(LiteralPrimitive $ast, $context): any {
        return null;
    }
    public function visitMethodCall(MethodCall $ast , $context): any {
        $ast->receiver->visit($this);
        return $this->visitAll($ast->args, $context);
    }
    public function visitPrefixNot(PrefixNot $ast, $context): any {
        $ast->expression->visit($this);
        return null;
    }
    public function visitPropertyRead(PropertyRead $ast, $context): any {
        $ast->receiver->visit($this);
        return null;
    }
    public function visitPropertyWrite(PropertyWrite $ast, $context): any {
        $ast->receiver->visit($this);
        $ast->value->visit($this);
        return null;
    }
    public function visitSafePropertyRead(SafePropertyRead $ast, $context): any {
        $ast->receiver->visit($this);
        return null;
    }
    public function visitSafeMethodCall(SafeMethodCall $ast, $context): any {
        $ast->receiver->visit($this);
        return $this->visitAll($ast->args, $context);
    }
    public function visitAll($asts, $context): any {
        foreach ($asts as $ast) {
            $ast->visit($this, $context);
        }
        return null;
    }
    public function visitQuote(Quote $ast, $context): any {
        return null;
    }
}
