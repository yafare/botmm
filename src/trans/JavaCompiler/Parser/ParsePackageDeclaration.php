<?php


namespace trans\JavaCompiler\Parser;

use trans\JavaCompiler\Ast\ClassPart\PackageDeclaration;
use trans\JavaCompiler\Chars;
use trans\JavaCompiler\Keywords;


/**
 * Class ParsePackageDeclaration
 *
 * @mixin ParseAST
 * @package trans\JavaCompiler\Parser
 */
trait ParsePackageDeclaration
{
    public function parsePackageDeclaration()
    {
        $annotations = $this->parseAnnotation();
        $this->expectKeyword(Keywords::_PACKAGE_);
        $start = $this->getInputIndex();
        $name  = $this->parseName();
        $this->expectCharacter(Chars::COMMA);
        return new PackageDeclaration($this->span($start), $annotations, $name);
    }
}