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
     public const Super = "super";
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


 class InvokeFunctionExpr extends Expression {
public function __construct(
public fn: Expression, public args: Expression[], Type $type = null,
ParseSourceSpan $sourceSpan) {
parent::__construct($type, sourceSpan);
}
  public function visitExpression(ExpressionVisitor $visitor, $context) {
    return $visitor->visitInvokeFunctionExpr($this, $context);
}
}


 class InstantiateExpr extends Expression {
public function __construct(
public classExpr: Expression, public args: Expression[], type?: Type,
ParseSourceSpan $sourceSpan) {
parent::__construct($type, sourceSpan);
}
  public function visitExpression(ExpressionVisitor $visitor, $context) {
    return $visitor->visitInstantiateExpr($this, $context);
}
}


 class LiteralExpr extends Expression {
public function __construct(public value, Type $type = null, ParseSourceSpan $sourceSpan) {
parent::__construct($type, sourceSpan);
}
  public function visitExpression(ExpressionVisitor $visitor, $context) {
    return $visitor->visitLiteralExpr($this, $context);
}
}


 class ExternalExpr extends Expression {
public function __construct(
public value: CompileIdentifierMetadata, Type $type = null, public typeParams: Type[] = null,
ParseSourceSpan $sourceSpan) {
parent::__construct($type, sourceSpan);
}
  public function visitExpression(ExpressionVisitor $visitor, $context) {
    return $visitor->visitExternalExpr($this, $context);
}
}


 class ConditionalExpr extends Expression {
public Expression $trueCase;
public function __construct(
public condition: Expression, Expression $trueCase, public Expression $falseCase = null,
Type $type = null, ParseSourceSpan $sourceSpan) {
parent::__construct($type || trueCase.type, sourceSpan);
$this->trueCase = trueCase;
}
  public function visitExpression(ExpressionVisitor $visitor, $context) {
    return $visitor->visitConditionalExpr($this, $context);
}
}


 class NotExpr extends Expression {
public function __construct(public condition: Expression, ParseSourceSpan $sourceSpan) {
super(BOOL_TYPE, sourceSpan);
}
  public function visitExpression(ExpressionVisitor $visitor, $context) {
    return $visitor->visitNotExpr($this, $context);
}
}

 class CastExpr extends Expression {
public function __construct(public Expression $value, Type $type, ParseSourceSpan $sourceSpan) {
parent::__construct($type, sourceSpan);
}
  public function visitExpression(ExpressionVisitor $visitor, $context) {
    return $visitor->visitCastExpr($this, $context);
}
}


 class FnParam {
public function __construct(public string $name , public Type $type = null) {}
}


 class FunctionExpr extends Expression {
public function __construct(
public params: FnParam[], public statements: Statement[], Type $type = null,
ParseSourceSpan $sourceSpan) {
parent::__construct($type, sourceSpan);
}
  public function visitExpression(ExpressionVisitor $visitor, $context) {
    return $visitor->visitFunctionExpr($this, $context);
}

  public function toDeclStmt(string $name , array $modifiers= null): DeclareFunctionStmt {
    return new DeclareFunctionStmt(
        name, $this->params, $this->statements, $this->type, modifiers, $this->sourceSpan);
}
}


 class BinaryOperatorExpr extends Expression {
public lhs: Expression;
public function __construct(
public operator: BinaryOperator, lhs: Expression, public Expression $rhs, Type $type = null,
ParseSourceSpan $sourceSpan) {
parent::__construct($type || lhs.type, sourceSpan);
$this->lhs = lhs;
}
  public function visitExpression(ExpressionVisitor $visitor, $context) {
    return $visitor->visitBinaryOperatorExpr($this, $context);
}
}


 class ReadPropExpr extends Expression {
public function __construct(
public receiver: Expression, public string $name , Type $type = null,
ParseSourceSpan $sourceSpan) {
parent::__construct($type, sourceSpan);
}
  public function visitExpression(ExpressionVisitor $visitor, $context) {
    return $visitor->visitReadPropExpr($this, $context);
}
  set(Expression $value): WritePropExpr {
    return new WritePropExpr($this->receiver, $this->name, value, null, $this->sourceSpan);
}
}


 class ReadKeyExpr extends Expression {
public function __construct(
public receiver: Expression, public Expression $index, Type $type = null,
ParseSourceSpan $sourceSpan) {
parent::__construct($type, sourceSpan);
}
  public function visitExpression(ExpressionVisitor $visitor, $context) {
    return $visitor->visitReadKeyExpr($this, $context);
}
  set(Expression $value): WriteKeyExpr {
    return new WriteKeyExpr($this->receiver, $this->index, value, null, $this->sourceSpan);
}
}


 class LiteralArrayExpr extends Expression {
public entries: Expression[];
public function __construct(entries: Expression[], Type $type = null, ParseSourceSpan $sourceSpan) {
parent::__construct($type, sourceSpan);
$this->entries = entries;
}
  public function visitExpression(ExpressionVisitor $visitor, $context) {
    return $visitor->visitLiteralArrayExpr($this, $context);
}
}

 class LiteralMapEntry {
public function __construct(public key: string, public Expression $value, public quoted: boolean = false) {}
}

 class LiteralMapExpr extends Expression {
public valueType $type = null;
public function __construct(
public entries: LiteralMapEntry[], type: MapType = null, ParseSourceSpan $sourceSpan) {
parent::__construct($type, sourceSpan);
if (type) {
$this->valueType = type.valueType;
}
  }
  public function visitExpression(ExpressionVisitor $visitor, $context) {
    return $visitor->visitLiteralMapExpr($this, $context);
}
}

 interface ExpressionVisitor {
visitReadVarExpr(ast: ReadVarExpr, $context);
visitWriteVarExpr(expr: WriteVarExpr, $context);
visitWriteKeyExpr(expr: WriteKeyExpr, $context);
visitWritePropExpr(expr: WritePropExpr, $context);
visitInvokeMethodExpr(ast: InvokeMethodExpr, $context);
visitInvokeFunctionExpr(ast: InvokeFunctionExpr, $context);
visitInstantiateExpr(ast: InstantiateExpr, $context);
visitLiteralExpr(ast: LiteralExpr, $context);
visitExternalExpr(ast: ExternalExpr, $context);
visitConditionalExpr(ast: ConditionalExpr, $context);
visitNotExpr(ast: NotExpr, $context);
visitCastExpr(ast: CastExpr, $context);
visitFunctionExpr(ast: FunctionExpr, $context);
visitBinaryOperatorExpr(ast: BinaryOperatorExpr, $context);
visitReadPropExpr(ast: ReadPropExpr, $context);
visitReadKeyExpr(ast: ReadKeyExpr, $context);
visitLiteralArrayExpr(ast: LiteralArrayExpr, $context);
visitLiteralMapExpr(ast: LiteralMapExpr, $context);
}

 const THIS_EXPR = new ReadVarExpr(BuiltinVar.This);
 const SUPER_EXPR = new ReadVarExpr(BuiltinVar.Super);
 const CATCH_ERROR_VAR = new ReadVarExpr(BuiltinVar.CatchError);
 const CATCH_STACK_VAR = new ReadVarExpr(BuiltinVar.CatchStack);
 const NULL_EXPR = new LiteralExpr(null, null);
 const TYPED_NULL_EXPR = new LiteralExpr(null, NULL_TYPE);

