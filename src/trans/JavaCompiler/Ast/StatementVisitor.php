<?php


namespace trans\JavaCompiler\Output;


use trans\JavaCompiler\Ast\Statement\ClassStmt;
use trans\JavaCompiler\Ast\Statement\CommentStmt;
use trans\JavaCompiler\Ast\Statement\DeclareFunctionStmt;
use trans\JavaCompiler\Ast\Statement\DeclareVarStmt;
use trans\JavaCompiler\Ast\Statement\ExpressionStatement;
use trans\JavaCompiler\Ast\Statement\IfStmt;
use trans\JavaCompiler\Ast\Statement\ReturnStatement;
use trans\JavaCompiler\Ast\Statement\ThrowStmt;
use trans\JavaCompiler\Ast\Statement\TryCatchStmt;

interface StatementVisitor
{
    public function visitDeclareVarStmt(DeclareVarStmt $stmt, $context);

    public function visitDeclareFunctionStmt(DeclareFunctionStmt $stmt, $context);

    public function visitExpressionStmt(ExpressionStatement $stmt, $context);

    public function visitReturnStmt(ReturnStatement $stmt, $context);

    public function visitDeclareClassStmt(ClassStmt $stmt, $context);

    public function visitIfStmt(IfStmt $stmt, $context);

    public function visitTryCatchStmt(TryCatchStmt $stmt, $context);

    public function visitThrowStmt(ThrowStmt $stmt, $context);

    public function visitCommentStmt(CommentStmt $stmt, $context);
}