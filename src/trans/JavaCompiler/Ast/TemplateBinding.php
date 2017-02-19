<?php
/**
 * Created by IntelliJ IDEA.
 * User: hugo
 * Date: 2017/2/19
 * Time: 14:38
 */

namespace src\trans\JavaCompiler;


class TemplateBinding
{

    public $span;
    public $key;
    public $keyIsVar;
    public $name;
    public $expression;

    public function __construct(ParseSpan $span, string $key, bool $keyIsVar, string $name,ASTWithSource $expression)
    {

    }
}