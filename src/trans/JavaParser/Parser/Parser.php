<?php


namespace trans\JavaParser\Parser;


use trans\JavaParser\Ast\ASTWithSource;
use trans\JavaParser\Ast\Expr\LiteralPrimitive;
use trans\JavaParser\Ast\ParserError;
use trans\JavaParser\Ast\ParseSpan;
use trans\JavaParser\Chars;
use trans\JavaParser\Lexer\Lexer;
use trans\JavaParser\Lexer\Util;
use trans\JavaParser\Wrapper\StringWrapper;

class Parser
{
    private $errors/*: ParserError[]*/ = [];
    /**
     * @var Lexer
     */
    private $_lexer;


    public function __construct($lexer)
    {
        $this->_lexer = $lexer;
    }

    public function parse($input, $location)
    {
        $tokens   = $this->_lexer->tokenize($input);
        $parseAst = new ParseAST($input, $location, $tokens, strlen($input), true, 0);
        $ast      = $parseAst->parse();
        $errors   = $parseAst->getErrors();
        return new ASTWithSource($ast, $input, $location, $errors);
    }

    public function parseClass($input, $location)
    {
        $tokens   = $this->_lexer->tokenize($input);
        $parseAst = new ParseAST($input, $location, $tokens, strlen($input), true, 0);
        $ast      = $parseAst->parseChain();
        return new ASTWithSource($ast, $input, $location, $this->errors);
    }

    /**
     * @param string              $input
     * @param mixed               $location
     * @param InterpolationConfig $interpolationConfig
     * @return ASTWithSource
     */
    public function parseAction(
        $input,
        $location
        /*$interpolationConfig: InterpolationConfig = DEFAULT_INTERPOLATION_CONFIG*/
    )/*: ASTWithSource*/
    {
        $tokens   = $this->_lexer->tokenize($input);
        $parseAst = new ParseAST($input, $location, $tokens, strlen($input), true, 0);
        $ast      = $parseAst->parseChain();
        return new ASTWithSource($ast, $input, $location, $this->errors);
    }

    ///**
    // * @param string $input
    // * @param mixed  $location
    // * @return ASTWithSource
    // */
    //public function parseBinding(
    //    $input,
    //    $location
    //    /*, $interpolationConfig: InterpolationConfig = DEFAULT_INTERPOLATION_CONFIG*/
    //)/*: ASTWithSource*/
    //{
    //    $ast = $this->_parseBindingAst($input, $location, $interpolationConfig);
    //    return new ASTWithSource(ast, input, location, this . errors);
    //}

//    public function parseSimpleBinding(
//        $input, $location,
//      $interpolationConfig = DEFAULT_INTERPOLATION_CONFIG)/*: ASTWithSource*/ {
//    $ast        = $this->_parseBindingAst($input, $location, $interpolationConfig);
//        $errors = SimpleExpressionChecker:: check($ast);
//        if ($errors . length > 0) {
//            $this->_reportError(
//                `Host binding expression cannot contain ${errors . join(' ')}
//
//`, $input, $location);
//        }
//        return new ASTWithSource(ast, input, location, this . errors);
//    }

    private function _reportError($message, $input, $errLocation, $ctxLocation)
    {
        $this->errors[] = new ParserError($message, $input, $errLocation, $ctxLocation);
    }

    //private function _parseBindingAst(
    //    input: string, location: string, interpolationConfig: InterpolationConfig): AST {
    //    // Quotes expressions use 3rd-party expression language. We don't want to use
    //    // our lexer or parser for that, so we check for that ahead of time.
    //    const quote = this . _parseQuote(input, location);
    //
    //    if (isPresent(quote)) {
    //        return quote;
    //    }
    //
    //    this . _checkNoInterpolation(input, location, interpolationConfig);
    //    const sourceToLex = this . _stripComments(input);
    //    const tokens      = this . _lexer . tokenize(sourceToLex);
    //    return new _ParseAST(
    //               input, location, tokens, sourceToLex . length, false, this . errors,
    //               input . length - sourceToLex . length)
    //           . parseChain();
    //}

    //private function _parseQuote(input: string, location: any): AST {
    //    if (isBlank(input)) {
    //        return null;
    //    }
    //    const prefixSeparatorIndex = input . indexOf(':');
    //    if (prefixSeparatorIndex == -1) {
    //        return null;
    //    }
    //    const prefix = input . substring(0, prefixSeparatorIndex) . trim();
    //    if (!isIdentifier(prefix)) {
    //        return null;
    //    }
    //    const uninterpretedExpression = input . substring(prefixSeparatorIndex + 1);
    //    return new Quote(new ParseSpan(0, input . length), prefix, uninterpretedExpression, location);
    //}

//  public function parseTemplateBindings(prefixToken: string, input: string, location: any):
//      TemplateBindingParseResult {
//    const tokens = this . _lexer . tokenize(input);
//    if (prefixToken) {
//        // Prefix the tokens with the tokens from prefixToken but have them take no space (0 index).
//        const prefixTokens = this . _lexer . tokenize(prefixToken) . map(t => {
//            t . index = 0;
//            return t;
//        });
//      tokens . unshift(...prefixTokens);
//    }
//    return new _ParseAST(input, location, tokens, input . length, false, this . errors, 0)
//           . parseTemplateBindings();
//}

