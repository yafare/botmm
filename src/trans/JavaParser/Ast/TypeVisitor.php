<?php


namespace trans\JavaParser\Ast;


use trans\JavaParser\Ast\Type\ArrayType;
use trans\JavaParser\Ast\Type\BuiltinType;
use trans\JavaParser\Ast\Type\ExpressionType;
use trans\JavaParser\Ast\Type\MapType;

interface TypeVisitor
{
    public function visitBuiltintType(BuiltinType $type, $context);

    public function visitExpressionType(ExpressionType $type, $context);

    public function visitArrayType(ArrayType $type, $context);

    public function visitMapType(MapType $type, $context);
}