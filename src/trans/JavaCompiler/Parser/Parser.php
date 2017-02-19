<?php


namespace trans\JavaCompiler\Parser;


use trans\JavaCompiler\Lexer\Lexer;
use trans\JavaCompiler\Lexer\Scanner;
use trans\JavaCompiler\Lexer\Token;
use trans\JavaCompiler\Lexer\TokenType;
use trans\JavaCompiler\Wrapper\StringWrapper;


class ParseAST
{
    private $rparensExpected   = 0;
    private $rbracketsExpected = 0;
    private $rbracesExpected   = 0;

    public $index = 0;

    public $input;
    public $location;
    public $tokens;
    public $inputLength;
    public $parseAction;

    private $errors;
    private $offset;

    public function __construct($input, $location, $tokens, $inputLength, $parseAction, $errors, $offset)
    {
        /** @var string */
        $this->input = $input;
        /**@var any */
        $this->location = $location;
        /**@var Token[] */
        $this->tokens = $tokens;
        /**@var number */
        $this->inputLength = $inputLength;
        /**@var boolean */
        $this->parseAction = $parseAction;
        /**@var ParserError[] */
        $this->errors = $errors;
        /**@var number */
        $this->offset = $offset;
    }

    public function peek($offset): Token
    {
        $i = $this->index + $offset;
        return $i < count($this->tokens) ? $this->tokens[$i] : Lexer::$EOF;
    }

    /**
     * @return Token
     */
    public function getNext(): Token
    {
        return $this->peek(0);
    }

    public function getInputIndex(): number
    {
        return $this->index < count($this->tokens) ?
            $this->getNext()->index + $this->offset :
            $this->inputLength + $this->offset;
    }

    public function span($start)
    {
        return new ParseSpan($start, $this->getInputIndex());
    }

    public function advance()
    {
        $this->index++;
    }

    public function optionalCharacter($code): bool
    {
        if ($this->getNext()->isCharacter($code)) {
            $this->advance();
            return true;
        } else {
            return false;
        }
    }

    public function peekKeywordLet(): bool
    {
        return $this->getNext()->isKeywordLet();
    }

    /**
     * @param $code
     */
    public function expectCharacter($code)
    {
        if ($this->optionalCharacter($code)) {
            return;
        }
        $str = StringWrapper::fromCharCode($code);
        $this->error("Missing expected {$str}");
    }

    public function optionalOperator(string $op): bool
    {
        if ($this->getNext()->isOperator($op)) {
            $this->advance();
            return true;
        } else {
            return false;
        }
    }

    public function expectOperator($operator)
    {
        if ($this->optionalOperator($operator)) {
            return;
        }

        $this->error("Missing expected operator {$operator}");
    }

    public function expectIdentifierOrKeyword(): string
    {
        $n = $this->getNext();
        if (!$n->isIdentifier() && !$n->isKeyword()) {
            $this->error("Unexpected token {$n}, expected identifier or keyword");
            return '';
        }
        $this->advance();
        return $n->toString();
    }

    public function expectIdentifierOrKeywordOrString(): string
    {
        $n = $this->getNext();
        if (!$n->isIdentifier() && !$n->isKeyword() && !$n->isString()) {
            $this->error("Unexpected token $n, expected identifier, keyword, or string");
            return '';
        }
        $this->advance();
        return $n->toString();
    }

    public function parseChain(): AST
    {
        $exprs = [];
        $start = $this->getInputIndex();
        while ($this->index < count($this->tokens)) {
            $expr = $this->parsePipe();
            $exprs->push($expr);

            if ($this->optionalCharacter(chars::SEMICOLON)) {
                if (!$this->parseAction) {
                    $this->error('Binding expression cannot contain chained expression');
                }
                while ($this->optionalCharacter(chars::SEMICOLON)) {
                }  // read all semicolons
            } else {
                if ($this->index < count($this->tokens)) {
                    $this->error("Unexpected token '{$this->getNext()}'");
                }
            }
        }
        if (count($exprs) == 0) {
            return new EmptyExpr($this->span($start));
        }
        if (count($exprs) == 1) {
            return $exprs[0];
        }
        return new Chain($this->span($start), $exprs);
    }

    public function parsePipe(): AST
    {
        $result = $this->parseExpression();
        if ($this->optionalOperator('|')) {
            if ($this->parseAction) {
                $this->error('Cannot have a pipe in an action expression');
            }

            do {
                $name = $this->expectIdentifierOrKeyword();
                $args = [];
                while ($this->optionalCharacter(chars::COLON)) {
                    $args[] = $this->parseExpression();
                }
                $result = new BindingPipe($this->span($result->span->start), $result, $name, $args);
            } while ($this->optionalOperator('|'));
        }

        return $result;
    }

