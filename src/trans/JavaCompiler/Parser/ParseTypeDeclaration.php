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
            $this->parseClassOrInterface($modifier);
        } elseif ($n->isKeywordEnum()) {
            //$this->parseEnumDeclaration();
        } elseif ($n->isCharacter(Chars::AT)) {
            $this->parseAnnotationTypeDeclaration($modifier);
        } else {
            $this->error('can not parse TypeDeclaration');
        }
    }
}