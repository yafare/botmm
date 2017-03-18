<?php


namespace trans\JavaParser\Parser;

use trans\JavaParser\Ast\ClassPart\PackageDeclaration;
use trans\JavaParser\Chars;
use trans\JavaParser\Keywords;


/**
 * Class ParsePackageDeclaration
 *
 * @mixin ParseAST
 * @package trans\JavaParser\Parser
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