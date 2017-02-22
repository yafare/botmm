<?php


namespace trans\JavaCompiler\Parser;

use trans\JavaCompiler\Ast\Expr\Name;
use trans\JavaCompiler\Chars;
use trans\JavaCompiler\Lexer\Token;

/**
 * Class parseName
 *
 * @package trans\JavaCompiler\Parser
 */
trait ParseName
{

    public function parseName()
    {
        $start = $this->getInputIndex();

        $name = new Name($this->span($start), null, $this->expectIdentifier());
        while (true) {
            if ($this->optionalCharacter(Chars::PERIOD)) {
                $subName = $this->expectIdentifier();
                $name    = new Name($this->span($start), $name, $subName);
            } else {
                break;
            }
        }
        return $name;
    }

    public function parseSimpleName()
    {

    }
}