//// Statements
 enum StmtModifier {
    Final,
    Private
}



 class DeclareVarStmt extends Statement {
public Type $type;
public function __construct(
public string $name , public Expression $value, Type $type = null,
array $modifiers= null, ParseSourceSpan $sourceSpan) {
super(modifiers, sourceSpan);
$this->type = type || value.type;
}

  visitStatement(visitor: StatementVisitor, $context) {
    return $visitor->visitDeclareVarStmt($this, $context);
}
}

 class DeclareFunctionStmt extends Statement {
public function __construct(
public string $name , public params: FnParam[], public statements: Statement[],
public Type $type = null, array $modifiers= null, ParseSourceSpan $sourceSpan) {
super(modifiers, sourceSpan);
}

  visitStatement(visitor: StatementVisitor, $context) {
    return $visitor->visitDeclareFunctionStmt($this, $context);
}
}

 class ExpressionStatement extends Statement {
public function __construct(public expr: Expression, ParseSourceSpan $sourceSpan) { super(null, sourceSpan); }

  visitStatement(visitor: StatementVisitor, $context) {
    return $visitor->visitExpressionStmt($this, $context);
}
}


 class ReturnStatement extends Statement {
public function __construct(public Expression $value, ParseSourceSpan $sourceSpan) { super(null, sourceSpan); }
  visitStatement(visitor: StatementVisitor, $context) {
    return $visitor->visitReturnStmt($this, $context);
}
}

 class AbstractClassPart {
public function __construct(public Type $type = null, public modifiers: StmtModifier[]) {
if (!modifiers) {
$this->modifiers = [];
}
  }
  hasModifier(modifier: StmtModifier): boolean { return $this->modifiers.indexOf(modifier) !== -1; }
}

 class ClassField extends AbstractClassPart {
public function __construct(public string $name , Type $type = null, array $modifiers= null) {
parent::__construct($type, modifiers);
}
}


 class ClassMethod extends AbstractClassPart {
public function __construct(
public string $name , public params: FnParam[], public body: Statement[], Type $type = null,
array $modifiers= null) {
parent::__construct($type, modifiers);
}
}


 class ClassGetter extends AbstractClassPart {
public function __construct(
public string $name , public body: Statement[], Type $type = null,
array $modifiers= null) {
parent::__construct($type, modifiers);
}
}


 class ClassStmt extends Statement {
public function __construct(
public string $name , public parent: Expression, public fields: ClassField[],
public getters: ClassGetter[], public public function __constructMethod: ClassMethod,
public methods: ClassMethod[], array $modifiers= null,
ParseSourceSpan $sourceSpan) {
super(modifiers, sourceSpan);
}
  visitStatement(visitor: StatementVisitor, $context) {
    return $visitor->visitDeclareClassStmt($this, $context);
}
}


 class IfStmt extends Statement {
public function __construct(
public condition: Expression, public trueCase: Statement[],
public falseCase: Statement[] = [], ParseSourceSpan $sourceSpan) {
super(null, sourceSpan);
}
  visitStatement(visitor: StatementVisitor, $context) {
    return $visitor->visitIfStmt($this, $context);
}
}


 class CommentStmt extends Statement {
public function __construct(public comment: string, ParseSourceSpan $sourceSpan) { super(null, sourceSpan); }
  visitStatement(visitor: StatementVisitor, $context) {
    return $visitor->visitCommentStmt($this, $context);
}
}


 class TryCatchStmt extends Statement {
public function __construct(
public bodyStmts: Statement[], public catchStmts: Statement[], ParseSourceSpan $sourceSpan) {
super(null, sourceSpan);
}
  visitStatement(visitor: StatementVisitor, $context) {
    return $visitor->visitTryCatchStmt($this, $context);
}
}


 class ThrowStmt extends Statement {
public function __construct(public error: Expression, ParseSourceSpan $sourceSpan) { super(null, sourceSpan); }
  visitStatement(visitor: StatementVisitor, $context) {
    return $visitor->visitThrowStmt($this, $context);
}
}

 interface StatementVisitor {
visitDeclareVarStmt(stmt: DeclareVarStmt, $context);
visitDeclareFunctionStmt(stmt: DeclareFunctionStmt, $context);
visitExpressionStmt(stmt: ExpressionStatement, $context);
visitReturnStmt(stmt: ReturnStatement, $context);
visitDeclareClassStmt(stmt: ClassStmt, $context);
visitIfStmt(stmt: IfStmt, $context);
visitTryCatchStmt(stmt: TryCatchStmt, $context);
visitThrowStmt(stmt: ThrowStmt, $context);
visitCommentStmt(stmt: CommentStmt, $context);
}

 class ExpressionTransformer implements StatementVisitor, ExpressionVisitor {
visitReadVarExpr(ast: ReadVarExpr, $context) { return ast; }

  visitWriteVarExpr(expr: WriteVarExpr, $context) {
    return new WriteVarExpr(
        expr.name, expr.value.visitExpression($this, $context), expr.type, expr.sourceSpan);
}

  visitWriteKeyExpr(expr: WriteKeyExpr, $context) {
    return new WriteKeyExpr(
        expr.receiver.visitExpression($this, $context), expr.index.visitExpression($this, $context),
        expr.value.visitExpression($this, $context), expr.type, expr.sourceSpan);
}

  visitWritePropExpr(expr: WritePropExpr, $context) {
    return new WritePropExpr(
        expr.receiver.visitExpression($this, $context), expr.name,
        expr.value.visitExpression($this, $context), expr.type, expr.sourceSpan);
}

  visitInvokeMethodExpr(ast: InvokeMethodExpr, $context) {
    const method = ast.builtin || ast.name;
    return new InvokeMethodExpr(
        ast.receiver.visitExpression($this, $context), method,
        $this->visitAllExpressions(ast.args, context), ast.type, ast.sourceSpan);
}

  visitInvokeFunctionExpr(ast: InvokeFunctionExpr, $context) {
    return new InvokeFunctionExpr(
        ast.fn.visitExpression($this, $context), $this->visitAllExpressions(ast.args, context),
        ast.type, ast.sourceSpan);
}

  visitInstantiateExpr(ast: InstantiateExpr, $context) {
    return new InstantiateExpr(
        ast.classExpr.visitExpression($this, $context), $this->visitAllExpressions(ast.args, context),
        ast.type, ast.sourceSpan);
}

  visitLiteralExpr(ast: LiteralExpr, $context) { return ast; }

  visitExternalExpr(ast: ExternalExpr, $context) { return ast; }

  visitConditionalExpr(ast: ConditionalExpr, $context) {
    return new ConditionalExpr(
        ast.condition.visitExpression($this, $context), ast.trueCase.visitExpression($this, $context),
        ast.falseCase.visitExpression($this, $context), ast.type, ast.sourceSpan);
}

  visitNotExpr(ast: NotExpr, $context) {
    return new NotExpr(ast.condition.visitExpression($this, $context), ast.sourceSpan);
}

  visitCastExpr(ast: CastExpr, $context) {
    return new CastExpr(ast.value.visitExpression($this, $context), context, ast.sourceSpan);
}

  visitFunctionExpr(ast: FunctionExpr, $context) {
    // Don't descend into nested functions
    return ast;
}

  visitBinaryOperatorExpr(ast: BinaryOperatorExpr, $context) {
    return new BinaryOperatorExpr(
        ast.operator, ast.lhs.visitExpression($this, $context),
        ast.rhs.visitExpression($this, $context), ast.type, ast.sourceSpan);
}

  visitReadPropExpr(ast: ReadPropExpr, $context) {
    return new ReadPropExpr(
        ast.receiver.visitExpression($this, $context), ast.name, ast.type, ast.sourceSpan);
}

  visitReadKeyExpr(ast: ReadKeyExpr, $context) {
    return new ReadKeyExpr(
        ast.receiver.visitExpression($this, $context), ast.index.visitExpression($this, $context),
        ast.type, ast.sourceSpan);
}

  visitLiteralArrayExpr(ast: LiteralArrayExpr, $context) {
    return new LiteralArrayExpr(
        $this->visitAllExpressions(ast.entries, context), ast.type, ast.sourceSpan);
}

  visitLiteralMapExpr(ast: LiteralMapExpr, $context) {
    const entries = ast.entries.map(
            (entry): LiteralMapEntry => new LiteralMapEntry(
        entry.key, entry.value.visitExpression($this, $context), entry.quoted, ));
    const mapType = new MapType(ast.valueType);
    return new LiteralMapExpr(entries, mapType, ast.sourceSpan);
  }
  visitAllExpressions(exprs: Expression[], $context): Expression[] {
    return exprs.map(expr => expr.visitExpression($this, $context));
  }

  visitDeclareVarStmt(stmt: DeclareVarStmt, $context) {
    return new DeclareVarStmt(
        stmt.name, stmt.value.visitExpression($this, $context), stmt.type, stmt.modifiers,
        stmt.sourceSpan);
}
  visitDeclareFunctionStmt(stmt: DeclareFunctionStmt, $context) {
    // Don't descend into nested functions
    return stmt;
}

  visitExpressionStmt(stmt: ExpressionStatement, $context) {
    return new ExpressionStatement(stmt.expr.visitExpression($this, $context), stmt.sourceSpan);
}

  visitReturnStmt(stmt: ReturnStatement, $context) {
    return new ReturnStatement(stmt.value.visitExpression($this, $context), stmt.sourceSpan);
}

  visitDeclareClassStmt(stmt: ClassStmt, $context) {
    // Don't descend into nested functions
    return stmt;
}

  visitIfStmt(stmt: IfStmt, $context) {
    return new IfStmt(
        stmt.condition.visitExpression($this, $context),
        $this->visitAllStatements(stmt.trueCase, context),
        $this->visitAllStatements(stmt.falseCase, context), stmt.sourceSpan);
}

  visitTryCatchStmt(stmt: TryCatchStmt, $context) {
    return new TryCatchStmt(
        $this->visitAllStatements(stmt.bodyStmts, context),
        $this->visitAllStatements(stmt.catchStmts, context), stmt.sourceSpan);
}

  visitThrowStmt(stmt: ThrowStmt, $context) {
    return new ThrowStmt(stmt.error.visitExpression($this, $context), stmt.sourceSpan);
}

  visitCommentStmt(stmt: CommentStmt, $context) { return stmt; }

  visitAllStatements(stmts: Statement[], $context): Statement[] {
    return stmts.map(stmt => stmt.visitStatement($this, $context));
  }
}


 class RecursiveExpressionVisitor implements StatementVisitor, ExpressionVisitor {
visitReadVarExpr(ast: ReadVarExpr, $context) { return ast; }
  visitWriteVarExpr(expr: WriteVarExpr, $context) {
    expr.value.visitExpression($this, $context);
    return expr;
}
  visitWriteKeyExpr(expr: WriteKeyExpr, $context) {
    expr.receiver.visitExpression($this, $context);
    expr.index.visitExpression($this, $context);
    expr.value.visitExpression($this, $context);
    return expr;
}
  visitWritePropExpr(expr: WritePropExpr, $context) {
    expr.receiver.visitExpression($this, $context);
    expr.value.visitExpression($this, $context);
    return expr;
}
  visitInvokeMethodExpr(ast: InvokeMethodExpr, $context) {
    ast.receiver.visitExpression($this, $context);
    $this->visitAllExpressions(ast.args, context);
    return ast;
}
  visitInvokeFunctionExpr(ast: InvokeFunctionExpr, $context) {
    ast.fn.visitExpression($this, $context);
    $this->visitAllExpressions(ast.args, context);
    return ast;
}
  visitInstantiateExpr(ast: InstantiateExpr, $context) {
    ast.classExpr.visitExpression($this, $context);
    $this->visitAllExpressions(ast.args, context);
    return ast;
}
  visitLiteralExpr(ast: LiteralExpr, $context) { return ast; }
  visitExternalExpr(ast: ExternalExpr, $context) { return ast; }
  visitConditionalExpr(ast: ConditionalExpr, $context) {
    ast.condition.visitExpression($this, $context);
    ast.trueCase.visitExpression($this, $context);
    ast.falseCase.visitExpression($this, $context);
    return ast;
}
  visitNotExpr(ast: NotExpr, $context) {
    ast.condition.visitExpression($this, $context);
    return ast;
}
  visitCastExpr(ast: CastExpr, $context) {
    ast.value.visitExpression($this, $context);
    return ast;
}
  visitFunctionExpr(ast: FunctionExpr, $context) { return ast; }
  visitBinaryOperatorExpr(ast: BinaryOperatorExpr, $context) {
    ast.lhs.visitExpression($this, $context);
    ast.rhs.visitExpression($this, $context);
    return ast;
}
  visitReadPropExpr(ast: ReadPropExpr, $context) {
    ast.receiver.visitExpression($this, $context);
    return ast;
}
  visitReadKeyExpr(ast: ReadKeyExpr, $context) {
    ast.receiver.visitExpression($this, $context);
    ast.index.visitExpression($this, $context);
    return ast;
}
  visitLiteralArrayExpr(ast: LiteralArrayExpr, $context) {
    $this->visitAllExpressions(ast.entries, context);
    return ast;
}
  visitLiteralMapExpr(ast: LiteralMapExpr, $context) {
    ast.entries.forEach((entry) => entry.value.visitExpression($this, $context));
    return ast;
  }
  visitAllExpressions(exprs: Expression[], $context): void {
    exprs.forEach(expr => expr.visitExpression($this, $context));
  }

  visitDeclareVarStmt(stmt: DeclareVarStmt, $context) {
    stmt.value.visitExpression($this, $context);
    return stmt;
}
  visitDeclareFunctionStmt(stmt: DeclareFunctionStmt, $context) {
    // Don't descend into nested functions
    return stmt;
}
  visitExpressionStmt(stmt: ExpressionStatement, $context) {
    stmt.expr.visitExpression($this, $context);
    return stmt;
}
  visitReturnStmt(stmt: ReturnStatement, $context) {
    stmt.value.visitExpression($this, $context);
    return stmt;
}
  visitDeclareClassStmt(stmt: ClassStmt, $context) {
    // Don't descend into nested functions
    return stmt;
}
  visitIfStmt(stmt: IfStmt, $context) {
    stmt.condition.visitExpression($this, $context);
    $this->visitAllStatements(stmt.trueCase, context);
    $this->visitAllStatements(stmt.falseCase, context);
    return stmt;
}
  visitTryCatchStmt(stmt: TryCatchStmt, $context) {
    $this->visitAllStatements(stmt.bodyStmts, context);
    $this->visitAllStatements(stmt.catchStmts, context);
    return stmt;
}
  visitThrowStmt(stmt: ThrowStmt, $context) {
    stmt.error.visitExpression($this, $context);
    return stmt;
}
  visitCommentStmt(stmt: CommentStmt, $context) { return stmt; }
  visitAllStatements(stmts: Statement[], $context): void {
    stmts.forEach(stmt => stmt.visitStatement($this, $context));
  }
}

 function replaceVarInExpression(
    varstring $name , newExpression $value, expression: Expression): Expression {
    const transformer = new _ReplaceVariableTransformer(varName, newValue);
    return expression.visitExpression(transformer, null);
}

