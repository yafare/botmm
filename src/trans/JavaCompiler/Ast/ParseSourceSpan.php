<?php


namespace trans\JavaCompiler\Ast;


class ParseSourceSpan
{
    /**
     * @var ParseLocation
     */
    public $start;
    /**
     * @var ParseLocation
     */
    public $end;
    /**
     * @var string
     */
    public $details;

    public function __construct(
        $start,
        $end,
        $details = null
    ) {
        $this->start   = $start;
        $this->end     = $end;
        $this->details = $details;
    }

    public function toString(): string
    {
        return StringWrapper:: substring($this->start->file->content, $this->start->offset, $this->end->offset);
    }
}