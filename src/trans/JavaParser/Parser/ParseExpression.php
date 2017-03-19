<?php


namespace trans\JavaParser\Parser;


use trans\JavaParser\Ast\AST;
use trans\JavaParser\Ast\Expr\Binary;
use trans\JavaParser\Ast\Expr\Conditional;
use trans\JavaParser\Ast\Expr\EmptyExpr;
use trans\JavaParser\Ast\Expr\UnaryExpr;
use trans\JavaParser\Chars;
use trans\JavaParser\Wrapper\StringWrapper;

/**
 * Class ParseExpression
 *
 * @mixin ParseAST
 * @package trans\JavaParser\Parser
 */
trait ParseExpression
{

    /**
     * 双元运算
     *
     * @return AST
     */
    public function parseUnaryExpression(): AST
    {
        $n = $this->getNext();
        if ($n->isCharacter(Chars::PLUS)
            && $this->peek(1)->isCharacter(Chars::PLUS)
        ) {
            return $this->parsePreIncrementExpression();
        } elseif ($n->isCharacter(Chars::MINUS)
                  && $this->peek(1)->isCharacter(Chars::MINUS)
        ) {
            return $this->parsePreDecrementExpression();
        } elseif ($n->isCharacter(Chars::PLUS)) {
            $this->advance();
            $ret = $this->parseUnaryExpression();
            return new UnaryExpr($this->span($this->getInputIndex()), $ret, UnaryExpr::$PLUS);
        } elseif ($n->isCharacter(Chars::MINUS)) {
            $this->advance();
            $ret = $this->parseUnaryExpression();
            return new UnaryExpr($this->span($this->getInputIndex()), $ret, UnaryExpr::$MINUS);
        } else {
            return $this->parseUnaryExpressionNotPlusMinus();
        }
    }

    public function parseUnaryExpressionNotPlusMinus()
    {
        $start = $this->getInputIndex();
        $n     = $this->getNext();
        if ($n->isCharacter(Chars::TILDA)) {
            $this->advance();
            $ret = $this->parseUnaryExpression();
            return new UnaryExpr($this->span($start), $ret, UnaryExpr::$BITWISE_COMPLEMENT);
        } elseif ($n->isCharacter(Chars::BANG)) {
            $this->advance();
            $ret = $this->parseUnaryExpression();
            return new UnaryExpr($this->span($start), $ret, UnaryExpr::$LOGICAL_COMPLEMENT);
        } elseif ($n->isCharacter(Chars::LPAREN)) { //cast

        } else {
            return $this->parsePostfixExpression();
        }
    }

    public function parsePostfixExpression()
    {
        $ret   = $this->parsePrimaryExpression();
        $start = $this->getInputIndex();
        if (
            $this->getNext()->isCharacter(Chars::PLUS)
            || $this->peek(1)->isCharacter(Chars::PLUS)
        ) {
            $this->advance();
            $this->advance();
            return new UnaryExpr($this->span($start), $ret, UnaryExpr::$POSTFIX_INCREMENT);
        } elseif (
            $this->getNext()->isCharacter(Chars::MINUS)
            || $this->peek(1)->isCharacter(Chars::MINUS)
        ) {
            $this->advance();
            $this->advance();
            return new UnaryExpr($this->span($start), $ret, UnaryExpr::$POSTFIX_DECREMENT);
        }

    }

    public function parsePrimaryExpression()
    {
       $ret = $this->parsePrimaryPrefix();
       while (true) {
           switch ()
       }

    }

    public function parsePreIncrementExpression()
    {
        $this->expectCharacter(Chars::PLUS);
        $this->expectCharacter(Chars::PLUS);
        $start = $this->getInputIndex();
        $ret   = $this->parseUnaryExpression();
        return new UnaryExpr($this->span($start), $ret, UnaryExpr::$PREFIX_INCREMENT);
    }

    public function parsePreDecrementExpression()
    {
        $this->expectCharacter(Chars::MINUS);
        $this->expectCharacter(Chars::MINUS);
        $start = $this->getInputIndex();
        $ret   = $this->parseUnaryExpression();
        return new UnaryExpr($this->span($start), $ret, UnaryExpr::$PREFIX_DECREMENT);
    }