class _ReplaceVariableTransformer extends ExpressionTransformer {
public function __construct(private _varstring $name , private _newExpression $value) { super(); }
  visitReadVarExpr(ast: ReadVarExpr, $context) {
    return ast.name == $this->_varName ? $this->_newValue : ast;
}
}

 function findReadVarNames(stmts: Statement[]): Set<string> {
    const finder = new _VariableFinder();
    finder.visitAllStatements(stmts, null);
    return finder.varNames;
}

class _VariableFinder extends RecursiveExpressionVisitor {
varNames = new Set<string>();
visitReadVarExpr(ast: ReadVarExpr, $context) {
$this->varNames.add(ast.name);
return null;
}
}

 function variable(
    string $name , Type $type = null, ParseSourceSpan $sourceSpan): ReadVarExpr {
    return new ReadVarExpr(name, type, sourceSpan);
}

 function importExpr(
    id: CompileIdentifierMetadata, typeParams: Type[] = null,
    ParseSourceSpan $sourceSpan): ExternalExpr {
    return new ExternalExpr(id, null, typeParams, sourceSpan);
}

 function importType(
    id: CompileIdentifierMetadata, typeParams: Type[] = null,
    type array $modifiers = null): ExpressionType {
    return isPresent(id) ? expressionType(importExpr(id, typeParams), typeModifiers) : null;
}

 function expressionType(
    expr: Expression, type array $modifiers = null): ExpressionType {
    return isPresent(expr) ? new ExpressionType(expr, typeModifiers) : null;
}

 function literalArr(
    values: Expression[], Type $type = null, ParseSourceSpan $sourceSpan): LiteralArrayExpr {
    return new LiteralArrayExpr(values, type, sourceSpan);
}

 function literalMap(
    values: [string, Expression][], type: MapType = null, quoted: boolean = false): LiteralMapExpr {
    return new LiteralMapExpr(
        values.map(entry => new LiteralMapEntry(entry[0], entry[1], quoted)), type);
}

 function not(expr: Expression, ParseSourceSpan $sourceSpan): NotExpr {
    return new NotExpr(expr, sourceSpan);
}

 function fn(
    params: FnParam[], body: Statement[], Type $type = null,
    ParseSourceSpan $sourceSpan): FunctionExpr {
    return new FunctionExpr(params, body, type, sourceSpan);
}

 function literal(value, Type $type = null, ParseSourceSpan $sourceSpan): LiteralExpr {
    return new LiteralExpr(value, type, sourceSpan);
}
