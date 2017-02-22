<?php


namespace trans\JavaCompiler\Output;


use trans\JavaCompiler\Output\Type\ArrayType;
use trans\JavaCompiler\Output\Type\BuiltinType;
use trans\JavaCompiler\Output\Type\ExpressionType;
use trans\JavaCompiler\Output\Type\MapType;

interface TypeVisitor
{
    public function visitBuiltintType(BuiltinType $type, $context);

    public function visitExpressionType(ExpressionType $type, $context);

    public function visitArrayType(ArrayType $type, $context);

    public function visitMapType(MapType $type, $context);
}