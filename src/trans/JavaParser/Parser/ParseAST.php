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
use trans\JavaParser\Ast\ParseLocation;
use trans\JavaParser\Ast\ParserError;
use trans\JavaParser\Ast\ParseSourceSpan;
use trans\JavaParser\Ast\ParseSpan;
use trans\JavaParser\Ast\Type\ArrayBracketPair;
use trans\JavaParser\Ast\Type\ArrayType;
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
    use ParseVariableDeclarationExpression;

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

    public function sourceSpan($start)
    {
        return new ParseSourceSpan($start, $this->getInputIndex());
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

    public function wrapInArrayTypes($type, $arrayBracketPairLists)
    {
        foreach ($arrayBracketPairLists as $arrayBracketPairList) {
            if ($arrayBracketPairList) {
                foreach ($arrayBracketPairList as $pair) {
                    /** @var ArrayBracketPair $pair */
                    $type = new ArrayType($type, $pair->annotations);
                }
            }
        }
        return $type;
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