<?php


namespace trans\JavaCompiler\Output;


use trans\JavaCompiler\Ast\Statement\AssertStmt;
use trans\JavaCompiler\Ast\Statement\BlockStmt;
use trans\JavaCompiler\Ast\Statement\BreakStmt;
use trans\JavaCompiler\Ast\Statement\ClassStmt;
use trans\JavaCompiler\Ast\Statement\CommentStmt;
use trans\JavaCompiler\Ast\Statement\ContinueStmt;
use trans\JavaCompiler\Ast\Statement\DeclareFunctionStmt;
use trans\JavaCompiler\Ast\Statement\DeclareVarStmt;
use trans\JavaCompiler\Ast\Statement\DoStmt;
use trans\JavaCompiler\Ast\Statement\EmptyStmt;
use trans\JavaCompiler\Ast\Statement\ExplicitConstructorInvocationStmt;
use trans\JavaCompiler\Ast\Statement\ExpressionStmt;
use trans\JavaCompiler\Ast\Statement\ForeachStmt;
use trans\JavaCompiler\Ast\Statement\ForStmt;
use trans\JavaCompiler\Ast\Statement\IfStmt;
use trans\JavaCompiler\Ast\Statement\LabeledStmt;
use trans\JavaCompiler\Ast\Statement\LocalClassDeclarationStmt;
use trans\JavaCompiler\Ast\Statement\ReturnStatement;
use trans\JavaCompiler\Ast\Statement\SwitchEntryStmt;
use trans\JavaCompiler\Ast\Statement\SwitchStmt;
use trans\JavaCompiler\Ast\Statement\SynchronizedStmt;
use trans\JavaCompiler\Ast\Statement\ThrowStmt;
use trans\JavaCompiler\Ast\Statement\TryCatchStmt;
use trans\JavaCompiler\Ast\Statement\WhileStmt;

interface StatementVisitor
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