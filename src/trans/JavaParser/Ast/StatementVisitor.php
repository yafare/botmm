<?php


namespace trans\JavaParser\Output;


use trans\JavaParser\Ast\AstVisitor;
use trans\JavaParser\Ast\Statement\AssertStmt;
use trans\JavaParser\Ast\Statement\BlockStmt;
use trans\JavaParser\Ast\Statement\BreakStmt;
use trans\JavaParser\Ast\Statement\ClassStmt;
use trans\JavaParser\Ast\Statement\CommentStmt;
use trans\JavaParser\Ast\Statement\ContinueStmt;
use trans\JavaParser\Ast\Statement\DeclareFunctionStmt;
use trans\JavaParser\Ast\Statement\DeclareVarStmt;
use trans\JavaParser\Ast\Statement\DoStmt;
use trans\JavaParser\Ast\Statement\EmptyStmt;
use trans\JavaParser\Ast\Statement\ExplicitConstructorInvocationStmt;
use trans\JavaParser\Ast\Statement\ExpressionStmt;
use trans\JavaParser\Ast\Statement\ForeachStmt;
use trans\JavaParser\Ast\Statement\ForStmt;
use trans\JavaParser\Ast\Statement\IfStmt;
use trans\JavaParser\Ast\Statement\LabeledStmt;
use trans\JavaParser\Ast\Statement\LocalClassDeclarationStmt;
use trans\JavaParser\Ast\Statement\ReturnStatement;
use trans\JavaParser\Ast\Statement\SwitchEntryStmt;
use trans\JavaParser\Ast\Statement\SwitchStmt;
use trans\JavaParser\Ast\Statement\SynchronizedStmt;
use trans\JavaParser\Ast\Statement\ThrowStmt;
use trans\JavaParser\Ast\Statement\TryCatchStmt;
use trans\JavaParser\Ast\Statement\WhileStmt;

interface StatementVisitor extends AstVisitor
{
    public function visitDeclareVarStmt(DeclareVarStmt $stmt, $context);

    public function visitDeclareFunctionStmt(DeclareFunctionStmt $stmt, $context);

    public function visitExpressionStmt(ExpressionStmt $stmt, $context);

    public function visitReturnStmt(ReturnStatement $stmt, $context);

    public function visitDeclareClassStmt(ClassStmt $stmt, $context);

    public function visitIfStmt(IfStmt $stmt, $context);

    public function visitTryCatchStmt(TryCatchStmt $stmt, $context);

    public function visitThrowStmt(ThrowStmt $stmt, $context);

    public function visitCommentStmt(CommentStmt $stmt, $context);

    public function visitAssertStmt(AssertStmt $stmt, $context);

    public function visitBlockStmt(BlockStmt $stmt, $context);

    public function visitBreakStmt(BreakStmt $stmt, $context);

    public function visitContinueStmt(ContinueStmt $stmt, $context);

    public function visitDoStmt(DoStmt $stmt, $context);

    public function visitEmptyStmt(EmptyStmt $stmt, $context);

    public function visitExplicitConstructorInvocationStmt(ExplicitConstructorInvocationStmt $stmt, $context);

    public function visitForStmt(ForStmt $stmt, $context);

    public function visitForeachStmt(ForeachStmt $stmt, $context);

    public function visitLabeledStmt(LabeledStmt $stmt, $context);

    public function visitLocalClassDeclarationStmt(LocalClassDeclarationStmt $stmt, $context);

    public function visitSwitchEntryStmt(SwitchEntryStmt $stmt, $context);

    public function visitSwitchStmt(SwitchStmt $stmt, $context);

    public function visitSynchronizedStmt(SynchronizedStmt $stmt, $context);

    public function visitWhileStmt(WhileStmt $stmt, $context);
}