<?php


namespace botmm\tools;


class Hex
{


    /**
     * @param $string
     * @return string
     */
    public static function HexStringToBin($string)
    {
        $bytes = '';
        $stringArray = explode(' ', $string);
        for ($i = 0; $i < count($stringArray); $i++) {
            $bytes .= hex2bin($stringArray[$i]);
        }
        return $bytes;
    }

    public static function BinToHexString($string, $withSpace = true) {
        $hexString = bin2hex($string);
        if($withSpace) {
            preg_match_all('/[\da-f]{2}/', $hexString, $mathes);
            $hexString = implode(' ', $mathes[0]);
        }
        return $hexString;
    }
}