    //public function parseInterpolation(
    //  input: string, location: any,
    //    interpolationConfig: InterpolationConfig = DEFAULT_INTERPOLATION_CONFIG): ASTWithSource {
    //  const split = this . splitInterpolation(input, location, interpolationConfig);
    //  if (split == null) {
    //      return null;
    //  }
    //
    //  const expressions: AST[] = [];
    //
    //  for (let i = 0; i < split . expressions . length {
    //      ;
    //  } ++i) {
    //      const expressionText = split . expressions[i];
    //      const sourceToLex    = this . _stripComments(expressionText);
    //      const tokens         = this . _lexer . tokenize(this . _stripComments(split . expressions[i]));
    //      const ast            = new _ParseAST(
    //                                 input, location, tokens, sourceToLex . length, false, this . errors,
    //                                 split . offsets[i] + (expressionText . length - sourceToLex . length))
    //                             . parseChain();
    //      expressions . push(ast);
    //  }
    //
    //  return new ASTWithSource(
    //      new Interpolation(
    //          new ParseSpan(0, isBlank(input) ? 0 : input . length), split . strings, expressions),
    //      input, location, this . errors);
    //}
    //
    //public function splitInterpolation(
    //  input: string, location: string,
    //    interpolationConfig: InterpolationConfig = DEFAULT_INTERPOLATION_CONFIG): SplitInterpolation {
    //  const regexp = _createInterpolateRegExp(interpolationConfig);
    //  const parts  = input . split(regexp);
    //  if (parts . length <= 1) {
    //      return null;
    //  }
    //  const strings: string[] = [];
    //  const expressions: string[] = [];
    //  const offsets: number[] = [];
    //  let offset = 0;
    //  for (let i = 0; i < parts . length {
    //      ;
    //  } i++) {
    //      const part: string = parts[i];
    //    if (i % 2 === 0) {
    //        // fixed string
    //        strings . push(part);
    //        offset += part . length;
    //    } else {
    //        if (part . trim() . length > 0) {
    //            offset += interpolationConfig . start . length;
    //            expressions . push(part);
    //            offsets . push(offset);
    //            offset += part . length + interpolationConfig . end . length;
    //        } else {
    //            this . _reportError(
    //                'Blank expressions are not allowed in interpolated strings', input,
    //                `at column ${this . _findInterpolationErrorColumn(parts, i, interpolationConfig)} in`,
    //                location);
    //            expressions . push('$implict');
    //            offsets . push(offset);
    //        }
    //    }
    //  }
    //  return new SplitInterpolation(strings, expressions, offsets);
    //}

    public function wrapLiteralPrimitive($input, $location)/*: ASTWithSource*/
    {
        return new ASTWithSource(
            new LiteralPrimitive(new ParseSpan(0, $input != null ? 0 : strlen($input)), $input), $input,
            $location, $this->errors);
    }

    //private function _stripComments($input): string
    //{
    //    $i = $this->_commentStart($input);
    //    return $i != null ? StringWrapper::subString($input, 0, $i) : $input;
    //}
    //
    //private function _commentStart($input): number
    //{
    //    $outerQuote = null;
    //    for ($i = 0; $i < strlen($input) - 1; $i++) {
    //        $char     = StringWrapper::charCodeAt($input, $i);
    //        $nextChar = StringWrapper::charCodeAt($input, $i + 1);
    //
    //        if ($char === Chars::SLASH && $nextChar == Chars::SLASH && $outerQuote == null) {
    //            return $i;
    //        }
    //
    //        if ($outerQuote === $char) {
    //            $outerQuote = null;
    //        } elseif ($outerQuote == null && Util::isQuote($char)) {
    //            $outerQuote = $char;
    //        }
    //    }
    //    return null;
    //}

//  private function _checkNoInterpolation(
//    input: string, location: any, interpolationConfig: InterpolationConfig): void {
//    const regexp = _createInterpolateRegExp(interpolationConfig);
//    const parts  = input . split(regexp);
//    if (parts . length > 1) {
//        this . _reportError(
//            `Got interpolation (${interpolationConfig . start}${interpolationConfig . end}) where expression was expected`,
//            input,
//            `at column ${this . _findInterpolationErrorColumn(parts, 1, interpolationConfig)} in`,
//            location);
//    }
//}
//
//  private function _findInterpolationErrorColumn(
//    parts: string[], partInErrIdx: number, interpolationConfig: InterpolationConfig): number {
//    let errLocation = '';
//    for (let j = 0; j < partInErrIdx {
//        ;
//    } j++) {
//        errLocation += j % 2 === 0 ?
//            parts[j] :
//            `${interpolationConfig . start}${parts[j]}${interpolationConfig . end}`;
//    }
//
//    return errLocation . length;
//  }
}