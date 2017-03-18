<?php


namespace trans\JavaParser\Ast\Statement;


use trans\JavaParser\Ast\ParseSourceSpan;
use trans\JavaParser\Output\StatementVisitor;

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