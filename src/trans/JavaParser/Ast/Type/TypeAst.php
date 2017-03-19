<?php


namespace trans\JavaParser\Ast\Type;


use trans\JavaParser\Ast\AST;

abstract class TypeAst extends AST
{
    public $annotations;

    public function setAnnotations($annotations) {
        $this->annotations = $annotations;
    }

}