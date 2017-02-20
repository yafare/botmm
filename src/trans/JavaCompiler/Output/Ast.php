<?php


namespace trans\JavaCompiler\Output;


/**
 * @license
 * Copyright Google Inc. All Rights Reserved.
 *
 * Use of this source code is governed by an MIT-style license that can be
 * found in the LICENSE file at https://angular.io/license
 */

//现在Statement翻译到 ../Ast/Satement

import {CompileIdentifierMetadata} from '../compile_metadata';
import {isPresent} from '../facade/lang';
import {ParseSourceSpan} from '../parse_util';

//// Types
 class TypeModifier {
     public const Const='const';
 }

 abstract class Type
 {
     public $modifiers;

     public function __construct(array $modifiers = null)
     {
         if (!$modifiers) {
             $this->$modifiers = [];
         }
         $this->modifiers=$modifiers;
     }

     abstract public function visitType(TypeVisitor $visitor, $context);

     public function hasModifier(TypeModifier $modifier): boolean
     {
         return $this->modifiers . indexOf(modifier) !== -1;
     }
 }

 class BuiltinTypeName
 {
     public const Dynamic = "dynamic";
     public const Bool = "bool";
     public const String = "string";
     public const Int = "int";
     public const Number = "number";
     public const Function = "function";
     public const Null = "null";
 }

 class BuiltinType extends Type
 {
     public $name;

     public function __construct(BuiltinTypeName $name, array $modifiers = null)
     {
         parent::__construct($modifiers);
         $this->name=$name;
     }

     public function visitType(TypeVisitor $visitor, $context)
     {
         return $visitor->visitBuiltintType($this, $context);
     }
 }

 class ExpressionType extends Type
 {
     public $value;

     public function __construct(Expression $value, array $modifiers = null)
     {
         parent::__construct($modifiers);
         $this->value=$value;
     }

     public function visitType(TypeVisitor $visitor, $context)
     {
         return $visitor->visitExpressionType($this, $context);
     }
 }


 class ArrayType extends Type
 {
     public $of;

     public function __construct(Type $of, array $modifiers = null)
     {
         parent::__construct($modifiers);
         $this->of=$of;
     }

     public function visitType(TypeVisitor $visitor, $context)
     {
         return $visitor->visitArrayType($this, $context);
     }
 }


 class MapType extends Type
 {
     public $valueType;

     public function __construct(Type $valueType, array $modifiers = null)
     {
         parent::__construct($modifiers);
         $this->valueType=$valueType;
     }

     public function visitType(TypeVisitor $visitor, $context)
     {
         return $visitor->visitMapType($this, $context);
     }
 }

 const DYNAMIC_TYPE = new BuiltinType(BuiltinTypeName.Dynamic);
 const BOOL_TYPE = new BuiltinType(BuiltinTypeName.Bool);
 const INT_TYPE = new BuiltinType(BuiltinTypeName.Int);
 const NUMBER_TYPE = new BuiltinType(BuiltinTypeName.Number);
 const STRING_TYPE = new BuiltinType(BuiltinTypeName.String);
 const FUNCTION_TYPE = new BuiltinType(BuiltinTypeName.Function);
 const NULL_TYPE = new BuiltinType(BuiltinTypeName.Null);

 interface TypeVisitor
 {
     public function visitBuiltintType(BuiltinType $type, $context);

     public function visitExpressionType(ExpressionType $type, $context);

     public function visitArrayType(ArrayType $type, $context);

     public function visitMapType(MapType $type, $context);
 }

