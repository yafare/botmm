<?php


namespace botmm\Tars\Protocol\Tars;

use botmm\BufferBundle\Buffer\Buffer;
use botmm\BufferBundle\Buffer\StreamInputBuffer;
use botmm\Tars\Protocol\Tars\Exception\TarsDecodeException;
use Ds\Map;
use Exception;
use Reflection;
use ReflectionClass;

class TarsInputStream {

    /**
     * @var StreamInputBuffer
     */
    private $bs; // 缓冲区

    public function __construct($bs) {
        if(is_string($bs)) {
            $this->bs = new StreamInputBuffer(new Buffer($bs));
        }elseif($bs instanceof Buffer){
            $this->bs = new StreamInputBuffer($bs);
        }else{
            $this->bs = $bs;
        }
    }

    public function readHead(HeadData $hd):int {
        $b = $this->bs->readInt8();
        $hd->type = ($b & 0xf);
        $hd->tag = (($b & (0xf << 4)) >> 4);
        if ($hd->tag == 0xf) {
            $hd->tag = $this->bs->readInt8() & 0x00ff;
            return 2;
        }
        return 1;
    }

    private function peakHead(HeadData $hd) {
        //return $this->readHead($hd, bs.duplicate());
        return $this->readHead($hd);
    }

    private function skip(int $len) {
        $this->bs->setOffset($this->bs->getOffset() + $len);
    }

    public function skipToTag(int $tag):boolean {
        try {
            $hd = new HeadData();
                while (true) {
                    $len = $this->peakHead($hd);
                    if ($hd->type == TarsStructBase::$STRUCT_END) {
                        return false;
                    }
                    if ($tag <= $hd->tag) return $tag == $hd->tag;
                    $this->skip($len);
                    $this->skipField($hd->type);
                }
        } catch (TarsDecodeException $e) {
        }
        return false;
    }

    public function skipToStructEnd() {
        $hd = new HeadData();
        do {
            $this->readHead($hd);
            $this->skipField($hd->type);
        } while ($hd->type != TarsStructBase::$STRUCT_END);
    }

    /**
     * @param byte|null $type
     */
    private function skipField(byte $type = null) {
        if($type == null) {
            $hd = new HeadData();
            $this->readHead($hd);
            $type = $hd->type;
        }
        switch ($type) {
            case TarsStructBase::$BYTE:
                $this->skip(1);
                break;
            case TarsStructBase::$SHORT:
                $this->skip(2);
                break;
            case TarsStructBase::$INT:
                $this->skip(4);
                break;
            case TarsStructBase::$LONG:
                $this->skip(8);
                break;
            case TarsStructBase::$FLOAT:
                $this->skip(4);
                break;
            case TarsStructBase::$DOUBLE:
                $this->skip(8);
                break;
            case TarsStructBase::$STRING1:
                $len = $this->bs->readInt8();
                if ($len < 0) $len += 256;
                $this->skip($len);
                break;
            case TarsStructBase::$STRING4:
                $this->skip($this->bs->readInt32BE());
                break;
            case TarsStructBase::$MAP:
                $size = $this->readInt(0, 0, true);
                for ($i = 0; $i < $size * 2; ++$i)
                    $this->skipField();
                break;
            case TarsStructBase::$LIST:
                $size = $this->readInt(0, 0, true);
                for ($i = 0; $i < $size; ++$i)
                    $this->skipField();
                break;
            case TarsStructBase::$SIMPLE_LIST:
                $hd = new HeadData();
                $this->readHead($hd);
                if ($hd->type != TarsStructBase::$BYTE) {
                    throw new TarsDecodeException("skipField with invalid type, type value: {$type}, {$hd->type}");
                }
                $size = $this->readInt(0, 0, true);
                $this->skip($size);
                break;
            case TarsStructBase::$STRUCT_BEGIN:
                $this->skipToStructEnd();
                break;
            case TarsStructBase::$STRUCT_END:
            case TarsStructBase::$ZERO_TAG:
                break;
            default:
                throw new TarsDecodeException("invalid type.");
        }
    }

    public function readBoolean(boolean $b, int $tag, boolean $isRequire):boolean {
        $c = $this->readByte(0x0, $tag, $isRequire);
        return $c != 0;
    }