    public function parseExpression(): AST
    {
        return $this->parseConditional();
    }

    public function parseConditional(): AST
    {
        $start  = $this->getInputIndex();
        $result = $this->parseLogicalOr();

        if ($this->optionalOperator('?')) {
            $yes = $this->parsePipe();
            $no  = null;
            if (!$this->optionalCharacter(chars::COLON)) {
                $end        = $this->getInputIndex();
                $expression = StringWrapper::subString($this->input, $start, $end);
                $this->error("Conditional expression ${expression} requires all 3 expressions");
                $no = new EmptyExpr($this->span($start));
            } else {
                $no = $this->parsePipe();
            }
            return new Conditional($this->span($start), $result, $yes, $no);
        } else {
            return $result;
        }
    }

    public function parseLogicalOr(): AST
    {
        // '||'
        $result = $this->parseLogicalAnd();
        while ($this->optionalOperator('||')) {
            $right  = $this->parseLogicalAnd();
            $result = new Binary($this->span($result->span->start), '||', $result, $right);
        }
        return $result;
    }

    public function parseLogicalAnd(): AST
    {
        // '&&'
        $result = $this->parseEquality();
        while ($this->optionalOperator('&&')) {
            $right  = $this->parseEquality();
            $result = new Binary($this->span($result->span->start), '&&', $result, $right);
        }
        return $result;
    }

    public function parseEquality(): AST
    {
        // '==','!=','===','!=='
        $result = $this->parseRelational();
        while ($this->getNext()->type == TokenType :: Operator) {
            $operator = $this->getNext()->strValue;
            switch ($operator) {
                case '==':
                case '===':
                case '!=':
                case '!==':
                    $this->advance();
                    $right  = $this->parseRelational();
                    $result = new Binary($this->span($result->span->start), $operator, $result, $right);
                    continue;
            }
            break;
        }
        return $result;
    }

    public function parseRelational(): AST
    {
        // '<', '>', '<=', '>='
        $result = $this->parseAdditive();
        while ($this->getNext()->type == TokenType :: Operator) {
            $operator = $this->getNext()->strValue;
            switch ($operator) {
                case '<':
                case '>':
                case '<=':
                case '>=':
                    $this->advance();
                    $right  = $this->parseAdditive();
                    $result = new Binary($this->span($result->span->start), $operator, $result, $right);
                    continue;
            }

            break;
        }
        return $result;
    }

parseAdditive(): AST
{
    // '+', '-'
let result = this . parseMultiplicative();
while (this . next . type == TokenType . Operator)
{
    const operator = this . next . strValue;
switch (operator)
{
case '+':
case '-':
this . advance();
let right = this . parseMultiplicative();
result = new Binary(this . span(result . span . start), operator, result, right);
continue;
}

break;
}
return result;
}

parseMultiplicative(): AST {
    // '*', '%', '/'
    let result = this . parsePrefix();
    while (this . next . type == TokenType . Operator) {
        const operator = this . next . strValue;
        switch (operator) {
            case '*':
            case '%':
            case '/':
                this . advance();
                let right = this . parsePrefix();
          result          = new Binary(this . span(result . span . start), operator, result, right);
          continue;
        }
        break;
    }
    return result;
  }

  parsePrefix(): AST {
    if (this . next . type == TokenType . Operator) {
        const start    = this . inputIndex;
        const operator = this . next . strValue;
        let result: AST;
      switch (operator) {
          case '+':
              this . advance();
              return this . parsePrefix();
          case '-':
              this . advance();
              result = this . parsePrefix();
              return new Binary(
                  this . span(start), operator, new LiteralPrimitive(new ParseSpan(start, start), 0),
                  result);
          case '!':
              this . advance();
              result = this . parsePrefix();
              return new PrefixNot(this . span(start), result);
      }
    }
    return this . parseCallChain();
}

  parseCallChain(): AST {
    let result = this . parsePrimary();
    while (true) {
        if (this . optionalCharacter(chars . $PERIOD)) {
            result = this . parseAccessMemberOrMethodCall(result, false);

        } else {
            if (this . optionalOperator('?.')) {
                result = this . parseAccessMemberOrMethodCall(result, true);

            } else {
                if (this . optionalCharacter(chars . $LBRACKET)) {
                    this . rbracketsExpected++;
                    const key = this . parsePipe();
                    this . rbracketsExpected--;
                    this . expectCharacter(chars . $RBRACKET);
                    if (this . optionalOperator('=')) {
                        const value = this . parseConditional();
                        result = new KeyedWrite(this . span(result . span . start), result, key, value);
                    } else {
                        result = new KeyedRead(this . span(result . span . start), result, key);
                    }

                } else {
                    if (this . optionalCharacter(chars . $LPAREN)) {
                        this . rparensExpected++;
                        const args = this . parseCallArguments();
                        this . rparensExpected--;
                        this . expectCharacter(chars . $RPAREN);
                        result = new FunctionCall(this . span(result . span . start), result, args);

                    } else {
                        return result;
                    }
                }
            }
        }
    }
  }

