<?php


namespace trans\JavaParser\Output\Visitor;


class RecursiveExpressionVisitor implements StatementVisitor, ExpressionVisitor {
    public function visitReadVarExpr(ReadVarExpr $ast, $context) { return $ast; }
    public function visitWriteVarExpr( WriteVarExpr $expr, $context) {
        $expr->value->visitExpression($this, $context);
        return $expr;
    }
    public function visitWriteKeyExpr(WriteKeyExpr $expr, $context) {
        $expr->receiver->visitExpression($this, $context);
        $expr->index->visitExpression($this, $context);
        $expr->value->visitExpression($this, $context);
        return $expr;
    }
    public function visitWritePropExpr(WritePropExpr $expr, $context) {
        $expr->receiver->visitExpression($this, $context);
        $expr->value->visitExpression($this, $context);
        return $expr;
    }
    public function visitInvokeMethodExpr(InvokeMethodExpr $ast, $context) {
        $ast->receiver->visitExpression($this, $context);
        $this->visitAllExpressions($ast->args, $context);
        return $ast;
    }
    public function visitInvokeFunctionExpr(InvokeFunctionExpr $ast, $context) {
        $ast->fn->visitExpression($this, $context);
        $this->visitAllExpressions($ast->args, $context);
        return $ast;
    }
    public function visitInstantiateExpr(InstantiateExpr $ast, $context) {
        $ast->classExpr->visitExpression($this, $context);
        $this->visitAllExpressions($ast->args, $context);
        return $ast;
    }
    public function visitLiteralExpr(LiteralExpr $ast, $context) { return $ast; }
    public function visitExternalExpr(ExternalExpr $ast, $context) { return $ast; }
    public function visitConditionalExpr(ConditionalExpr $ast, $context) {
        $ast->condition->visitExpression($this, $context);
        $ast->trueCase->visitExpression($this, $context);
        $ast->falseCase->visitExpression($this, $context);
        return $ast;
    }
    public function visitNotExpr(NotExpr $ast, $context) {
        $ast->condition->visitExpression($this, $context);
        return $ast;
    }
    public function visitCastExpr(CastExpr $ast, $context) {
        $ast->value->visitExpression($this, $context);
        return $ast;
    }
    public function visitFunctionExpr( FunctionExpr $ast, $context) { return $ast; }
    public function visitBinaryOperatorExpr(BinaryOperatorExpr $ast, $context) {
        $ast->lhs->visitExpression($this, $context);
        $ast->rhs->visitExpression($this, $context);
        return $ast;
    }
    public function visitReadPropExpr(ReadPropExpr $ast, $context) {
        $ast->receiver->visitExpression($this, $context);
        return $ast;
    }
    public function visitReadKeyExpr(ReadKeyExpr $ast, $context) {
        $ast->receiver->visitExpression($this, $context);
        $ast->index->visitExpression($this, $context);
        return $ast;
    }
    public function visitLiteralArrayExpr(LiteralArrayExpr $ast, $context) {
        $this->visitAllExpressions($ast->entries, $context);
        return $ast;
    }
    public function visitLiteralMapExpr(LiteralMapExpr $ast, $context) {
        $ast->entries->forEach((entry) => entry.value->visitExpression($this, $context));
    return $ast;
  }
    public function visitAllExpressions(array $exprs, $context): void {
        $exprs->forEach(expr => expr->visitExpression($this, $context));
  }

    public function visitDeclareVarStmt(DeclareVarStmt $stmt, $context) {
        $stmt->value->visitExpression($this, $context);
        return $stmt;
    }
    public function visitDeclareFunctionStmt(DeclareFunctionStmt $stmt, $context) {
        // Don't descend into nested functions
        return $stmt;
    }
    public function visitExpressionStmt(ExpressionStatement $stmt, $context) {
        $stmt->expr->visitExpression($this, $context);
        return $stmt;
    }
    public function visitReturnStmt(ReturnStatement $stmt, $context) {
        $stmt->value->visitExpression($this, $context);
        return $stmt;
    }
    public function visitDeclareClassStmt(ClassStmt $stmt, $context) {
        // Don't descend into nested functions
        return $stmt;
    }
    public function visitIfStmt(IfStmt $stmt, $context) {
        $stmt->condition->visitExpression($this, $context);
        $this->visitAllStatements($stmt->trueCase, $context);
        $this->visitAllStatements($stmt->falseCase, $context);
        return $stmt;
    }
    public function visitTryCatchStmt(TryCatchStmt $stmt, $context) {
        $this->visitAllStatements($stmt->bodyStmts, $context);
        $this->visitAllStatements($stmt->catchStmts, $context);
        return $stmt;
    }
    public function visitThrowStmt(ThrowStmt $stmt, $context) {
        $stmt->error->visitExpression($this, $context);
        return $stmt;
    }
    public function visitCommentStmt(CommentStmt $stmt, $context) { return $stmt; }
    public function visitAllStatements(array $stmts, $context): void {
        $stmts->forEach($stmt => $stmt->visitStatement($this, $context));
  }
}