    /**
     * @param int|string     $c
     * @param int  $tag
     * @param bool $isRequire
     * @return int
     */
    public function readByte($c, int $tag, boolean $isRequire)/*: byte*/ {
        if ($this->skipToTag($tag)) {
            $hd = new HeadData();
            $this->readHead($hd);
            switch ($hd->type) {
                case TarsStructBase::$ZERO_TAG:
                    $c = 0x0;
                    break;
                case TarsStructBase::$BYTE:
                    $c = $this->bs->readInt8();
                    break;
                default:
                    throw new TarsDecodeException("type mismatch.");
            }
        } else if ($isRequire) {
            throw new TarsDecodeException("require field not exist.");
        }
        return $c;
    }

    /**
     * @param short $n
     * @param int   $tag
     * @param bool  $isRequire
     * @return short|int
     */
    public function readShort($n, int $tag, boolean $isRequire)/*:short*/ {
        if ($this->skipToTag($tag)) {
            $hd = new HeadData();
            $this->readHead($hd);
            switch ($hd->type) {
                case TarsStructBase::$ZERO_TAG:
                    $n = 0;
                    break;
                case TarsStructBase::$BYTE:
                    $n = $this->bs->readInt8();
                    break;
                case TarsStructBase::$SHORT:
                    $n = $this->bs->readInt16BE();
                    break;
                default:
                    throw new TarsDecodeException("type mismatch.");
            }
        } else if ($isRequire) {
            throw new TarsDecodeException("require field not exist.");
        }
        return $n;
    }

    public function readInt(int $n, int $tag, boolean $isRequire)/*:int*/ {
        if ($this->skipToTag($tag)) {
                $hd = new HeadData();
                $this->readHead($hd);
                switch ($hd->type) {
                    case TarsStructBase::$ZERO_TAG:
                        $n = 0;
                        break;
                    case TarsStructBase::$BYTE:
                        $n = $this->bs->readInt8();
                        break;
                    case TarsStructBase::$SHORT:
                        $n = $this->bs->readInt16BE();
                        break;
                    case TarsStructBase::$INT:
                        $n = $this->bs->readInt32BE();
                        break;
                    default:
                        throw new TarsDecodeException("type mismatch.");
                }
            } else if ($isRequire) {
            throw new TarsDecodeException("require field not exist.");
        }
        return $n;
    }

    /**
     * @param long $n
     * @param int  $tag
     * @param bool $isRequire
     * @return long|int|string
     */
    public function readLong($n, int $tag, boolean $isRequire)/*:long*/ {
        if ($this->skipToTag($tag)) {
            $hd = new HeadData();
            $this->readHead($hd);
            switch ($hd->type) {
                case TarsStructBase::$ZERO_TAG:
                    $n = 0;
                    break;
                case TarsStructBase::$BYTE:
                    $n = $this->bs->readInt8();
                    break;
                case TarsStructBase::$SHORT:
                    $n = $this->bs->readInt16BE();
                    break;
                case TarsStructBase::$INT:
                    $n = $this->bs->readInt32BE();
                    break;
                case TarsStructBase::$LONG:
                    $n = $this->bs->readInt64BE();
                    break;
                default:
                    throw new TarsDecodeException("type mismatch.");
            }
        } else if ($isRequire) {
            throw new TarsDecodeException("require field not exist.");
        }
        return $n;
    }

    public function readFloat(float $n, int $tag, boolean $isRequire)/*:float*/ {
        if ($this->skipToTag($tag)) {
            $hd = new HeadData();
            $this->readHead($hd);
            switch ($hd->type) {
                case TarsStructBase::$ZERO_TAG:
                    $n = 0;
                    break;
                case TarsStructBase::$FLOAT:
                    $n = $this->bs->readFloatBE();
                    break;
                default:
                    throw new TarsDecodeException("type mismatch.");
            }
        } else if ($isRequire) {
            throw new TarsDecodeException("require field not exist.");
        }
        return $n;
    }

    public function readDouble(double $n, int $tag, boolean $isRequire)/*:double*/ {
        if ($this->skipToTag($tag)) {
            $hd = new HeadData();
            $this->readHead($hd);
            switch ($hd->type) {
                case TarsStructBase::$ZERO_TAG:
                    $n = 0;
                    break;
                case TarsStructBase::$FLOAT:
                    $n = $this->bs->readFloatBE();
                    break;
                case TarsStructBase::$DOUBLE:
                    $n = $this->bs->readDoubleBE();
                    break;
                default:
                    throw new TarsDecodeException("type mismatch.");
            }
        } else if ($isRequire) {
            throw new TarsDecodeException("require field not exist.");
        }
        return $n;
    }

