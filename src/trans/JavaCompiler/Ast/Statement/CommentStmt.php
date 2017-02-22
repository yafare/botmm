<?php


namespace trans\JavaCompiler\Ast\Statement;


class CommentStmt extends Statement
{
    public $comment;

    public function __construct(string $comment, ParseSourceSpan $sourceSpan)
    {
        parent::__construct(null, $sourceSpan);
        $this->comment = $comment;
    }

    public function visitStatement(StatementVisitor $visitor, $context)
    {
        return $visitor->visitCommentStmt($this, $context);
    }
}