<?php


namespace trans\JavaCompiler\Output;


//// Types

use trans\JavaCompiler\Ast\ParseSourceSpan;
use trans\JavaCompiler\Output\Expression\FunctionExpr;
use trans\JavaCompiler\Output\Expression\LiteralExpr;
use trans\JavaCompiler\Output\Expression\ReadVarExpr;
use trans\JavaCompiler\Output\Visitor\_ReplaceVariableTransformer;
use trans\JavaCompiler\Output\Visitor\_VariableFinder;

class TypeModifier
{
    public const Const = 'const';
}


class BuiltinTypeName
{
    public const Dynamic  = "dynamic";
    public const Bool     = "bool";
    public const String   = "string";
    public const Int      = "int";
    public const Number   = "number";
    public const Function = "function";
    public const Null     = "null";
}


///// Expressions

class BinaryOperator
{
    public const  Equals       = "equals";
    public const  NotEquals    = "notEquals";
    public const  Identical    = "identical";
    public const  NotIdentical = "notIdentical";
    public const  Minus        = "minus";
    public const  Plus         = "plus";
    public const  Divide       = "divide";
    public const  Multiply     = "multiply";
    public const  Modulo       = "modulo";
    public const And           = "and";
    public const Or            = "or";
    public const  Lower        = "lower";
    public const  LowerEquals  = "lowerEquals";
    public const  Bigger       = "bigger";
    public const  BiggerEquals = "biggerEquals";
}


class BuiltinVar
{
    public const   This       = "this";
    public const   Super      = "parent::__construct";
    public const   CatchError = "catchError";
    public const   CatchStack = "catchStack";
}


class BuiltinMethod
{
    public const  ConcatArray         = "concatArray";
    public const  SubscribeObservable = "subscribeObservable";
    public const  Bind                = "bind";
}


class FnParam
{
    public $name;
    public $type;

    public function __construct(string $name, Type $type = null)
    {
        $this->name = $name;
        $this->type = $type;
    }
}


class LiteralMapEntry
{
    public $key;
    public $value;
    public $quoted;

    public function __construct(string $key, Expression $value, boolean $quoted = false)
    {
        $this->key    = $key;
        $this->value  = $value;
        $this->quoted = $quoted;
    }
}


//// Statements
class StmtModifier
{
    public const Final   = "final";
    public const Private = "private";
}


function replaceVarInExpression(
    varstring $name,
    newExpression $value,
    Expression $expression
): Expression {
    $transformer = new _ReplaceVariableTransformer($varName, $newValue);
    return $expression->visitExpression($transformer, null);
}


function findReadVarNames(array $stmts)/*: Set<string >*/
{
    $finder = new _VariableFinder();
    $finder->visitAllStatements($stmts, null);
    return $finder->varNames;
}


class OutPutAst
{
    public static $THIS_EXPR;
    public static $SUPER_EXPR;
    public static $CATCH_ERROR_VAR;
    public static $CATCH_STACK_VAR;
    public static $NULL_EXPR;
    public static $TYPED_NULL_EXPR;

    public function __construct()
    {
        self::$THIS_EXPR       = new ReadVarExpr(BuiltinVar::This);
        self::$SUPER_EXPR      = new ReadVarExpr(BuiltinVar::Super);
        self::$CATCH_ERROR_VAR = new ReadVarExpr(BuiltinVar::CatchError);
        self::$CATCH_STACK_VAR = new ReadVarExpr(BuiltinVar::CatchStack);
        self::$NULL_EXPR       = new LiteralExpr(null, null);
        self::$TYPED_NULL_EXPR = new LiteralExpr(null, NULL_TYPE);
    }

    public static function variable(
        string $name,
        Type $type = null,
        ParseSourceSpan $sourceSpan
    ): ReadVarExpr {
        return new ReadVarExpr($name, $type, $sourceSpan);
    }

    public static function importExpr(
        CompileIdentifierMetadata $id,
        array $typeParams = null,
        ParseSourceSpan $sourceSpan
    ): ExternalExpr {
        return new ExternalExpr($id, null, $typeParams, $sourceSpan);
    }

    public static function importType(
        CompileIdentifierMetadata $id,
        array $typeParams = null,
        array $typeModifiers = null
    ): ExpressionType {
        return isPresent($id) ? expressionType(importExpr($id, $typeParams), $typeModifiers) : null;
    }

    public static function expressionType(
        Expression $expr,
        array $typeModifiers = null
    ): ExpressionType {
        return isPresent($expr) ? new ExpressionType($expr, $typeModifiers) : null;
    }

    public static function literalArr(
        array $values,
        Type $type = null,
        ParseSourceSpan $sourceSpan
    ): LiteralArrayExpr {
        return new LiteralArrayExpr($values, $type, $sourceSpan);
    }

    public static function literalMap(
        $values,
        MapType $type = null,
        boolean $quoted = false
    ): LiteralMapExpr {
        return new LiteralMapExpr(
            $values->map($entry => new LiteralMapEntry($entry[0], $entry[1], $quoted)), $type);
}

    public static function not(Expression $expr, ParseSourceSpan $sourceSpan): NotExpr
    {
        return new NotExpr($expr, $sourceSpan);
    }

    public static function fn(
        array $params,
        array $body,
        Type $type = null,
        ParseSourceSpan $sourceSpan
    ): FunctionExpr {
        return new FunctionExpr($params, $body, $type, $sourceSpan);
    }

    public static function literal($value, Type $type = null, ParseSourceSpan $sourceSpan): LiteralExpr
    {
        return new LiteralExpr($value, $type, $sourceSpan);
    }
}