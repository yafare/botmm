<?php


namespace trans\JavaCompiler\Wrapper;


class ArrayWrapper
{

    public static function indexOf($array, $item) {
        return array_search($item, $array);
    }
}