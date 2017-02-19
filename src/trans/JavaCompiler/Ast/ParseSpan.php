<?php
/**
 * Created by IntelliJ IDEA.
 * User: hugo
 * Date: 2017/2/19
 * Time: 11:55
 */

namespace src\trans\JavaCompiler;


class ParseSpan
{
    public $start;
    public $end;

    public function __constructor(int $start, int $end)
    {
        $this->start = $start;
        $this->end = $end;
    }
}