///// Expressions

 class BinaryOperator
 {
     public const  Equals = "equals";
     public const NotEquals = "notEquals";
     public const Identical = "identical";
     public const NotIdentical = "notIdentical";
     public const Minus = "minus";
     public const Plus = "plus";
     public const Divide = "divide";
     public const Multiply = "multiply";
     public const Modulo = "modulo";
     public const And = "and";
     public const Or = "or";
     public const Lower = "lower";
     public const LowerEquals = "lowerEquals";
     public const Bigger = "bigger";
     public const BiggerEquals = "biggerEquals";
 }

 abstract class Expression
 {
     public $type;
     public $sourceSpan;

     public function __construct(Type $type, ParseSourceSpan $sourceSpan)
     {
         $this->type = $type;
         $this->sourceSpan = $sourceSpan;
     }

     abstract public function visitExpression(ExpressionVisitor $visitor, $context);

     public function prop(string $name, ParseSourceSpan $sourceSpan): ReadPropExpr
     {
         return new ReadPropExpr($this, $name, null, $sourceSpan);
     }

     public function key(Expression $index, Type $type = null, ParseSourceSpan $sourceSpan): ReadKeyExpr
     {
         return new ReadKeyExpr($this, $index, $type, $sourceSpan);
     }

     public function callMethod($name, array $params, ParseSourceSpan $sourceSpan):
     InvokeMethodExpr
     {
         return new InvokeMethodExpr($this, $name, $params, null, $sourceSpan);
     }

     public function callFn(array $params, ParseSourceSpan $sourceSpan): InvokeFunctionExpr
     {
         return new InvokeFunctionExpr($this, $params, null, $sourceSpan);
     }

     public function instantiate(array $params, Type $type = null, ParseSourceSpan $sourceSpan):
     InstantiateExpr
     {
         return new InstantiateExpr($this, $params, $type, $sourceSpan);
     }

     public function conditional(Expression $trueCase, Expression $falseCase = null, ParseSourceSpan $sourceSpan):
     ConditionalExpr
     {
         return new ConditionalExpr($this, $trueCase, $falseCase, null, $sourceSpan);
     }

     public function equals(Expression $rhs, ParseSourceSpan $sourceSpan): BinaryOperatorExpr
     {
         return new BinaryOperatorExpr(BinaryOperator::Equals, $this, $rhs, null, $sourceSpan);
     }

     public function notEquals(Expression $rhs, ParseSourceSpan $sourceSpan): BinaryOperatorExpr
     {
         return new BinaryOperatorExpr(BinaryOperator::NotEquals, $this, $rhs, null, $sourceSpan);
     }

     public function identical(Expression $rhs, ParseSourceSpan $sourceSpan): BinaryOperatorExpr
     {
         return new BinaryOperatorExpr(BinaryOperator::Identical, $this, $rhs, null, $sourceSpan);
     }

     public function notIdentical(Expression $rhs, ParseSourceSpan $sourceSpan): BinaryOperatorExpr
     {
         return new BinaryOperatorExpr(BinaryOperator::NotIdentical, $this, $rhs, null, $sourceSpan);
     }

     public function minus(Expression $rhs, ParseSourceSpan $sourceSpan): BinaryOperatorExpr
     {
         return new BinaryOperatorExpr(BinaryOperator::Minus, $this, $rhs, null, $sourceSpan);
     }

     public function plus(Expression $rhs, ParseSourceSpan $sourceSpan): BinaryOperatorExpr
     {
         return new BinaryOperatorExpr(BinaryOperator::Plus, $this, $rhs, null, $sourceSpan);
     }

     public function divide(Expression $rhs, ParseSourceSpan $sourceSpan): BinaryOperatorExpr
     {
         return new BinaryOperatorExpr(BinaryOperator::Divide, $this, $rhs, null, $sourceSpan);
     }

     public function multiply(Expression $rhs, ParseSourceSpan $sourceSpan): BinaryOperatorExpr
     {
         return new BinaryOperatorExpr(BinaryOperator::Multiply, $this, $rhs, null, $sourceSpan);
     }

     public function modulo(Expression $rhs, ParseSourceSpan $sourceSpan): BinaryOperatorExpr
     {
         return new BinaryOperatorExpr(BinaryOperator::Modulo, $this, $rhs, null, $sourceSpan);
     }

     public function and (Expression $rhs, ParseSourceSpan $sourceSpan): BinaryOperatorExpr
     {
         return new BinaryOperatorExpr(BinaryOperator:: And, $this, $rhs, null, $sourceSpan);
     }

     public function or (Expression $rhs, ParseSourceSpan $sourceSpan): BinaryOperatorExpr
     {
         return new BinaryOperatorExpr(BinaryOperator:: Or, $this, $rhs, null, $sourceSpan);
     }

     public function lower(Expression $rhs, ParseSourceSpan $sourceSpan): BinaryOperatorExpr
     {
         return new BinaryOperatorExpr(BinaryOperator::Lower, $this, $rhs, null, $sourceSpan);
     }

     public function lowerEquals(Expression $rhs, ParseSourceSpan $sourceSpan): BinaryOperatorExpr
     {
         return new BinaryOperatorExpr(BinaryOperator::LowerEquals, $this, $rhs, null, $sourceSpan);
     }

     public function bigger(Expression $rhs, ParseSourceSpan $sourceSpan): BinaryOperatorExpr
     {
         return new BinaryOperatorExpr(BinaryOperator::Bigger, $this, $rhs, null, $sourceSpan);
     }

     public function biggerEquals(Expression $rhs, ParseSourceSpan $sourceSpan): BinaryOperatorExpr
     {
         return new BinaryOperatorExpr(BinaryOperator::BiggerEquals, $this, $rhs, null, $sourceSpan);
     }

     public function isBlank(ParseSourceSpan $sourceSpan): Expression
     {
         // Note: We use equals by purpose here to compare to null and undefined in JS.
         // We use the typed null to allow strictNullChecks to narrow types.
         return $this->equals(TYPED_NULL_EXPR, $sourceSpan);
     }

     public function cast(Type $type, ParseSourceSpan $sourceSpan): Expression
     {
         return new CastExpr($this, $type, $sourceSpan);
     }

     public function toStmt(): Statement
     {
         return new ExpressionStatement($this);
     }
 }

 class BuiltinVar
 {
     public const   This = "this";
     public const Super = "parent::__construct";
     public const CatchError = "catchError";
     public const CatchStack = "catchStack";
 }

 class ReadVarExpr extends Expression
 {
     public $name;
     public $builtin;

     public function __construct($name, Type $type = null, ParseSourceSpan $sourceSpan)
     {
         parent::__construct($type, $sourceSpan);
         if (gettype($name)  === 'string') {
             $this->name = $name;
             $this->builtin = null;
         } else {
             $this->name = null;
             $this->builtin = <BuiltinVar > $name;
    }
     }

     public function visitExpression(ExpressionVisitor $visitor, $context)
     {
         return $visitor->visitReadVarExpr($this, $context);
     }

     public function set(Expression $value): WriteVarExpr
     {
         return new WriteVarExpr($this->name, $value, null, $this->sourceSpan);
     }
 }


 class WriteVarExpr extends Expression
 {
     public $value;
     public $name;

     public function __construct(string $name, Expression $value, Type $type = null, ParseSourceSpan $sourceSpan)
     {
         parent::__construct(isset($type) ? $type : $value->type, $sourceSpan);
         $this->value = $value;
         $this->name = $name;
     }

     public function visitExpression(ExpressionVisitor $visitor, $context)
     {
         return $visitor->visitWriteVarExpr($this, $context);
     }

     public function toDeclStmt(Type $type = null, array $modifiers = null): DeclareVarStmt
     {
         return new DeclareVarStmt($this->name, $this->value, $type, $modifiers, $this->sourceSpan);
     }
 }


 class WriteKeyExpr extends Expression
 {
     public $value;
     public $receiver;
     public $index;

     public function __construct( Expression $receiver, Expression $index, Expression $value, Type $type = null,ParseSourceSpan $sourceSpan)
     {
         parent::__construct(isset($type) ? $type : $value->type, $sourceSpan);
         $this->value = $value;
         $this->receiver=$receiver;
         $this->index=$index;
     }

     public function visitExpression(ExpressionVisitor $visitor, $context)
     {
         return $visitor->visitWriteKeyExpr($this, $context);
     }
 }


 class WritePropExpr extends Expression
 {
     public $value;
     public $receiver;
     public $name;

     public function __construct(Expression $receiver, string $name, Expression $value, Type $type = null,ParseSourceSpan $sourceSpan)
     {
         parent::__construct(isset($type) ? $type : $value->type, $sourceSpan);
         $this->value = $value;
         $this->receiver=$receiver;
         $this->name=$name;
     }

     public function visitExpression(ExpressionVisitor $visitor, $context)
     {
         return $visitor->visitWritePropExpr($this, $context);
     }
 }

 class BuiltinMethod {
 public const  ConcatArray="concatArray";
 public const SubscribeObservable="subscribeObservable";
 public const Bind="bind";
}

 class InvokeMethodExpr extends Expression
 {
     public $name;
     public $builtin;
     public $receiver;
     public $method;
     public $args;

     public function __construct(Expression $receiver, $method, array $args, Type $type = null, ParseSourceSpan $sourceSpan)
     {
         parent::__construct($type, $sourceSpan);
         if (gettype($method) === 'string') {
             $this->name = $method;
             $this->builtin = null;
         } else {
             $this->name = null;
             $this->builtin =<BuiltinMethod >  $method;
         }
         $this->receiver=$receiver;
         $this->method=$method;
         $this->args=$args;
     }

     public function visitExpression(ExpressionVisitor $visitor, $context)
     {
         return $visitor->visitInvokeMethodExpr($this, $context);
     }
 }


 class InvokeFunctionExpr extends Expression
 {
     public $fn;
     public $args;

     public function __construct(
         Expression $fn, array $args, Type $type = null,
         ParseSourceSpan $sourceSpan)
     {
         parent::__construct($type, $sourceSpan);
         $this->fn=$fn;
         $this->args=$args;
     }

     public function visitExpression(ExpressionVisitor $visitor, $context)
     {
         return $visitor->visitInvokeFunctionExpr($this, $context);
     }
 }


 class InstantiateExpr extends Expression
 {
     public $classExpr;
     public $args;

     public function __construct(
         Expression $classExpr, array $args, Type $type,
         ParseSourceSpan $sourceSpan)
     {
         parent::__construct($type, $sourceSpan);
         $this->classExpr=$classExpr;
         $this->args=$args;
     }

     public function visitExpression(ExpressionVisitor $visitor, $context)
     {
         return $visitor->visitInstantiateExpr($this, $context);
     }
 }


 class LiteralExpr extends Expression
 {
     public $value;

     public function __construct($value, Type $type = null, ParseSourceSpan $sourceSpan)
     {
         parent::__construct($type, $sourceSpan);
         $this->value=$value;
     }

     public function visitExpression(ExpressionVisitor $visitor, $context)
     {
         return $visitor->visitLiteralExpr($this, $context);
     }
 }


 class ExternalExpr extends Expression
 {
     public $value;
     public $typeParams;

     public function __construct(
         CompileIdentifierMetadata $value, Type $type = null, array $typeParams = null,
         ParseSourceSpan $sourceSpan)
     {
         parent::__construct($type, $sourceSpan);
         $this->value=$value;
         $this->typeParams=$typeParams;
     }

     public function visitExpression(ExpressionVisitor $visitor, $context)
     {
         return $visitor->visitExternalExpr($this, $context);
     }
 }


 class ConditionalExpr extends Expression
 {
     public $trueCase;
     public $condition;
     public $falseCase;

     public function __construct(
         Expression $condition, Expression $trueCase, Expression $falseCase = null,
         Type $type = null, ParseSourceSpan $sourceSpan)
     {
         parent::__construct(isset($type) ? $type : $trueCase->type, $sourceSpan);
         $this->trueCase = $trueCase;
         $this->condition=$condition;
         $this->falseCase=$falseCase;
     }

     public function visitExpression(ExpressionVisitor $visitor, $context)
     {
         return $visitor->visitConditionalExpr($this, $context);
     }
 }


 class NotExpr extends Expression
 {
     public $condition;

     public function __construct(Expression $condition, ParseSourceSpan $sourceSpan)
     {
         parent::__construct(BOOL_TYPE, $sourceSpan);
         $this->condition=$condition;
     }

     public function visitExpression(ExpressionVisitor $visitor, $context)
     {
         return $visitor->visitNotExpr($this, $context);
     }
 }

 class CastExpr extends Expression
 {
     public $value;

     public function __construct(Expression $value, Type $type, ParseSourceSpan $sourceSpan)
     {
         parent::__construct($type, $sourceSpan);
         $this->value=$value;
     }

     public function visitExpression(ExpressionVisitor $visitor, $context)
     {
         return $visitor->visitCastExpr($this, $context);
     }
 }


 class FnParam
 {
     public $name;
     public $type;

     public function __construct(string $name, Type $type = null)
     {
         $this->name=$name;
         $this->type=$type;
     }
 }


 class FunctionExpr extends Expression
 {
     public $params;
     public $statements;

     public function __construct(
         array $params, array $statements, Type $type = null,
         ParseSourceSpan $sourceSpan)
     {
         parent::__construct($type, $sourceSpan);
         $this->params=$params;
         $this->statements=$statements;
     }

     public function visitExpression(ExpressionVisitor $visitor, $context)
     {
         return $visitor->visitFunctionExpr($this, $context);
     }

     public function toDeclStmt(string $name, array $modifiers = null): DeclareFunctionStmt
     {
         return new DeclareFunctionStmt(
             $name, $this->params, $this->statements, $this->type, $modifiers, $this->sourceSpan);
     }
 }


 class BinaryOperatorExpr extends Expression
 {
     public $lhs;
     public $operator;
     public $rhs;

     public function __construct(
         BinaryOperator $operator, Expression $lhs, Expression $rhs, Type $type = null,
         ParseSourceSpan $sourceSpan)
     {
         parent::__construct(isset($type) ? $type : $lhs->type, $sourceSpan);
         $this->lhs = $lhs;
         $this->operator=$operator;
         $this->rhs=$rhs;
     }

     public function visitExpression(ExpressionVisitor $visitor, $context)
     {
         return $visitor->visitBinaryOperatorExpr($this, $context);
     }
 }


 class ReadPropExpr extends Expression
 {
     public $receiver;
     public $name;

     public function __construct(
         Expression $receiver, string $name, Type $type = null,
         ParseSourceSpan $sourceSpan)
     {
         parent::__construct($type, $sourceSpan);
         $this->receiver=$receiver;
         $this->name=$name;
     }

     public function visitExpression(ExpressionVisitor $visitor, $context)
     {
         return $visitor->visitReadPropExpr($this, $context);
     }

     public function set(Expression $value): WritePropExpr
     {
         return new WritePropExpr($this->receiver, $this->name, $value, null, $this->sourceSpan);
     }
 }


 class ReadKeyExpr extends Expression
 {
     public $receiver;
     public $index;

     public function __construct(
         Expression $receiver, Expression $index, Type $type = null,
         ParseSourceSpan $sourceSpan)
     {
         parent::__construct($type, $sourceSpan);
         $this->receiver=$receiver;
         $this->index=$index;
     }

     public function visitExpression(ExpressionVisitor $visitor, $context)
     {
         return $visitor->visitReadKeyExpr($this, $context);
     }

     public function set(Expression $value): WriteKeyExpr
     {
         return new WriteKeyExpr($this->receiver, $this->index, $value, null, $this->sourceSpan);
     }
 }


 class LiteralArrayExpr extends Expression
 {
     public $entries;

     public function __construct(array $entries, Type $type = null, ParseSourceSpan $sourceSpan)
     {
         parent::__construct($type, $sourceSpan);
         $this->entries = $entries;
     }

     public function visitExpression(ExpressionVisitor $visitor, $context)
     {
         return $visitor->visitLiteralArrayExpr($this, $context);
     }
 }

 class LiteralMapEntry
 {
     public $key;
     public $value;
     public $quoted;

     public function __construct(string $key, Expression $value, boolean $quoted = false)
     {
         $this->key = $key;
         $this->value = $value;
         $this->quoted = $quoted;
     }
 }

 class LiteralMapExpr extends Expression
 {
     public $type = null;
     public $entries;
     private $valueType;

     public function __construct(
         array $entries, MapType $type = null, ParseSourceSpan $sourceSpan)
     {
         parent::__construct($type, $sourceSpan);
         if (isset($type)) {
             $this->valueType = $type->valueType;
         }
         $this->type = $type;
         $this->entries = $entries;

     }

     public function visitExpression(ExpressionVisitor $visitor, $context)
     {
         return $visitor->visitLiteralMapExpr($this, $context);
     }
 }

 interface ExpressionVisitor {
public function visitReadVarExpr(ReadVarExpr $ast, $context);
public function visitWriteVarExpr(WriteVarExpr $expr, $context);
public function visitWriteKeyExpr(WriteKeyExpr $expr, $context);
public function visitWritePropExpr(WritePropExpr $expr, $context);
public function visitInvokeMethodExpr( InvokeMethodExpr $ast, $context);
public function visitInvokeFunctionExpr( InvokeFunctionExpr $ast, $context);
public function visitInstantiateExpr( InstantiateExpr $ast, $context);
public function visitLiteralExpr( LiteralExpr $ast, $context);
public function visitExternalExpr( ExternalExpr $ast, $context);
public function visitConditionalExpr( ConditionalExpr $ast, $context);
public function visitNotExpr( NotExpr $ast, $context);
public function visitCastExpr( CastExpr $ast, $context);
public function visitFunctionExpr( FunctionExpr $ast, $context);
public function visitBinaryOperatorExpr( BinaryOperatorExpr $ast, $context);
public function visitReadPropExpr( ReadPropExpr $ast, $context);
public function visitReadKeyExpr( ReadKeyExpr $ast, $context);
public function visitLiteralArrayExpr( LiteralArrayExpr $ast, $context);
public function visitLiteralMapExpr( LiteralMapExpr $ast, $context);
}

 const THIS_EXPR = new ReadVarExpr(BuiltinVar.This);
 const SUPER_EXPR = new ReadVarExpr(BuiltinVar.Super);
 const CATCH_ERROR_VAR = new ReadVarExpr(BuiltinVar.CatchError);
 const CATCH_STACK_VAR = new ReadVarExpr(BuiltinVar.CatchStack);
 const NULL_EXPR = new LiteralExpr(null, null);
 const TYPED_NULL_EXPR = new LiteralExpr(null, NULL_TYPE);

