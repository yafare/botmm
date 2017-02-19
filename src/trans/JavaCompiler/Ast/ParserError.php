<?php
/**
 * Created by IntelliJ IDEA.
 * User: hugo
 * Date: 2017/2/19
 * Time: 11:51
 */

namespace src\trans\JavaCompiler;


class ParserError
{
    public $message;

    public function __constructor(string $message, string $input, string $errLocation, $ctxLocation)
    {
        $this->message = "Parser Error: $message $errLocation [$input] in $ctxLocation";
    }
}