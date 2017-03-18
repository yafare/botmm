<?php


namespace trans\JavaCompiler\Parser;

use trans\JavaCompiler\Ast\ClassPart\ImportDeclaration;
use trans\JavaCompiler\Chars;
use trans\JavaCompiler\Keywords;


/**
 * Class ParseImportDeclaration
 *
 * @mixin ParseAST
 * @package trans\JavaCompiler\Parser
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