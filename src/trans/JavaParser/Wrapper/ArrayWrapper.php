<?php


namespace trans\JavaParser\Wrapper;


class ArrayWrapper
{

    public static function indexOf($array, $item)
    {
        $result = array_search($item, $array);

        if ($result === false) {
            $result = -1;
        }
        return $result;
    }
}