//// Statements
 class StmtModifier
 {
     public const Final = "final";
     public const Private = "private";
 }





 class AbstractClassPart
 {
     public $type;
     public $modifiers;

     public function __construct(Type $type = null, array $modifiers)
     {
         if (!$modifiers) {
             $this->modifiers = [];
         }
         $this->type=$type;
         $this->modifiers=$modifiers;
     }

     public function hasModifier(StmtModifier $modifier): boolean
     {
         return $this->modifiers . indexOf($modifier) !== -1;
     }
 }

 class ClassField extends AbstractClassPart
 {
     public $name;

     public function __construct(string $name, Type $type = null, array $modifiers = null)
     {
         parent::__construct($type, $modifiers);
         $this->name=$name;
     }
 }


 class ClassMethod extends AbstractClassPart
 {
     public $name;
     public $params;
     public $body;

     public function __construct(
         string $name, array $params, array $body, Type $type = null,
         array $modifiers = null)
     {
         parent::__construct($type, $modifiers);
         $this->name=$name;
         $this->params=$params;
         $this->body=$body;
     }
 }


 class ClassGetter extends AbstractClassPart
 {
     public $name;
     public $body;

     public function __construct(
         string $name, array $body, Type $type = null,
         array $modifiers = null)
     {
         parent::__construct($type, $modifiers);
         $this->name=$name;
         $this->body=$body;
     }
 }


