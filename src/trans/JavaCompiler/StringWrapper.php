<?php


namespace src\trans\JavaCompiler;


class StringWrapper
{

    public static function fromCharCodeAt($input, $index)
    {
        return ord($input[$index]);
    }

}