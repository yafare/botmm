<?php


namespace trans\JavaCompiler\Parser;

use trans\JavaCompiler\Ast\Body\AnnotationDeclaration;
use trans\JavaCompiler\Chars;
use trans\JavaCompiler\Keywords;


/**
 * Class ParseAnnotationTypeDeclaration
 *
 * @mixin ParseAST
 * @mixin parseannot
 * @package trans\JavaCompiler\Parser
 */
trait ParseAnnotationTypeDeclaration
{
    public function parseAnnotationTypeDeclaration($modifier)
    {
        $start = $this->getInputIndex();
        $this->expectCharacter(Chars::AT);
        $this->expectKeyword(Keywords::_INTERFACE_);
        $name = $this->parseSimpleName();
        $members = $this->parseAnnotationTypeBody();
        return new AnnotationDeclaration($this->span($start), $modifier['modifiers'], $modifier['annotations'], $name, $members);
    }

}