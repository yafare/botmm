<?php


namespace trans\JavaCompiler\Parser;

use trans\JavaCompiler\Chars;


/**
 * Class ParseTypeDeclaration
 *
 * @mixin ParseAST
 * @mixin ParseClassOrInterface
 * @mixin ParseAnnotationTypeDeclaration
 * @package trans\JavaCompiler\Parser
 */
trait ParseTypeDeclaration
{


    public function parseTypeDeclaration()
    {
        $modifier = $this->getModifier();
        $n        = $this->getNext();
        if ($n->isKeywordClass() || $n->isKeywordInterface()) {
            return $this->parseClassOrInterfaceDeclaration($modifier);
        } elseif ($n->isKeywordEnum()) {
            //return $this->parseEnumDeclaration();
        } elseif ($n->isCharacter(Chars::AT)) {
            return $this->parseAnnotationTypeDeclaration($modifier);
        } else {
            $this->error('can not parse TypeDeclaration');
        }
    }
}