class ClassStmt extends Statement
{
    public $name;
    public $parent;
    public $fields;
    public $getters;
    public $constructorMethod;
    public $methods;

    public function __construct(
        string $name, Expression $parent, array $fields,
        array $getters, ClassMethod $constructorMethod,
        array $methods, $modifiers = null,
        ParseSourceSpan $sourceSpan)
    {
        parent::__construct($modifiers, $sourceSpan);
        $this->name = $name;
        $this->parent = $parent;
        $this->fields = $fields;
        $this->getters = $getters;
        $this->constructorMethod = $constructorMethod;
        $this->methods = $methods;
    }

    public function visitStatement(StatementVisitor $visitor, $context)
    {
        return $visitor->visitDeclareClassStmt($this, $context);
    }
}


 class IfStmt extends Statement
 {
     public $condition;
     public $trueCase;
     public $falseCase;

     public function __construct(
         Expression $condition, array $trueCase,
         array $falseCase = [], ParseSourceSpan $sourceSpan)
     {
         parent::__construct(null, $sourceSpan);
         $this->condition = $condition;
         $this->trueCase = $trueCase;
         $this->falseCase = $falseCase;
     }

     public function visitStatement(StatementVisitor $visitor, $context)
     {
         return $visitor->visitIfStmt($this, $context);
     }
 }


 class CommentStmt extends Statement
 {
     public $comment;

     public function __construct(string $comment, ParseSourceSpan $sourceSpan)
     {
         parent::__construct(null, $sourceSpan);
         $this->comment=$comment;
     }

     public function visitStatement(StatementVisitor $visitor, $context)
     {
         return $visitor->visitCommentStmt($this, $context);
     }
 }


 class TryCatchStmt extends Statement
 {
     public $bodyStmts;
     public $catchStmts;

     public function __construct(
         array $bodyStmts, array $catchStmts, ParseSourceSpan $sourceSpan)
     {
         parent::__construct(null, $sourceSpan);
         $this->bodyStmts = $bodyStmts;
         $this->catchStmts = $catchStmts;
     }

     public function visitStatement(StatementVisitor $visitor, $context)
     {
         return $visitor->visitTryCatchStmt($this, $context);
     }
 }


 class ThrowStmt extends Statement
 {
     public $error;

     public function __construct(Expression $error, ParseSourceSpan $sourceSpan)
     {
         parent::__construct(null, $sourceSpan);
         $this->error=$error;
     }

     public function visitStatement(StatementVisitor $visitor, $context)
     {
         return $visitor->visitThrowStmt($this, $context);
     }
 }

 interface StatementVisitor {
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

     public function visitAllExpressions(array $exprs, $context): Expression[] {
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

 function replaceVarInExpression(
    varstring $name , newExpression $value, Expression $expression): Expression
 {
     const transformer = new _ReplaceVariableTransformer($varName, $newValue);
     return expression->visitExpression(transformer, null);
}

class _ReplaceVariableTransformer extends ExpressionTransformer
{
    private $name;
    private $value;

    public function __construct(_varstring $name, _newExpression $value)
    {
        parent::__construct();
        $this->name = $name;
        $this->value = $value;
    }

    public function visitReadVarExpr(ReadVarExpr $ast, $context)
    {
        return $ast->name == $this->_varName ? $this->_newValue : $ast;
    }
}

 function findReadVarNames(array $stmts): Set<string> {
    const finder = new _VariableFinder();
    finder.visitAllStatements($stmts, null);
    return finder.varNames;
}

class _VariableFinder extends RecursiveExpressionVisitor
{
    varNames = new Set<string>();
    public function visitReadVarExpr(ReadVarExpr $ast, $context)
    {
        $this->varNames->add($ast->name);
        return null;
    }
}

public function variable(
    string $name , Type $type = null, ParseSourceSpan $sourceSpan): ReadVarExpr {
    return new ReadVarExpr($name, $type, $sourceSpan);
}

public function importExpr(
    CompileIdentifierMetadata $id,array $typeParams=null,
    ParseSourceSpan $sourceSpan): ExternalExpr {
    return new ExternalExpr($id, null, $typeParams, $sourceSpan);
}

public function importType(
    CompileIdentifierMetadata $id,array $typeParams=null,
    array $typeModifiers = null): ExpressionType {
    return isPresent($id) ? expressionType(importExpr($id, $typeParams), $typeModifiers) : null;
}

public function expressionType(
    Expression $expr, array $typeModifiers= null): ExpressionType {
    return isPresent($expr) ? new ExpressionType($expr, $typeModifiers) : null;
}

public function literalArr(
    array $values, Type $type = null, ParseSourceSpan $sourceSpan): LiteralArrayExpr {
    return new LiteralArrayExpr($values, $type, $sourceSpan);
}

public function literalMap(
    $values, MapType $type= null, boolean $quoted= false): LiteralMapExpr {
    return new LiteralMapExpr(
        $values->map($entry => new LiteralMapEntry($entry[0], $entry[1], $quoted)), $type);
}

public function not(Expression $expr, ParseSourceSpan $sourceSpan): NotExpr {
    return new NotExpr($expr, $sourceSpan);
}

public function fn(
    array $params, array $body, Type $type = null,
    ParseSourceSpan $sourceSpan): FunctionExpr {
    return new FunctionExpr($params, $body, $type, $sourceSpan);
}

public function literal($value, Type $type = null, ParseSourceSpan $sourceSpan): LiteralExpr {
    return new LiteralExpr($value, $type, $sourceSpan);
}
