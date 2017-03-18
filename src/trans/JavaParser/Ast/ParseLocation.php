<?php


namespace trans\JavaParser\Ast;


use trans\JavaParser\Chars;
use trans\JavaParser\Wrapper\StringWrapper;

class ParseLocation
{
    /**
     * @var ParseSourceFile
     */
    public $file;
    public $offset;
    public $line;
    public $col;

    public function __construct($file, $offset, $line, $col)
    {
        $this->file   = $file;
        $this->offset = $offset;
        $this->line   = $line;
        $this->col    = $col;
    }

    public function toString(): string
    {
        return isPresent($this->offset) ? "{$this->file->url}@{$this->line}:{$this->col}" : $this->file->url;
    }

    public function moveBy($delta): ParseLocation
    {
        $source = $this->file->content;
        $len    = StringWrapper::length($source);
        $offset = $this->offset;
        $line   = $this->line;
        $col    = $this->col;
        while ($offset > 0 && $delta < 0) {
            $offset--;
            $delta++;
            $ch = StringWrapper::charCodeAt($source, $offset);
            if ($ch == Chars::LF) {
                $line--;
                $priorLine = source . substr(0, offset - 1) . lastIndexOf(String . fromCharCode(chars . $LF));
                $col = priorLine > 0 ? offset - priorLine : offset;
            } else {
                col--;
            }
        }
        while (offset < len && delta > 0) {
            const ch = source . charCodeAt(offset);
            offset++;
            delta--;
            if (ch == chars . $LF) {
                line++;
                col = 0;
            } else {
                col++;
            }
        }
        return new ParseLocation(this . file, offset, line, col);
    }

    // Return the source around the location
    // Up to `maxChars` or `maxLines` on each side of the location
    public function getContext($maxChars, $maxLines)/*: {before: string, after: string} */
    {
        $content     = $this->file->content;
        $startOffset = $this->offset;

        if ($startOffset) {
            if ($startOffset > strlen($content) - 1) {
                $startOffset = strlen($content) - 1;
            }
            $endOffset = $startOffset;
            $ctxChars  = 0;
            $ctxLines  = 0;

            while ($ctxChars < $maxChars && $startOffset > 0) {
                $startOffset--;
                $ctxChars++;
                if ($content[$startOffset] == '\n') {
                    if (++$ctxLines == $maxLines) {
                        break;
                    }
                }
            }

            $ctxChars = 0;
            $ctxLines = 0;
            while ($ctxChars < $maxChars && $endOffset < strlen($content) - 1) {
                $endOffset++;
                $ctxChars++;
                if ($content[$endOffset] == '\n') {
                    if (++$ctxLines == $maxLines) {
                        break;
                    }
                }
            }

            return [
                'before' => StringWrapper::subString($content, $startOffset, $this->offset),
                'after'  => StringWrapper::subString($content, $this->offset, $endOffset + 1)
            ];
        }

        return null;
    }
}