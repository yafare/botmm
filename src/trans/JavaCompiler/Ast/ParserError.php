<?php


namespace trans\JavaCompiler\Ast;


class ParserError
{
    public $message;
    public $input;
    public $errLocation;
    public $ctxLocation;

    public function __construct($message, $input, $errLocation, $ctxLocation = null)
    {
        $this->input       = $input;
        $this->errLocation = $errLocation;
        $this->ctxLocation = $ctxLocation;

        $this->message = "Parser Error: {$message} {$errLocation} [{$input}] in {$ctxLocation}";
    }
}
