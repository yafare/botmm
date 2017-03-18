<?php


namespace trans\JavaParser\Output\Visitor;


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
use trans\JavaParser\Output\Expression\NotExpr;
use trans\JavaParser\Output\Expression\ReadKeyExpr;
use trans\JavaParser\Output\Expression\ReadPropExpr;
use trans\JavaParser\Output\Expression\ReadVarExpr;
use trans\JavaParser\Output\Expression\WriteKeyExpr;
use trans\JavaParser\Output\Expression\WritePropExpr;
use trans\JavaParser\Output\Expression\WriteVarExpr;
use trans\JavaParser\Output\StatementVisitor;

class ExpressionTransformer implements StatementVisitor, ExpressionVisitor
{
    public function visitReadVarExpr(ReadVarExpr $ast, $context)
    {
        return $ast;
    }

    public function visitWriteVarExpr(WriteVarExpr $expr, $context)
    {
        return new WriteVarExpr(
            $expr->name, $expr->value->visitExpression($this, $context), $expr->type, $expr->sourceSpan);
    }

    public function visitWriteKeyExpr(WriteKeyExpr $expr, $context)
    {
        return new WriteKeyExpr(
            $expr->receiver->visitExpression($this, $context), $expr->index->visitExpression($this, $context),
            $expr->value->visitExpression($this, $context), $expr->type, $expr->sourceSpan);
    }

    public function visitWritePropExpr(WritePropExpr $expr, $context)
    {
        return new WritePropExpr(
            $expr->receiver->visitExpression($this, $context), $expr->name,
            $expr->value->visitExpression($this, $context), $expr->type, $expr->sourceSpan);
    }

    public function visitInvokeMethodExpr(InvokeMethodExpr $ast, $context)
    {
        const method = $ast->builtin || $ast->name;
        return new InvokeMethodExpr(
            $ast->receiver->visitExpression($this, $context), method,
            $this->visitAllExpressions($ast->args, $context), $ast->type, $ast->sourceSpan);
    }

    public function visitInvokeFunctionExpr(InvokeFunctionExpr $ast, $context)
    {
        return new InvokeFunctionExpr(
            $ast->fn->visitExpression($this, $context), $this->visitAllExpressions($ast->args, $context),
            $ast->type, $ast->sourceSpan);
    }

    public function visitInstantiateExpr(InstantiateExpr $ast, $context)
    {
        return new InstantiateExpr(
            $ast->classExpr->visitExpression($this, $context), $this->visitAllExpressions($ast->args, $context),
            $ast->type, $ast->sourceSpan);
    }

    public function visitLiteralExpr(LiteralExpr $ast, $context)
    {
        return $ast;
    }

    public function visitExternalExpr(ExternalExpr $ast, $context)
    {
        return $ast;
    }

    public function visitConditionalExpr(ConditionalExpr $ast, $context)
    {
        return new ConditionalExpr(
            $ast->condition->visitExpression($this, $context), $ast->trueCase->visitExpression($this, $context),
            $ast->falseCase->visitExpression($this, $context), $ast->type, $ast->sourceSpan);
    }

    public function visitNotExpr(NotExpr $ast, $context)
    {
        return new NotExpr($ast->condition->visitExpression($this, $context), $ast->sourceSpan);
    }

    public function visitCastExpr(CastExpr $ast, $context)
    {
        return new CastExpr($ast->value->visitExpression($this, $context), context, $ast->sourceSpan);
    }

    public function visitFunctionExpr(FunctionExpr $ast, $context)
    {
        // Don't descend into nested functions
        return $ast;
    }

    public function visitBinaryOperatorExpr(BinaryOperatorExpr $ast, $context)
    {
        return new BinaryOperatorExpr(
            $ast->operator, $ast->lhs->visitExpression($this, $context),
            $ast->rhs->visitExpression($this, $context), $ast->type, $ast->sourceSpan);
    }

    public function visitReadPropExpr(ReadPropExpr $ast, $context)
    {
        return new ReadPropExpr(
            $ast->receiver->visitExpression($this, $context), $ast->name, $ast->type, $ast->sourceSpan);
    }

    public function visitReadKeyExpr(ReadKeyExpr $ast, $context)
    {
        return new ReadKeyExpr(
            $ast->receiver->visitExpression($this, $context), $ast->index->visitExpression($this, $context),
            $ast->type, $ast->sourceSpan);
    }

    public function visitLiteralArrayExpr(LiteralArrayExpr $ast, $context)
    {
        return new LiteralArrayExpr(
            $this->visitAllExpressions($ast->entries, context), $ast->type, $ast->sourceSpan);
    }

    public function visitLiteralMapExpr(LiteralMapExpr $ast, $context)
    {
        const entries = $ast->entries . map(
                (entry): LiteralMapEntry => new LiteralMapEntry(
        entry . key, entry . value->visitExpression($this, $context), entry . quoted, ));
    const mapType = new MapType($ast->valueType);
    return new LiteralMapExpr(entries, mapType, $ast->sourceSpan);
  }

    public function visitAllExpressions(array $exprs, $context)/*: Expression[]*/ {
        return $exprs->map($expr => $expr->visitExpression($this, $context));
    }

public function visitDeclareVarStmt(DeclareVarStmt $stmt, $context)
{
    return new DeclareVarStmt(
        $stmt->name, $stmt->value->visitExpression($this, $context), $stmt->type, $stmt->modifiers,
        $stmt->sourceSpan);
}
public function visitDeclareFunctionStmt(DeclareFunctionStmt $stmt, $context)
{
    // Don't descend into nested functions
    return $stmt;
}

public function visitExpressionStmt(ExpressionStatement $stmt, $context)
{
    return new ExpressionStatement($stmt->expr->visitExpression($this, $context), $stmt->sourceSpan);
}

public function visitReturnStmt(ReturnStatement $stmt, $context)
{
    return new ReturnStatement($stmt->value->visitExpression($this, $context), $stmt->sourceSpan);
}

public function visitDeclareClassStmt(ClassStmt $stmt, $context)
{
    // Don't descend into nested functions
    return $stmt;
}

public function visitIfStmt(IfStmt $stmt, $context)
{
    return new IfStmt(
        $stmt->condition->visitExpression($this, $context),
        $this->visitAllStatements($stmt->trueCase, $context),
        $this->visitAllStatements($stmt->falseCase, $context), $stmt->sourceSpan);
}

public function visitTryCatchStmt(TryCatchStmt $stmt, $context)
{
    return new TryCatchStmt(
        $this->visitAllStatements($stmt->bodyStmts, $context),
        $this->visitAllStatements($stmt->catchStmts, $context), $stmt->sourceSpan);
}

public function visitThrowStmt(ThrowStmt $stmt, $context)
{
    return new ThrowStmt($stmt->error->visitExpression($this, $context), $stmt->sourceSpan);
}

public function visitCommentStmt(CommentStmt $stmt, $context)
{
    return $stmt;
}

public function visitAllStatements(array $stmts, $context): Statement[] {
    return $stmts . map(stmt => $stmt->visitStatement($this, $context));
  }
}