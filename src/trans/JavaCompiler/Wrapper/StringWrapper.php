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

    public static function subString($input, $start, $length) {
        return substr($input, $start, $length);
    }

    public static function IndexOf($input, $string) {
        return strpos($input, $string);
    }
}