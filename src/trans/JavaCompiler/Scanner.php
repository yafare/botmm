<?php


namespace src\trans\JavaCompiler;


class _Scanner {
    public $length;
    public $peek = 0;
    public $index = -1;
    private $input;

    public function __construct($input)
    {
        $this->input = $input;
        $this->length = strlen($input);
        $this->advance();
    }

    public function advance() {
        $this->peek = ++$this->index >= $this->length ? chars::EOF : StringWrapper::fromCharCodeAt($this->input, $this->index);
    }

    public function scanToken(): Token {
        $input = $this->input;
        $length = $this->length;
        $peek = $this->peek;
        $index = $this->index;

        // Skip whitespace.
        while ($peek <= chars::SPACE) {
            if (++$index >= $length) {
                $peek = chars::EOF;
                break;
            } else {
                $peek = StringWrapper::fromCharCodeAt($input, $index);
            }
        }

        $this->peek = $peek;
        $this->index = $index;

        if ($index >= $length) {
            return null;
        }

        // Handle identifiers and numbers.
        if (isIdentifierStart($peek)) return $this->scanIdentifier();
        if (chars::isDigit($peek)) return $this->scanNumber($index);

        $start = $index;
        switch ($peek) {
        case chars::PERIOD:
            $this->advance();
            return chars::isDigit($this->peek) ? $this->scanNumber(start) :
                Util::newCharacterToken($start, chars::PERIOD);
        case chars::LPAREN:
        case chars::RPAREN:
        case chars::LBRACE:
        case chars::RBRACE:
        case chars::LBRACKET:
        case chars::RBRACKET:
        case chars::COMMA:
        case chars::COLON:
        case chars::SEMICOLON:
            return $this->scanCharacter(start, peek);
        case chars::SQ:
        case chars::DQ:
            return $this->scanString();
        case chars::HASH:
        case chars::PLUS:
        case chars::MINUS:
        case chars::STAR:
        case chars::SLASH:
        case chars::PERCENT:
        case chars::CARET:
            return $this->scanOperator(start, String.fromCharCode(peek));
        case chars.$QUESTION:
            return $this->scanComplexOperator(start, '?', chars.$PERIOD, '.');
        case chars.$LT:
        case chars.$GT:
            return $this->scanComplexOperator(start, String.fromCharCode(peek), chars.$EQ, '=');
        case chars.$BANG:
        case chars.$EQ:
            return $this->scanComplexOperator(
                start, String.fromCharCode(peek), chars.$EQ, '=', chars.$EQ, '=');
        case chars.$AMPERSAND:
            return $this->scanComplexOperator(start, '&', chars.$AMPERSAND, '&');
        case chars.$BAR:
            return $this->scanComplexOperator(start, '|', chars.$BAR, '|');
        case chars.$NBSP:
            while (chars.isWhitespace($this->peek)) $this->advance();
            return $this->scanToken();
    }

    $this->advance();
    return $this->error(`Unexpected character [${String.fromCharCode(peek)}]`, 0);
  }

scanCharacter(start: number, code: number): Token {
$this->advance();
return newCharacterToken(start, code);
}


scanOperator(start: number, str: string): Token {
    $this->advance();
    return newOperatorToken(start, str);
}

  /**
   * Tokenize a 2/3 char long operator
   *
   * @param start start index in the expression
   * @param one first symbol (always part of the operator)
   * @param twoCode code point for the second symbol
   * @param two second symbol (part of the operator when the second code point matches)
   * @param threeCode code point for the third symbol
   * @param three third symbol (part of the operator when provided and matches source expression)
   * @returns {Token}
   */
  scanComplexOperator(
      start: number, one: string, twoCode: number, two: string, threeCode?: number,
      three?: string): Token {
    $this->advance();
    let str: string = one;
    if ($this->peek == twoCode) {
        $this->advance();
        str += two;
    }
    if (threeCode != null && $this->peek == threeCode) {
        $this->advance();
        str += three;
    }
    return newOperatorToken(start, str);
  }

  scanIdentifier(): Token {
    const start: number = $this->index;
    $this->advance();
    while (isIdentifierPart($this->peek)) $this->advance();
    const str: string = $this->input.substring(start, $this->index);
    return KEYWORDS.indexOf(str) > -1 ? newKeywordToken(start, str) :
        newIdentifierToken(start, str);
  }

  scanNumber(start: number): Token {
    let simple: boolean = ($this->index === start);
    $this->advance();  // Skip initial digit.
    while (true) {
        if (chars.isDigit($this->peek)) {
            // Do nothing.
        } else if ($this->peek == chars.$PERIOD) {
            simple = false;
        } else if (isExponentStart($this->peek)) {
            $this->advance();
            if (isExponentSign($this->peek)) $this->advance();
            if (!chars.isDigit($this->peek)) return $this->error('Invalid exponent', -1);
            simple = false;
        } else {
            break;
        }
        $this->advance();
    }
    const str: string = $this->input.substring(start, $this->index);
    const value: number = simple ? NumberWrapper.parseIntAutoRadix(str) : parseFloat(str);
    return newNumberToken(start, value);
  }

  scanString(): Token {
    const start: number = $this->index;
    const quote: number = $this->peek;
    $this->advance();  // Skip initial quote.

    let buffer: string = '';
    let marker: number = $this->index;
    const input: string = $this->input;

    while ($this->peek != quote) {
        if ($this->peek == chars.$BACKSLASH) {
            buffer += input.substring(marker, $this->index);
            $this->advance();
            let unescapedCode: number;
        // Workaround for TS2.1-introduced type strictness
        $this->peek = $this->peek;
        if ($this->peek == chars.$u) {
            // 4 character hex code for unicode character.
            const hex: string = input.substring($this->index + 1, $this->index + 5);
          if (/^[0-9a-f]+$/i.test(hex)) {
                unescapedCode = parseInt(hex, 16);
            } else {
                return $this->error(`Invalid unicode escape [\\u${hex}]`, 0);
            }
          for (let i: number = 0; i < 5; i++) {
              $this->advance();
          }
        } else {
            unescapedCode = unescape($this->peek);
            $this->advance();
        }
        buffer += String.fromCharCode(unescapedCode);
        marker = $this->index;
      } else if ($this->peek == chars.$EOF) {
            return $this->error('Unterminated quote', 0);
        } else {
            $this->advance();
        }
    }

    const last: string = input.substring(marker, $this->index);
    $this->advance();  // Skip terminating quote.

    return newStringToken(start, buffer + last);
  }

  error(message: string, offset: number): Token {
    const position: number = $this->index + offset;
    return newErrorToken(
        position, `Lexer Error: ${message} at column ${position} in expression [${$this->input}]`);
  }
}