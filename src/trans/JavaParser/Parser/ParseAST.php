<?php


namespace trans\JavaParser\Parser;


use trans\JavaParser\Ast\AST;
use trans\JavaParser\Ast\Expr\Binary;
use trans\JavaParser\Ast\Expr\BindingPipe;
use trans\JavaParser\Ast\Expr\Chain;
use trans\JavaParser\Ast\Expr\Conditional;
use trans\JavaParser\Ast\Expr\EmptyExpr;
use trans\JavaParser\Ast\Expr\FunctionCall;
use trans\JavaParser\Ast\Expr\ImplicitReceiver;
use trans\JavaParser\Ast\Expr\KeyedRead;
use trans\JavaParser\Ast\Expr\KeyedWrite;
use trans\JavaParser\Ast\Expr\LiteralArray;
use trans\JavaParser\Ast\Expr\LiteralMap;
use trans\JavaParser\Ast\Expr\LiteralPrimitive;
use trans\JavaParser\Ast\Expr\MethodCall;
use trans\JavaParser\Ast\Expr\PrefixNot;
use trans\JavaParser\Ast\Expr\PropertyRead;
use trans\JavaParser\Ast\Expr\PropertyWrite;
use trans\JavaParser\Ast\Expr\SafeMethodCall;
use trans\JavaParser\Ast\Expr\SafePropertyRead;
use trans\JavaParser\Ast\ParserError;
use trans\JavaParser\Ast\ParseSpan;
use trans\JavaParser\Chars;
use trans\JavaParser\Ast\ClassPart\CompilationUnit;
use trans\JavaParser\Lexer\Lexer;
use trans\JavaParser\Lexer\Token;
use trans\JavaParser\Lexer\TokenType;
use trans\JavaParser\Wrapper\StringWrapper;


/**
 * Class ParseAST
 *
 * @mixin ParseAnnotationTypeDeclaration
 * @mixin ParseClassOrInterfaceDeclaration
 * @mixin ParseFieldDeclaration
 * @mixin ParseImportDeclaration
 * @mixin ParseName
 * @mixin ParsePackageDeclaration
 * @mixin ParseType
 * @mixin ParseTypeDeclaration
 * @package trans\JavaParser\Parser
 */
class ParseAST
{
    use ParseAnnotationTypeDeclaration;
    use ParseClassOrInterfaceDeclaration;
    use ParseFieldDeclaration;
    use ParseImportDeclaration;
    use ParseName;
    use ParsePackageDeclaration;
    use ParseType;
    use ParseTypeDeclaration;

    private $rparensExpected   = 0;
    private $rbracketsExpected = 0;
    private $rbracesExpected   = 0;

    public $index = 0;

    /**
     * @var string
     */
    public $input;
    /**
     * @var mixed
     */
    public $location;
    /**
     * @var Token[]
     */
    public $tokens;
    /**
     * @var number
     */
    public $inputLength;
    /**
     * @var bool
     */
    public $parseAction;
    /**
     * @var ParserError[]
     */
    private $errors;
    /**
     * @var number
     */
    private $offset;

