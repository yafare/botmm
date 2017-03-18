<?php


namespace trans\JavaParser\Wrapper;


class StringWrapper
{

    public static function fromCharCode($code)
    {
        return chr($code);
    }

    public static function charCodeAt($input, $index)
    {
        return ord($input[$index]);
    }

    public static function subStr($input, $start, $length)
    {
        return substr($input, $start, $length);
    }

    public static function subString($input, $start, $end)
    {
        if ($end < $start) {
            return substr($input, $end, $start - $end);
        }
        return substr($input, $start, $end - $start);
    }

    public static function toLowerCase($input)
    {
        return strtolower($input);
    }

    public static function IndexOf($input, $string)
    {
        return strpos($input, $string);
    }

    public static function length($source)
    {
        return strlen($source);
    }
}