    public function readByteString(String $s, int $tag, boolean $isRequire)/*:string*/ {
        if ($this->skipToTag($tag)) {
                $hd = new HeadData();
                $this->readHead($hd);
                switch ($hd->type) {
                    case TarsStructBase::$STRING1: {
                        $len = $this->bs->readInt8();
                        if ($len < 0) $len += 256;
                        $ss = $this->bs->read($len);
                        $s = HexUtil.bytes2HexStr($ss);
                    }
                        break;
                    case TarsStructBase::$STRING4: {
                        $len = $this->bs->readInt32BE();
                        if ($len > TarsStructBase::$MAX_STRING_LENGTH || $len < 0) throw new TarsDecodeException("String too long: " + $len);
                        $ss = $this->bs->read($len);
                        $s = HexUtil.bytes2HexStr($ss);
                    }
                        break;
                    default:
                        throw new TarsDecodeException("type mismatch.");
                }
            } else if ($isRequire) {
            throw new TarsDecodeException("require field not exist.");
        }
        return $s;
    }

    public function readString(String $s, int $tag, boolean $isRequire):string {
        if ($this->skipToTag($tag)) {
            $hd = new HeadData();
            $this->readHead($hd);
            switch ($hd->type) {
                case TarsStructBase::$STRING1:
                    $len = $this->bs->readInt8();
                    if ($len < 0) $len += 256;
                    $ss = $this->bs->read($len);
                    $s = mb_convert_encoding($ss, $this->sServerEncoding);
                    break;
                case TarsStructBase::$STRING4:
                    $len = $this->bs->readInt32BE();
                    if ($len > TarsStructBase::$MAX_STRING_LENGTH || $len < 0) {
                        throw new TarsDecodeException("String too long: $len");
                    }
                    $ss = $this->bs->read($len);
                    $s = mb_convert_encoding($ss, $this->sServerEncoding);
                    break;
                default:
                    throw new TarsDecodeException("type mismatch.");
            }
        } else if ($isRequire) {
            throw new TarsDecodeException("require field not exist.");
        }
        return $s;
    }

    /**
     * @param string[] $s
     * @param int   $tag
     * @param bool  $isRequire
     * @return mixed
     */
    public function read(array $s, int $tag, boolean $isRequire)/*: String[]*/ {
        return $this->readArray($s, $tag, $isRequire);
    }

    public function readStringMap(int $tag, boolean $isRequire)/*:Map<String, String>*/ {
        $mr = new Map();
        if ($this->skipToTag($tag)) {
            $hd = new HeadData();
            $this->readHead($hd);
            switch ($hd->type) {
                case TarsStructBase::$MAP: {
                    $size = $this->read(0, 0, true);
                    if ($size < 0) throw new TarsDecodeException("size invalid: $size");
                    for ($i = 0; $i < $size; ++$i) {
                        $k = $this->readString(null, 0, true);
                        $v = $this->readString(null, 1, true);
                        $mr->put($k, $v);
                    }
                }
                    break;
                default:
                    throw new TarsDecodeException("type mismatch.");
            }
        } else if ($isRequire) {
            throw new TarsDecodeException("require field not exist.");
        }
        return $mr;
    }

    //public function readMap($m, int $tag, boolean $isRequire)/*: <K, V> HashMap<K, V> */ {
    //    return $this->readMap(new Map(), $m, $tag, $isRequire);
    //}

    private function readMap(Map $mr, Map $m, int $tag, boolean $isRequire) {
        if ($m == null || $m.isEmpty()) {
            return new Map();
        }

        $it = $m->getIterator();
        $en = $it->next();
        $mk = $en->getKey();
        $mv = $en->getValue();

        if ($this->skipToTag($tag)) {
            $hd = new HeadData();
            $this->readHead($hd);
            switch ($hd->type) {
                case TarsStructBase::$MAP: {
                    $size = $this->readInt(0, 0, true);
                    if ($size < 0) throw new TarsDecodeException("size invalid: $size");
                    for ($i = 0; $i < $size; ++$i) {
                        $k = $this->read($mk, 0, true);
                        $v = $this->read($mv, 1, true);
                        $mr->put($k, $v);
                    }
                }
                    break;
                default:
                    throw new TarsDecodeException("type mismatch.");
            }
        } else if ($isRequire) {
            throw new TarsDecodeException("require field not exist.");
        }
        return $mr;
    }

