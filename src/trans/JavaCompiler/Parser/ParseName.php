<?php


namespace trans\JavaCompiler\Parser;

use trans\JavaCompiler\Ast\Expr\Name;
use trans\JavaCompiler\Ast\Expr\SimpleName;
use trans\JavaCompiler\Chars;
use trans\JavaCompiler\Lexer\Token;

/**
 * Class parseName
 *
 * @mixin ParseAST
 * @package trans\JavaCompiler\Parser
 */
trait ParseName
{

    public function parseName()
    {
        $start = $this->getInputIndex();

        $name = new Name($this->span($start), null, $this->expectIdentifier());
        while (true) {
            if ($this->optionalCharacter(Chars::PERIOD) && $this->peek(1)->isIdentifier()) {
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