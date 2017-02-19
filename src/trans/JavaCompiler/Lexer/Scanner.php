<?php


namespace src\trans\JavaCompiler\Lexer;


use src\trans\JavaCompiler\Chars;
use src\trans\JavaCompiler\StringWrapper;

class Scanner
{
    private static $KEYWORDS;
    private static $EOF;

    public  $length;
    public  $peek  = 0;
    public  $index = -1;
    private $input;

    public function __construct($input)
    {
        self::$KEYWORDS = ['var', 'let', 'null', 'undefined', 'true', 'false', 'if', 'else', 'this'];
        self::$EOF      = new Token(-1, TokenType::Character, 0, '');

        $this->input  = $input;
        $this->length = strlen($input);
        $this->advance();
    }

    public function advance()
    {
        $this->peek = ++$this->index >= $this->length ? chars::EOF : StringWrapper::fromCharCodeAt($this->input,
                                                                                                   $this->index);
    }

    public function scanToken(): Token
    {
        $input  = $this->input;
        $length = $this->length;
        $peek   = $this->peek;
        $index  = $this->index;

        // Skip whitespace.
        while ($peek <= chars::SPACE) {
            if (++$index >= $length) {
                $peek = chars::EOF;
                break;
            } else {
                $peek = StringWrapper::fromCharCodeAt($input, $index);
            }
        }

        $this->peek  = $peek;
        $this->index = $index;

        if ($index >= $length) {
            return null;
        }

        // Handle identifiers and numbers.
        if (Util::isIdentifierStart($peek)) {
            return $this->scanIdentifier();
        }
        if (chars::isDigit($peek)) {
            return $this->scanNumber($index);
        }

        $start = $index;
        switch ($peek) {
            case chars::PERIOD:
                $this->advance();
                return chars::isDigit($this->peek) ? $this->scanNumber($start) :
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
                return $this->scanCharacter($start, $peek);
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
                return $this->scanOperator($start, StringWrapper::fromCharCode($peek));
            case chars::QUESTION:
                return $this->scanComplexOperator($start, '?', chars::PERIOD, '.');
            case chars::LT:
            case chars::GT:
                return $this->scanComplexOperator($start, StringWrapper::fromCharCode($peek), chars::EQ, '=');
            case chars::BANG:
            case chars::EQ:
                return $this->scanComplexOperator(
                    $start, StringWrapper::fromCharCode($peek), chars::EQ, '=', chars::EQ, '=');
            case chars::AMPERSAND:
                return $this->scanComplexOperator($start, '&', chars::AMPERSAND, '&');
            case chars::BAR:
                return $this->scanComplexOperator($start, '|', chars::BAR, '|');
            case chars::NBSP:
                while (chars::isWhitespace($this->peek)) {
                    $this->advance();
                }
                return $this->scanToken();
        }

        $this->advance();
        $peekChar = StringWrapper::fromCharCode($peek);
        return $this->error("Unexpected character [{$peekChar}]", 0);
    }

    public function scanCharacter($start, $code): Token
    {
        $this->advance();
        return Util::newCharacterToken($start, $code);
    }


    public function scanOperator($start, $str): Token
    {
        $this->advance();
        return Util::newOperatorToken($start, $str);
    }

    /**
     * Tokenize a 2/3 char long operator
     *
     * @param int    $start     start index in the expression
     * @param string $one       first symbol (always part of the operator)
     * @param int    $twoCode   code point for the second symbol
     * @param string $two       second symbol (part of the operator when the second code point matches)
     * @param number $threeCode code point for the third symbol
     * @param string $three     third symbol (part of the operator when provided and matches source expression)
     * @returns {Token}
     */
    public function scanComplexOperator(
        $start,
        $one,
        $twoCode,
        $two,
        $threeCode = null,
        $three = null
    ): Token {
        $this->advance();
        $str = $one;
        if ($this->peek == $twoCode) {
            $this->advance();
            $str .= $two;
        }
        if ($threeCode != null && $this->peek == $threeCode) {
            $this->advance();
            $str .= $three;
        }
        return Util::newOperatorToken($start, $str);
    }

    public function scanIdentifier(): Token
    {
        $start = $this->index;
        $this->advance();
        while (Util::isIdentifierPart($this->peek)) {
            $this->advance();
        }
        $str = StringWrapper::subString($this->input, $start, $this->index);
        return StringWrapper::IndexOf(self::$KEYWORDS, $str) > -1 ? Util::newKeywordToken($start, $str) :
            Util::newIdentifierToken($start, $str);
    }

    public function scanNumber($start): Token
    {
        $simple = ($this->index === $start);
        $this->advance();  // Skip initial digit.
        while (true) {
            if (chars:: isDigit($this->peek)) {
                // Do nothing.
            } else {
                if ($this->peek == chars :: PERIOD) {
                    $simple = false;
                } else {
                    if (Util::isExponentStart($this->peek)) {
                        $this->advance();
                        if (Util::isExponentSign($this->peek)) {
                            $this->advance();
                        }
                        if (!chars::isDigit($this->peek)) {
                            return $this->error('Invalid exponent', -1);
                        }
                        $simple = false;
                    } else {
                        break;
                    }
                }
            }
            $this->advance();
        }
        $str   = StringWrapper::subString($this->input, $start, $this->index);
        $value = $simple ? intval($str) : floatval($str);
        return Util::newNumberToken($start, $value);
    }

    public function scanString(): Token
    {
        $start = $this->index;
        $quote = $this->peek;
        $this->advance();  // Skip initial quote.

        $buffer = '';
        $marker = $this->index;
        $input  = $this->input;

        while ($this->peek != $quote) {
            if ($this->peek == chars::BACKSLASH) {
                $buffer += StringWrapper::subString($input, $marker, $this->index);
                $this->advance();
                $unescapedCode = null;
                if ($this->peek == chars::u) {
                    // 4 character hex code for unicode character.
                    $hex = StringWrapper::subString($input, $this->index + 1, $this->index + 5);
                    if (preg_match('/^[0 - 9a - f]+$/i', $hex)) {
                        $unescapedCode = hexdec($hex);
                    } else {
                        return $this->error("Invalid unicode escape [\\u{$hex}]", 0);
                    }
                    for ($i = 0; $i < 5; $i++) {
                        $this->advance();
                    }
                } else {
                    $unescapedCode = Util::unescape($this->peek);
                    $this->advance();
                }
                $buffer += StringWrapper::fromCharCode($unescapedCode);
                $marker = $this->index;
            } else {
                if ($this->peek == chars::EOF) {
                    return $this->error('Unterminated quote', 0);
                } else {
                    $this->advance();
                }
            }
        }

        $last = StringWrapper::subString($input, $marker, $this->index);
        $this->advance();  // Skip terminating quote.

        return Util::newStringToken($start, $buffer + $last);
    }

    public function error($message, $offset): Token
    {
        $position = $this->index + $offset;
        return Util::newErrorToken(
            $position, "Lexer Error: {$message} at column {$position} in expression [{$this->input}]");
    }
}