    public function readList(int $tag, boolean $isRequire) {
        //List $lr = new ArrayList();
        $lr = [];
        if ($this->skipToTag($tag)) {
            $hd = new HeadData();
            $this->readHead($hd);
            switch ($hd->type) {
                case TarsStructBase::$LIST: {
                    $size = $this->read(0, 0, true);
                    if ($size < 0) throw new TarsDecodeException("size invalid: $size");
                    for ($i = 0; $i < $size; ++$i) {
                        $subH = new HeadData();
                        $this->readHead($subH);
                        switch ($subH->type) {
                            case TarsStructBase::$BYTE:
                                $this->skip(1);
                                break;
                            case TarsStructBase::$SHORT:
                                $this->skip(2);
                                break;
                            case TarsStructBase::$INT:
                                $this->skip(4);
                                break;
                            case TarsStructBase::$LONG:
                                $this->skip(8);
                                break;
                            case TarsStructBase::$FLOAT:
                                $this->skip(4);
                                break;
                            case TarsStructBase::$DOUBLE:
                                $this->skip(8);
                                break;
                            case TarsStructBase::$STRING1: {
                                $len = $this->bs->readInt8();
                                if ($len < 0) $len += 256;
                                $this->skip($len);
                            }
                                break;
                            case TarsStructBase::$STRING4: {
                                $this->skip($this->bs->readInt32BE());
                            }
                                break;
                            case TarsStructBase::$MAP: {

                            }
                                break;
                            case TarsStructBase::$LIST: {

                            }
                                break;
                            case TarsStructBase::$STRUCT_BEGIN:
                                try {
                                    $rf = new ReflectionClass(TarsStructBase::class);
                                    $cons = $rf->getConstructor();
                                    /** @var TarsStructBase $struct */
                                    $struct = $cons->invoke(null);
                                    $struct.readFrom($this);
                                    $this->skipToStructEnd();
                                    $lr[] = $struct;
                                } catch (Exception $e) {
                                throw new TarsDecodeException("type mismatch. {$e->getMessage()}");
                            }
                                break;
                            case TarsStructBase::$ZERO_TAG:
                                $lr[] = 0;
                                break;
                            default:
                                throw new TarsDecodeException("type mismatch.");
                        }
                    }
                }
                    break;
                default:
                    throw new TarsDecodeException("type mismatch.");
            }
        } else if ($isRequire) {
            throw new TarsDecodeException("require field not exist.");
        }
        return $lr;
    }

    /**
     * @param boolean[]     $l
     * @param int  $tag
     * @param bool $isRequire
     * @return mixed
     */
    public function readBooleanArray($l, int $tag, boolean $isRequire)/*:boolean[]*/ {
        $lr = [];
        if ($this->skipToTag($tag)) {
            $hd = new HeadData();
            $this->readHead($hd);
            switch ($hd->type) {
                case TarsStructBase::$LIST: {
                    $size = $this->readInt(0, 0, true);
                    if ($size < 0) throw new TarsDecodeException("size invalid: $size");
                    for ($i = 0; $i < $size; ++$i)
                        $lr[$i] = $this->readBoolean($lr[0], 0, true);
                    break;
                }
                default:
                    throw new TarsDecodeException("type mismatch.");
            }
        } else if ($isRequire) {
            throw new TarsDecodeException("require field not exist.");
        }
        return $lr;
    }