    public function __construct($input, $location, $tokens, $inputLength, $parseAction, $offset)
    {
        /** @var string */
        $this->input = $input;
        /**@var mixed */
        $this->location = $location;
        /**@var Token[] */
        $this->tokens = $tokens;
        /**@var number */
        $this->inputLength = $inputLength;
        /**@var boolean */
        $this->parseAction = $parseAction;
        /**@var ParserError[] */
        $this->errors = [];
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

    public function getInputIndex(): int
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

    public function expectIdentifier(): string
    {
        $n = $this->getNext();
        if (!$n->isIdentifier()) {
            $this->error("Unexpected token {$n}, expected identifier");
            return '';
        }
        $this->advance();
        return $n->toString();
    }

    public function expectKeyword($keyword): string
    {
        $n = $this->getNext();
        if (!$n->isKeyword()) {
            $this->error("Unexpected token {$n}, expected keyword");
            return '';
        } elseif ($n->strValue != $keyword) {
            $this->error("Unexpected token {$n}, expected keyword {$keyword}");
            return '';
        }
        $this->advance();
        return $n->toString();
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

    public function parse(): AST
    {
        $start = $this->getInputIndex();
        if ($this->optionalCharacter(Chars::SEMICOLON)) {
            while ($this->optionalCharacter(Chars::SEMICOLON)) {
            }
        }
        $package = $this->parsePackageDeclaration();
        $imports = [];
        $types   = [];
        while (true) {
            if ($this->getNext()->isKeywordImport()) {
                $imports[] = $this->parseImportDeclaration();
            } elseif (!$this->optionalCharacter(Chars::SEMICOLON)) {
                break;
            }
        }
        while (true) {
            $n = $this->getNext();
            if ($n->isKeywordAbstract()
                || $n->isKeywordClass()
                || $n->isKeywordEnum()
                || $n->isKeywordFinal()
                || $n->isKeywordInterface()
                || $n->isKeywordNative()
                || $n->isKeywordPrivate()
                || $n->isKeywordProtected()
                || $n->isKeywordPublic()
                || $n->isKeywordStatic()
                || $n->isKeywordStrictfp()
                || $n->isKeywordSynchronized()
                || $n->isKeywordTransient()
                || $n->isKeywordVolatile()
                || $n->isCharacter(Chars::AT)
            ) {
                $types[] = $this->parseTypeDeclaration();
            } elseif (!$this->optionalCharacter(Chars::SEMICOLON)) {
                break;
            }

        }
        //$this->expectCharacter(Chars::EOF);
        return new CompilationUnit($this->span($start), $package, $imports, $types);


    }

    //public function parseClass(): AST
    //{
    //    $next          = $this->getNext();
    //    $classModifier = null;
    //
    //    $modifier  = null;
    //    $clazzName = null;
    //    while (true) {
    //        if ($next->isKeywordPublic()) {
    //            $modifier = Modifier::PUBLIC;
    //        } elseif ($next->isKeywordFinal()) {
    //            $modifier = Modifier::FINAL;
    //        } elseif ($next->isKeywordPrivate()) {
    //            $modifier = Modifier::PRIVATE;
    //        } elseif ($next->isKeywordClass()) {
    //            $this->advance();
    //            if ($this->getNext()->isIdentifier()) {
    //                $clazzName = $this->getNext()->strValue;
    //                $this->advance();
    //            } else {
    //                $this->error("class name is not defined", $this->index);
    //            }
    //        } elseif ($next->isKeywordExtends()) {
    //            $this->advance();
    //            if ($this->getNext()->isIdentifier()) {
    //                $clazzParent = $this->getNext()->strValue;
    //            } else {
    //                $this->error("extends parent class is not defined", $this->index);
    //            }
    //        } elseif ($next->isKeywordImplements()) {
    //            $this->advance();
    //            if ($this->getNext()->isIdentifier()) {
    //                $clazzInterface = $this->getNext()->strValue;
    //            } else {
    //                $this->error("class implement name is not defined", $this->index);
    //            }
    //        }
    //    }
    //
    //    //begin to parse class body
    //    if ($modifier != null && $clazzName == null) {
    //        $this->error("have not define class, but class modifiers found");
    //    } else {
    //        $this->expectCharacter(Chars::LBRACE);
    //        while ($this->index < count($this->tokens)) {
    //
    //        }
    //    }
    //
    //}


    public function optionalGeneric(): AST
    {

    }

    public function parseChain(): AST
    {
        $exprs = [];
        $start = $this->getInputIndex();
        while ($this->index < count($this->tokens)) {
            $expr    = $this->parsePipe();
            $exprs[] = $expr;

            if ($this->optionalCharacter(Chars::SEMICOLON)) {
                if (!$this->parseAction) {
                    $this->error('Binding expression cannot contain chained expression');
                }
                while ($this->optionalCharacter(Chars::SEMICOLON)) {
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
                while ($this->optionalCharacter(Chars::COLON)) {
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

    /**
     * An identifier, a keyword, a string with an optional `-` inbetween.
     */
    public function expectTemplateBindingKey(): string
    {
        $result        = '';
        $operatorFound = false;
        do {
            $result .= $this->expectIdentifierOrKeywordOrString();
            $operatorFound = $this->optionalOperator('-');
            if ($operatorFound) {
                $result .= '-';
            }
        } while ($operatorFound);

        return $result;
    }

    public function error($message, $index = null)
    {
        $this->errors[] = new ParserError($message, $this->input, $this->locationText($index), $this->location);
        $this->skip();
    }

    private function locationText($index = null)
    {
        if ($index == null) {
            $index = $this->index;
        }
        return ($index < count($this->tokens)) ?
            "at column " . ($this->tokens[$index]->index + 1) . " in" :
            "at the end of the expression";
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
        $n = $this->getNext();
        while ($this->index < count($this->tokens) && !$n->isCharacter(Chars::SEMICOLON)
               && ($this->rparensExpected <= 0 || !$n->isCharacter(Chars::RPAREN))
               && ($this->rbracesExpected <= 0 || !$n->isCharacter(Chars::RBRACE))
               && ($this->rbracketsExpected <= 0 || !$n->isCharacter(Chars::RBRACKET))) {
            if ($this->getNext()->isError()) {
                $this->errors[] =
                    new ParserError($this->getNext()->toString(), $this->input, $this->locationText(),
                                    $this->location);
            }
            $this->advance();
            $n = $this->getNext();
        }
    }

    public function getErrors()
    {
        return $this->errors;
    }
}