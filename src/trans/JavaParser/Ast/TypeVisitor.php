<?php


namespace trans\JavaCompiler\Ast;


use trans\JavaCompiler\Ast\Type\ArrayType;
use trans\JavaCompiler\Ast\Type\BuiltinType;
use trans\JavaCompiler\Ast\Type\ExpressionType;
use trans\JavaCompiler\Ast\Type\MapType;

interface TypeVisitor
{
    public function visitBuiltintType(BuiltinType $type, $context);

    public function visitExpressionType(ExpressionType $type, $context);

    public function visitArrayType(ArrayType $type, $context);

    public function visitMapType(MapType $type, $context);
}