    /**
     * @param byte[]     $l
     * @param int  $tag
     * @param bool $isRequire
     * @return mixed
     */
    public function readByteArray($l, int $tag, boolean $isRequire) {
        $lr = "";
        if ($this->skipToTag($tag)) {
            $hd = new HeadData();
            $this->readHead($hd);
            switch ($hd->type) {
                case TarsStructBase::$SIMPLE_LIST: {
                    $hh = new HeadData();
                    $this->readHead($hh);
                    if ($hh->type != TarsStructBase::$BYTE) {
                        throw new TarsDecodeException("type mismatch, tag: {$tag}, type: {$hd->type}, {$hh->type}");
                    }
                    $size = $this->readInt(0, 0, true);
                    if ($size < 0) throw new TarsDecodeException("invalid size, tag: {$tag}, type: {$hd->type}, {$hh->type}, size: {$size}");
                    $lr = $this->bs->read($size);
                    break;
                }
                case TarsStructBase::$LIST: {
                    $size = $this->readInt(0, 0, true);
                    if ($size < 0) throw new TarsDecodeException("size invalid: {$size}");
                    for ($i = 0; $i < $size; ++$i)
                        $lr .= $this->readByte($lr[0], 0, true);
                    break;
                }
                default:
                    throw new TarsDecodeException("type mismatch.");
            }
        } else if ($isRequire) {
            throw new TarsDecodeException("require field not exist.");
        }
        return $lr;
    }

    /**
     * @param short[]     $l
     * @param int  $tag
     * @param bool $isRequire
     * @return array
     */
    public function readShortArray( $l, int $tag, boolean $isRequire)/*:short[] */ {
        $lr = [];
        if ($this->skipToTag($tag)) {
            $hd = new HeadData();
            $this->readHead($hd);
            switch ($hd->type) {
                case TarsStructBase::$LIST: {
                    $size = $this->readInt(0, 0, true);
                    if ($size < 0) throw new TarsDecodeException("size invalid: {$size}");
                    for ($i = 0; $i < $size; ++$i)
                        $lr[$i] = $this->readShort($lr[0], 0, true);
                    break;
                }
                default:
                    throw new TarsDecodeException("type mismatch.");
            }
        } else if ($isRequire) {
            throw new TarsDecodeException("require field not exist.");
        }
        return $lr;
    }

    /**
     * @param int[]     $l
     * @param int  $tag
     * @param bool $isRequire
     * @return mixed
     */
    public function readIntArray($l, int $tag, boolean $isRequire) {
        $lr = [];
        if ($this->skipToTag($tag)) {
            $hd = new HeadData();
            $this->readHead($hd);
            switch ($hd->type) {
                case TarsStructBase::$LIST: {
                    $size = $this->readInt(0, 0, true);
                    if ($size < 0) throw new TarsDecodeException("size invalid: $size");
                    for ($i = 0; $i < $size; ++$i)
                        $lr[$i] = $this->readInt($lr[0], 0, true);
                    break;
                }
                default:
                    throw new TarsDecodeException("type mismatch.");
            }
        } else if ($isRequire) {
            throw new TarsDecodeException("require field not exist.");
        }
        return $lr;
    }

    /**
     * @param long[]     $l
     * @param int  $tag
     * @param bool $isRequire
     * @return mixed
     */
    public function readLongArray($l, int $tag, boolean $isRequire) {
        $lr = [];
        if ($this->skipToTag($tag)) {
            $hd = new HeadData();
            $this->readHead($hd);
            switch ($hd->type) {
                case TarsStructBase::$LIST: {
                    $size = $this->readInt(0, 0, true);
                    if ($size < 0) throw new TarsDecodeException("size invalid: $size");
                    for ($i = 0; $i < $size; ++$i)
                        $lr[$i] = $this->readLong($lr[0], 0, true);
                    break;
                }
                default:
                    throw new TarsDecodeException("type mismatch.");
            }
        } else if ($isRequire) {
            throw new TarsDecodeException("require field not exist.");
        }
        return $lr;
    }

    /**
     * @param float[]     $l
     * @param int  $tag
     * @param bool $isRequire
     * @return mixed
     */
    public function readFloatArray($l, int $tag, boolean $isRequire) {
        $lr = null;
        if ($this->skipToTag($tag)) {
            $hd = new HeadData();
            $this->readHead($hd);
            switch ($hd->type) {
                case TarsStructBase::$LIST: {
                    $size = $this->readInt(0, 0, true);
                    if ($size < 0) throw new TarsDecodeException("size invalid: $size");
                    for ($i = 0; $i < $size; ++$i)
                        $lr[$i] = $this->readFloat($lr[0], 0, true);
                    break;
                }
                default:
                    throw new TarsDecodeException("type mismatch.");
            }
        } else if ($isRequire) {
            throw new TarsDecodeException("require field not exist.");
        }
        return $lr;
    }