  parsePrimary(): AST {
    const start = this . inputIndex;
    if (this . optionalCharacter(chars . $LPAREN)) {
        this . rparensExpected++;
        const result = this . parsePipe();
        this . rparensExpected--;
        this . expectCharacter(chars . $RPAREN);
        return result;

    } else {
        if (this . next . isKeywordNull()) {
            this . advance();
            return new LiteralPrimitive(this . span(start), null);

        } else {
            if (this . next . isKeywordUndefined()) {
                this . advance();
                return new LiteralPrimitive(this . span(start), void 0);

    } else {
                if (this . next . isKeywordTrue()) {
                    this . advance();
                    return new LiteralPrimitive(this . span(start), true);

                } else {
                    if (this . next . isKeywordFalse()) {
                        this . advance();
                        return new LiteralPrimitive(this . span(start), false);

                    } else {
                        if (this . next . isKeywordThis()) {
                            this . advance();
                            return new ImplicitReceiver(this . span(start));

                        } else {
                            if (this . optionalCharacter(chars . $LBRACKET)) {
                                this . rbracketsExpected++;
                                const elements = this . parseExpressionList(chars . $RBRACKET);
                                this . rbracketsExpected--;
                                this . expectCharacter(chars . $RBRACKET);
                                return new LiteralArray(this . span(start), elements);

                            } else {
                                if (this . next . isCharacter(chars . $LBRACE)) {
                                    return this . parseLiteralMap();

                                } else {
                                    if (this . next . isIdentifier()) {
                                        return this . parseAccessMemberOrMethodCall(new ImplicitReceiver(this . span(start)),
                                                                                    false);

                                    } else {
                                        if (this . next . isNumber()) {
                                            const value = this . next . toNumber();
                                            this . advance();
                                            return new LiteralPrimitive(this . span(start), value);

                                        } else {
                                            if (this . next . isString()) {
                                                const literalValue = this . next . toString();
                                                this . advance();
                                                return new LiteralPrimitive(this . span(start), literalValue);

                                            } else {
                                                if (this . index >= this . tokens . length) {
                                                    this . error(`Unexpected end of expression: ${this . input}`);
                                                    return new EmptyExpr(this . span(start));
                                                } else {
                                                    this . error(`Unexpected token ${this . next}`);
                                                    return new EmptyExpr(this . span(start));
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
}

  parseExpressionList(terminator: number): AST[] {
    const result: AST[] = [];
    if (!this . next . isCharacter(terminator)) {
        do {
            result . push(this . parsePipe());
        } while (this . optionalCharacter(chars . $COMMA));
    }
    return result;
  }

  parseLiteralMap(): LiteralMap {
    const keys: string[] = [];
    const values: AST[] = [];
    const start = this . inputIndex;
    this . expectCharacter(chars . $LBRACE);
    if (!this . optionalCharacter(chars . $RBRACE)) {
        this . rbracesExpected++;
        do {
            const key = this . expectIdentifierOrKeywordOrString();
            keys . push(key);
            this . expectCharacter(chars . $COLON);
            values . push(this . parsePipe());
        } while (this . optionalCharacter(chars . $COMMA));
        this . rbracesExpected--;
        this . expectCharacter(chars . $RBRACE);
    }
    return new LiteralMap(this . span(start), keys, values);
  }

  parseAccessMemberOrMethodCall(receiver: AST, isSafe: boolean = false): AST {
    const start = receiver . span . start;
    const id    = this . expectIdentifierOrKeyword();

    if (this . optionalCharacter(chars . $LPAREN)) {
        this . rparensExpected++;
        const args = this . parseCallArguments();
        this . expectCharacter(chars . $RPAREN);
        this . rparensExpected--;
        const span = this . span(start);
        return isSafe ? new SafeMethodCall(span, receiver, id, args) :
            new MethodCall(span, receiver, id, args);

    } else {
        if (isSafe) {
            if (this . optionalOperator('=')) {
                this . error('The \'?.\' operator cannot be used in the assignment');
                return new EmptyExpr(this . span(start));
            } else {
                return new SafePropertyRead(this . span(start), receiver, id);
            }
        } else {
            if (this . optionalOperator('=')) {
                if (!this . parseAction) {
                    this . error('Bindings cannot contain assignments');
                    return new EmptyExpr(this . span(start));
                }

                const value = this . parseConditional();
                return new PropertyWrite(this . span(start), receiver, id, value);
            } else {
                return new PropertyRead(this . span(start), receiver, id);
            }
        }
    }
}

  parseCallArguments(): BindingPipe[] {
    if (this . next . isCharacter(chars . $RPAREN)) {
        return [];
    }
    const positionals: AST[] = [];
    do {
        positionals . push(this . parsePipe());
    } while (this . optionalCharacter(chars . $COMMA));
    return positionals as BindingPipe[];
  }

  /**
   * An identifier, a keyword, a string with an optional `-` inbetween.
   */
  expectTemplateBindingKey(): string {
    let result = '';
    let operatorFound = false;
    do {
        result += this . expectIdentifierOrKeywordOrString();
        operatorFound = this . optionalOperator('-');
        if (operatorFound) {
            result += '-';
        }
    } while (operatorFound);

    return result . toString();
  }

  parseTemplateBindings(): TemplateBindingParseResult {
    const bindings: TemplateBinding[] = [];
    let prefix: string = null;
    const warnings: string[] = [];
    while (this . index < this . tokens . length) {
        const start = this . inputIndex;
        const keyIsVar: boolean = this . peekKeywordLet();
      if (keyIsVar) {
          this . advance();
      }
      let key = this . expectTemplateBindingKey();
      if (!keyIsVar) {
          if (prefix == null) {
              prefix = key;
          } else {
              key = prefix + key[0] . toUpperCase() + key . substring(1);
          }
      }
      this . optionalCharacter(chars . $COLON);
      let name: string = null;
      let expression: ASTWithSource = null;
      if (keyIsVar) {
          if (this . optionalOperator('=')) {
              name = this . expectTemplateBindingKey();
          } else {
              name = '\$implicit';
          }
      } else {
          if (this . next !== EOF && !this . peekKeywordLet()) {
              const start  = this . inputIndex;
              const ast    = this . parsePipe();
              const source = this . input . substring(start - this . offset, this . inputIndex - this . offset);
              expression = new ASTWithSource(ast, source, this . location, this . errors);
          }
      }
      bindings . push(new TemplateBinding(this . span(start), key, keyIsVar, name, expression));
      if (!this . optionalCharacter(chars . $SEMICOLON)) {
          this . optionalCharacter(chars . $COMMA);
      }
    }
    return new TemplateBindingParseResult(bindings, warnings, this . errors);
  }

  error(message: string, index: number = null) {
    this . errors . push(new ParserError(message, this . input, this . locationText(index), this . location));
    this . skip();
}

  private locationText(index: number = null) {
    if (isBlank(index)) {
        index = this . index;
    }
    return (index < this . tokens . length) ?
        `at column ${this . tokens[index] . index + 1} in` :
        `at the end of the expression`;
}

  // Error recovery should skip tokens until it encounters a recovery point. skip() treats
  // the end of input and a ';' as unconditionally a recovery point. It also treats ')',
  // '}' and ']' as conditional recovery points if one of calling productions is expecting
  // one of these symbols. This allows skip() to recover from errors such as '(a.) + 1' allowing
  // more of the AST to be retained (it doesn't skip any tokens as the ')' is retained because
  // of the '(' begins an '(' <expr> ')' production). The recovery points of grouping symbols
  // must be conditional as they must be skipped if none of the calling productions are not
  // expecting the closing token else we will never make progress in the case of an
  // extraneous group closing symbol (such as a stray ')'). This is not the case for ';' because
  // parseChain() is always the root production and it expects a ';'.

  // If a production expects one of these token it increments the corresponding nesting count,
  // and then decrements it just prior to checking if the token is in the input.
  private function skip()
{
    let n = this . next;
    while (this . index < this . tokens . length && !n . isCharacter(chars . $SEMICOLON)
           && (this . rparensExpected <= 0 || !n . isCharacter(chars . $RPAREN))
           && (this . rbracesExpected <= 0 || !n . isCharacter(chars . $RBRACE))
           && (this . rbracketsExpected <= 0 || !n . isCharacter(chars . $RBRACKET))) {
        if (this . next . isError()) {
            this . errors . push(
                new ParserError(this . next . toString(), this . input, this . locationText(), this . location));
        }
        this . advance();
        n = this . next;
    }
  }
}