<?php


namespace src\trans\JavaCompiler;


class StringWrapper
{

    public static function fromCharCode($code) {
        return chr($code);
    }

    public static function fromCharCodeAt($input, $index)
    {
        return ord($input[$index]);
    }

}