    /**
     * @param double[]     $l
     * @param int  $tag
     * @param bool $isRequire
     * @return mixed
     */
    public function readDoubleArray($l, int $tag, boolean $isRequire) {
        $lr = null;
        if ($this->skipToTag($tag)) {
            $hd = new HeadData();
            $this->readHead($hd);
            switch ($hd->type) {
                case TarsStructBase::$LIST: {
                    $size = $this->readInt(0, 0, true);
                    if ($size < 0) throw new TarsDecodeException("size invalid: $size");
                    for ($i = 0; $i < $size; ++$i)
                        $lr[$i] = $this->readDouble($lr[0], 0, true);
                    break;
                }
                default:
                    throw new TarsDecodeException("type mismatch.");
            }
        } else if ($isRequire) {
            throw new TarsDecodeException("require field not exist.");
        }
        return $lr;
    }

    /**
     * define array like this
     * [
     *  foo|int
     *  bar|float
     * ]
     *
     * @param      $l
     * @param int  $tag
     * @param bool $isRequire
     * @return mixed
     */
    public function readArray($l, int $tag, boolean $isRequire) {
        if ($l == null || count($l) == 0) {
            return [];
        };
        return $this->readArrayImpl($l[0], $tag, $isRequire);
    }

     /**
     * @param      $mt define the type
     * @param int  $tag
     * @param bool $isRequire
     * @return null
     */
    private function readArrayImpl($mt, int $tag, boolean $isRequire) {
        if ($this->skipToTag($tag)) {
            $hd = new HeadData();
                $this->readHead($hd);
                switch ($hd->type) {
                    case TarsStructBase::$LIST: {
                        $size = $this->readInt(0, 0, true);
                        if ($size < 0) throw new TarsDecodeException("size invalid: $size");

                        $readMethod = "read" . ucfirst($mt);
                        $lr = [];
                        for ($i = 0; $i < $size; ++$i) {
                            $t = $this->{$readMethod}($mt, 0, true);
                            $lr[$i] = $t;
                        }
                        return $lr;
                    }
                    default:
                        throw new TarsDecodeException("type mismatch.");
                }
            } else if ($isRequire) {
            throw new TarsDecodeException("require field not exist.");
        }
        return null;
    }

    public function directReadTarsStruct(TarsStructBase $o, int $tag, boolean $isRequire) {
        $ref = null;
        if ($this->skipToTag($tag)) {
            try {
                $ref = $o.newInit();
            } catch (Exception $e) {
                throw new TarsDecodeException($e->getMessage());
            }

            $hd = new HeadData();
            $this->readHead($hd);
            if ($hd->type != TarsStructBase::$STRUCT_BEGIN) throw new TarsDecodeException("type mismatch.");
            $ref.readFrom($this);
            $this->skipToStructEnd();
        } else if ($isRequire) {
            throw new TarsDecodeException("require field not exist.");
        }
        return $ref;
    }

    /**
     * @param string     $o class's name, the class extend TarsStructBase
     * @param int  $tag
     * @param bool $isRequire
     * @return null|ReflectionClass
     */
    public function readTarsStruct(/*TarsStructBase*/ $o, int $tag, boolean $isRequire) {
        $ref = null;
        if ($this->skipToTag($tag)) {
            try {
                //$ref = $o.getClass().newInstance();
                $ref = new ReflectionClass($o);
            } catch (Exception $e) {
                throw new TarsDecodeException($e->getMessage());
            }

            $hd = new HeadData();
            $this->readHead($hd);
            if ($hd->type != TarsStructBase::$STRUCT_BEGIN) throw new TarsDecodeException("type mismatch.");
            $ref.readFrom($this);
            $this->skipToStructEnd();
        } else if ($isRequire) {
            throw new TarsDecodeException("require field not exist.");
        }
        return $ref;
    }

    /**
     * @param TarsStructBase[]     $o
     * @param int  $tag
     * @param bool $isRequire
     * @return mixed
     */
     public function readTarsStructArray($o, int $tag, boolean $isRequire) {
        return $this->readArray($o, $tag, $isRequire);
    }

    protected $sServerEncoding = "GBK";

    public function setServerEncoding(string $se):int {
        $this->sServerEncoding = $se;
        return 0;
    }

    public function getBs() {
        return $this->bs;
    }
}