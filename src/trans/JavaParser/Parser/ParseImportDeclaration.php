<?php


namespace trans\JavaParser\Parser;

use trans\JavaParser\Ast\ClassPart\ImportDeclaration;
use trans\JavaParser\Chars;
use trans\JavaParser\Keywords;


/**
 * Class ParseImportDeclaration
 *
 * @mixin ParseAST
 * @package trans\JavaParser\Parser
 */
trait ParseImportDeclaration
{
    public function parseImportDeclaration()
    {
        $isStatic   = false;
        $isAsterisk = false;

        $this->expectKeyword(Keywords::_IMPORT_);
        $start = $this->getInputIndex();
        $n     = $this->getNext();
        if ($n->isKeyword() && $n->isKeywordStatic()) {
            $this->advance();
            $isStatic = true;
        }
        $name = $this->parseName();
        if ($n->isCharacter(Chars::PERIOD) && $this->peek(1)->isCharacter(Chars::STAR)) {
            $this->advance();
            $this->advance();
            $isAsterisk = true;
        }
        $this->expectCharacter(Chars::SEMICOLON);


        return new ImportDeclaration($this->span($start), $name, $isStatic, $isAsterisk);
    }

}