    public function parsePrimaryExpression()
    {

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
            if (!$this->optionalCharacter(Chars::COLON)) {
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

    public function parseAdditive(): AST
    {
        // '+', '-'
        $result = $this->parseMultiplicative();
        while ($this->getNext()->type == TokenType :: Operator) {
            $operator = $this->getNext()->strValue;
            switch ($operator) {
                case '+':
                case '-':
                    $this->advance();
                    $right  = $this->parseMultiplicative();
                    $result = new Binary($this->span($result->span->start), $operator, $result, $right);
                    continue;
            }

            break;
        }
        return $result;
    }

    public function parseMultiplicative(): AST
    {
        // '*', '%', '/'
        $result = $this->parsePrefix();
        while ($this->getNext()->type == TokenType::Operator) {
            $operator = $this->getNext()->strValue;
            switch ($operator) {
                case '*':
                case '%':
                case '/':
                    $this->advance();
                    $right  = $this->parsePrefix();
                    $result = new Binary($this->span($result->span->start), $operator, $result, $right);
                    continue;
            }

            break;
        }
        return $result;
    }

    public function parsePrefix(): AST
    {
        if ($this->getNext()->type == TokenType :: Operator) {
            $start    = $this->getInputIndex();
            $operator = $this->getNext()->strValue;
            $result   = null;
            switch ($operator) {
                case '+':
                    $this->advance();
                    return $this->parsePrefix();
                case '-':
                    $this->advance();
                    $result = $this->parsePrefix();
                    return new Binary(
                        $this->span($start), $operator, new LiteralPrimitive(new ParseSpan($start, $start), 0),
                        $result);
                case '!':
                    $this->advance();
                    $result = $this->parsePrefix();
                    return new PrefixNot($this->span($start), $result);
            }
        }
        return $this->parseCallChain();
    }

    public function parseCallChain(): AST
    {
        $result = $this->parsePrimary();
        while (true) {
            if ($this->optionalCharacter(chars ::PERIOD)) {
                $result = $this->parseAccessMemberOrMethodCall($result, false);

            } elseif ($this->optionalOperator('?.')) {
                $result = $this->parseAccessMemberOrMethodCall($result, true);

            } elseif ($this->optionalCharacter(Chars::LBRACKET)) {
                $this->rbracketsExpected++;
                $key = $this->parsePipe();
                $this->rbracketsExpected--;
                $this->expectCharacter(Chars::RBRACKET);
                if ($this->optionalOperator('=')) {
                    $value  = $this->parseConditional();
                    $result = new KeyedWrite($this->span($result->span->start), $result, $key, $value);
                } else {
                    $result = new KeyedRead($this->span($result->span->start), $result, $key);
                }

            } elseif ($this->optionalCharacter(Chars::LPAREN)) {
                $this->rparensExpected++;
                $args = $this->parseCallArguments();
                $this->rparensExpected--;
                $this->expectCharacter(Chars::RPAREN);
                $result = new FunctionCall($this->span($result->span->start), $result, $args);

            } else {
                return $result;
            }
        }
    }

    public function parsePrimary(): AST
    {
        $start = $this->getInputIndex();
        if ($this->optionalCharacter(Chars::LPAREN)) {
            $this->rparensExpected++;
            $result = $this->parsePipe();
            $this->rparensExpected--;
            $this->expectCharacter(Chars::RPAREN);
            return $result;

        } elseif ($this->getNext()->isKeywordNull()) {
            $this->advance();
            return new LiteralPrimitive($this->span($start), null);

        } elseif ($this->getNext()->isKeywordUndefined()) {
            $this->advance();
            return new LiteralPrimitive($this->span($start), 'undefined');

        } elseif ($this->getNext()->isKeywordTrue()) {
            $this->advance();
            return new LiteralPrimitive($this->span($start), true);

        } elseif ($this->getNext()->isKeywordFalse()) {
            $this->advance();
            return new LiteralPrimitive($this->span($start), false);

        } elseif ($this->getNext()->isKeywordThis()) {
            $this->advance();
            return new ImplicitReceiver($this->span($start));

        } elseif ($this->optionalCharacter(Chars::LBRACKET)) {
            $this->rbracketsExpected++;
            $elements = $this->parseExpressionList(Chars::RBRACKET);
            $this->rbracketsExpected--;
            $this->expectCharacter(Chars::RBRACKET);
            return new LiteralArray($this->span($start), $elements);

        } elseif ($this->getNext()->isCharacter(Chars::LBRACE)) {
            return $this->parseLiteralMap();

        } elseif ($this->getNext()->isIdentifier()) {
            return $this->parseAccessMemberOrMethodCall(new ImplicitReceiver($this->span($start)),
                                                        false);

        } elseif ($this->getNext()->isNumber()) {
            $value = $this->getNext()->toNumber();
            $this->advance();
            return new LiteralPrimitive($this->span($start), $value);

        } elseif ($this->getNext()->isString()) {
            $literalValue = $this->getNext()->toString();
            $this->advance();
            return new LiteralPrimitive($this->span($start), $literalValue);

        } elseif ($this->index >= count($this->tokens)) {
            $this->error("Unexpected end of expression: {$this->input}");
            return new EmptyExpr($this->span($start));
        } else {
            $this->error("Unexpected token {$this->getNext()}");
            return new EmptyExpr($this->span($start));
        }

    }

    public function parseExpressionList($terminator)
    {
        $result = [];
        if (!$this->getNext()->isCharacter($terminator)) {
            do {
                $result[] = $this->parsePipe();
            } while ($this->optionalCharacter(Chars::COMMA));
        }
        return $result;
    }

    public function parseLiteralMap(): LiteralMap
    {
        $keys   = [];
        $values = [];
        $start  = $this->getInputIndex();
        $this->expectCharacter(Chars::LBRACE);
        if (!$this->optionalCharacter(Chars::RBRACE)) {
            $this->rbracesExpected++;
            do {
                $key    = $this->expectIdentifierOrKeywordOrString();
                $keys[] = $key;
                $this->expectCharacter(Chars::COLON);
                $values[] = $this->parsePipe();
            } while ($this->optionalCharacter(Chars::COMMA));
            $this->rbracesExpected--;
            $this->expectCharacter(Chars::RBRACE);
        }
        return new LiteralMap($this->span($start), $keys, $values);
    }

    public function parseAccessMemberOrMethodCall(AST $receiver, $isSafe = false): AST
    {
        $start = $receiver->span->start;
        $id    = $this->expectIdentifierOrKeyword();

        if ($this->optionalCharacter(Chars::LPAREN)) {
            $this->rparensExpected++;
            $args = $this->parseCallArguments();
            $this->expectCharacter(Chars::RPAREN);
            $this->rparensExpected--;
            $span = $this->span($start);
            return $isSafe ? new SafeMethodCall($span, $receiver, $id, $args) :
                new MethodCall($span, $receiver, $id, $args);

        } else {
            if ($isSafe) {
                if ($this->optionalOperator('=')) {
                    $this->error('The \'?.\' operator cannot be used in the assignment');
                    return new EmptyExpr($this->span($start));
                } else {
                    return new SafePropertyRead($this->span($start), $receiver, $id);
                }
            } else {
                if ($this->optionalOperator('=')) {
                    if (!$this->parseAction) {
                        $this->error('Bindings cannot contain assignments');
                        return new EmptyExpr($this->span($start));
                    }

                    $value = $this->parseConditional();
                    return new PropertyWrite($this->span($start), $receiver, $id, $value);
                } else {
                    return new PropertyRead($this->span($start), $receiver, $id);
                }
            }
        }
    }

    /**
     * @return BindingPipe[]
     */
    public function parseCallArguments()
    {
        if ($this->getNext()->isCharacter(Chars::RPAREN)) {
            return [];
        }
        $positionals = [];
        do {
            $positionals[] = $this->parsePipe();
        } while ($this->optionalCharacter(Chars::COMMA));
        return $positionals;
    }
}