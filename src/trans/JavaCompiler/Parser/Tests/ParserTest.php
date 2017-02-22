<?php


namespace trans\JavaCompiler\Parser\Tests;


use PHPUnit\Framework\TestCase;
use trans\JavaCompiler\Parser\ParseAST;

class ParserTest extends TestCase
{



    public function testParse() {

        $parser = new ParseAST($input, $location, $tokens, $inputLength, $parseAction, $errors, $offset);
    }
}