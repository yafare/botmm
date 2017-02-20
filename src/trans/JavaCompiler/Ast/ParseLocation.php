<?php


namespace trans\JavaCompiler\Ast;


class ParseLocation {
constructor(
public file: ParseSourceFile, public offset: number, public line: number,
public col: number) {}

toString(): string {
    return isPresent(this.offset) ? `${this.file.url}@${this.line}:${this.col}` : this.file.url;
}

  moveBy(delta: number): ParseLocation {
    const source = this.file.content;
    const len = source.length;
    let offset = this.offset;
    let line = this.line;
    let col = this.col;
    while (offset > 0 && delta < 0) {
        offset--;
        delta++;
        const ch = source.charCodeAt(offset);
        if (ch == chars.$LF) {
            line--;
            const priorLine = source.substr(0, offset - 1).lastIndexOf(String.fromCharCode(chars.$LF));
            col = priorLine > 0 ? offset - priorLine : offset;
        } else {
            col--;
        }
    }
    while (offset < len && delta > 0) {
        const ch = source.charCodeAt(offset);
        offset++;
        delta--;
        if (ch == chars.$LF) {
            line++;
            col = 0;
        } else {
            col++;
        }
    }
    return new ParseLocation(this.file, offset, line, col);
  }

  // Return the source around the location
  // Up to `maxChars` or `maxLines` on each side of the location
  getContext(maxChars: number, maxLines: number): {before: string, after: string} {
    const content = this.file.content;
    let startOffset = this.offset;

    if (isPresent(startOffset)) {
        if (startOffset > content.length - 1) {
            startOffset = content.length - 1;
        }
        let endOffset = startOffset;
      let ctxChars = 0;
      let ctxLines = 0;

      while (ctxChars < maxChars && startOffset > 0) {
          startOffset--;
          ctxChars++;
          if (content[startOffset] == '\n') {
              if (++ctxLines == maxLines) {
                  break;
              }
          }
      }

      ctxChars = 0;
      ctxLines = 0;
      while (ctxChars < maxChars && endOffset < content.length - 1) {
          endOffset++;
          ctxChars++;
          if (content[endOffset] == '\n') {
              if (++ctxLines == maxLines) {
                  break;
              }
          }
      }

      return {
            before: content.substring(startOffset, this.offset),
        after: content.substring(this.offset, endOffset + 1),
      };
    }

    return null;
  }
}