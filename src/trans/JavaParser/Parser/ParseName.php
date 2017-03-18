<?php


namespace trans\JavaParser\Parser;

use trans\JavaParser\Ast\Expr\Name;
use trans\JavaParser\Ast\Expr\SimpleName;
use trans\JavaParser\Chars;
use trans\JavaParser\Lexer\Token;

/**
 * Class parseName
 *
 * @mixin ParseAST
 * @package trans\JavaParser\Parser
 */
trait ParseName
{

    public function parseName()
    {
        $start = $this->getInputIndex();

        $name = new Name($this->span($start), null, $this->expectIdentifier());
        while (true) {
            if ($this->optionalCharacter(Chars::PERIOD) && $this->getNext()->isIdentifier()) {
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
        $start = $this->getInputIndex();
        $name = $this->expectIdentifier();
        return new SimpleName($this->span($start), $name);
    }
}