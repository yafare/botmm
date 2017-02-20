<?php


namespace trans\JavaCompiler\Ast\Statement;


use trans\JavaCompiler\Output\StatementVisitor;
use trans\JavaCompiler\Wrapper\ArrayWrapper;

abstract class Statement
{
    /**
     * @var StmtModifier[]
     */
    public $modifiers;
    /**
     * @var ParseSourceSpan
     */
    public $sourceSpan;

    public function __construct($modifiers, $sourceSpan = null)
    {
        $this->modifiers  = $modifiers;
        $this->sourceSpan = $sourceSpan;
        if (!$modifiers) {
            $this->modifiers = [];
        }
    }

    public abstract function visitStatement(StatementVisitor $visitor, $context);

    public function hasModifier(StmtModifier $modifier): bool
    {
        return ArrayWrapper::indexOf($this->modifiers, $modifier) !== -1;
    }
}

class StmtModifier {
    public const Final = 'final';
    public const Private = 'private';
    public const Public = 'public';

}
class DeclareVarStmt extends Statement
{
    public $type;
    public $name;
    public $value;

    public function __construct(
        string $name, Expression $value, Type $type = null,
        array $modifiers = null, ParseSourceSpan $sourceSpan)
    {
        parent::__construct($modifiers, $sourceSpan);
        $this->type = isset($type) ? $type : $value->type;
        $this->name = $name;
        $this->value = $value;
    }

    public function visitStatement(StatementVisitor $visitor, $context)
    {
        return $visitor->visitDeclareVarStmt($this, $context);
    }
}

class DeclareFunctionStmt extends Statement
{
    public $name;
    public $params;
    public $statements;
    public $type;

    public function __construct(
        string $name, array $params, array $statements,
        Type $type = null, array $modifiers = null, ParseSourceSpan $sourceSpan)
    {
        parent::__construct($modifiers, $sourceSpan);
        $this->name=$name;
        $this->params=$params;
        $this->statements=$statements;
        $this->type=$type;

    }

    public function visitStatement(StatementVisitor $visitor, $context)
    {
        return $visitor->visitDeclareFunctionStmt($this, $context);
    }
}

class ExpressionStatement extends Statement
{
    public $expr;

    public function __construct(Expression $expr, ParseSourceSpan $sourceSpan)
    {
        parent::__construct(null, $sourceSpan);
        $this->expr = $expr;
    }

    public function visitStatement(StatementVisitor $visitor, $context)
    {
        return $visitor->visitExpressionStmt($this, $context);
    }
}


class ReturnStatement extends Statement
{
    public $value;

    public function __construct(Expression $value, ParseSourceSpan $sourceSpan)
    {
        parent::__construct(null, $sourceSpan);
        $this->value=$value;
    }

    public function visitStatement(StatementVisitor $visitor, $context)
    {
        return $visitor->visitReturnStmt($this, $context);
    }
}