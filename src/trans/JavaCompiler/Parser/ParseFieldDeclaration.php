<?php


namespace trans\JavaCompiler\Parser;

use trans\JavaCompiler\Chars;


/**
 * Class ParseFieldDeclaration
 *
 * @mixin ParseAST
 * @package trans\JavaCompiler\Parser
 */
trait ParseFieldDeclaration
{

    public function parseFieldDeclaration($modifier)
    {
        $variables = [];

        $start = $this->getInputIndex();
        $partialType = $this->parseType();
        $val         = $this->parseVariableDeclarator($partialType);

        $variables[] = $val;

        while (true) {
            if ($this->optionalCharacter(Chars::COMMA)) {
                $this->advance();
                $variables[] = $this->parseVariableDeclarator($partialType);
            } else {
                break;
            }
        }

        $this->expectCharacter(Chars::SEMICOLON);
        return new FieldDeclaration($this->span($start), $modifier['modifiers'], $modifier['annotations'], $variables);
    }
}