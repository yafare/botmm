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
        $start = $this->getInputIndex();
        $annotations = $this->parseAnnotations();
        $this->expectKeyword(Keywords::_PACKAGE_);
        $name  = $this->parseName();
        $this->expectCharacter(Chars::SEMICOLON);
        return new PackageDeclaration($this->span($start), $annotations, $name);
    }
}