<?php


namespace trans\JavaCompiler\Ast;


class Modifier
{

    public const PUBLIC       = 1;
    public const PROTECTED    = 2;
    public const PRIVATE      = 4;
    public const ABSTRACT     = 8;
    public const STATIC       = 16;
    public const FINAL        = 32;
    public const TRANSIENT    = 64;
    public const VOLATILE     = 128;
    public const SYNCHRONIZED = 256;
    public const NATIVE       = 512;
    public const STRICTFP     = 1024;

    public $value = 0;

    public function add($modifier)
    {
        $this->value |= $modifier;
    }

    public function contains($modifier)
    {
        return $this->value & $modifier == $modifier;
    }

    public function getAccessSpecifier()
    {
        if ($this->contains(Modifier::PUBLIC)) {
            return Modifier::PUBLIC;
        } elseif ($this->contains(Modifier::PROTECTED)) {
            return Modifier::PROTECTED;
        } elseif ($this->contains(Modifier::PRIVATE)) {
            return Modifier::PRIVATE;
        }
    }
}
