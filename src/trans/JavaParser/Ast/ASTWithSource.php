<?php


namespace trans\JavaParser\Ast;


class ASTWithSource extends AST
{
    public $ast;
    public $source;
    public $location;
    public $errors;

    public function __construct(
        AST $ast,
        string $source,
        ?string $location,
        array $errors
    ) {
        parent::__construct(new ParseSpan(0, empty($source) ? 0 : strlen($source)));
        $this->ast      = $ast;
        $this->source   = $source;
        $this->location = $location;
        $this->errors   = $errors;
    }

    public function visit(AstVisitor $visitor, $context = null)
    {
        return $this->ast->visit($visitor, $context);
    }

    public function toString(): string
    {
        return "{$this->source} in {$this->location}";
    }
}

