<?php


namespace botmm\tools;


use botmm\BufferBundle\Buffer\Buffer;
use botmm\tools\Cypher\Tea;

class Cryptor
{

    public static function decrypt($paramArrayOfByte1, $paramInt1, $paramInt2, $paramArrayOfByte2)
    {
        if (($paramArrayOfByte1 == null) || ($paramArrayOfByte2 == null)) {
            return null;
        }
        $arrayOfByte1 = (new Buffer($paramArrayOfByte1))->read($paramInt1, $paramInt2);
        return Tea::decrypt($arrayOfByte1, $paramArrayOfByte2);
    }

    public static function encrypt($paramArrayOfByte1, $paramInt1, $paramInt2, $paramArrayOfByte2)
    {
        if (($paramArrayOfByte1 == null) || ($paramArrayOfByte2 == null)) {
            return null;
        }
        $arrayOfByte1 = (new Buffer($paramArrayOfByte1))->read($paramInt1, $paramInt2);
        return Tea::encrypt($arrayOfByte1, $paramArrayOfByte2);
    }
}