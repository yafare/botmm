<?php


namespace trans\JavaParser\Parser;

use trans\JavaParser\Ast\Expr\UnaryExpr;
use trans\JavaParser\Ast\Statement\AssertStmt;
use trans\JavaParser\Ast\Statement\EmptyStmt;
use trans\JavaParser\Ast\Statement\ExpressionStmt;
use trans\JavaParser\Ast\Statement\LabeledStmt;
use trans\JavaParser\Ast\Statement\LocalClassDeclarationStmt;
use trans\JavaParser\Chars;
use trans\JavaParser\Keywords;


/**
 * Class ParseStatements
 *
 * @mixin ParseAST
 * @package trans\JavaParser\Parser
 */
trait ParseStatements
{

    public function parseStatements()
    {
        $stmt  = $this->parseBlockStatement();
        $ret[] = $stmt;

        return $ret;
    }

    public function parseStatement()
    {
        $n = $this->getNext();
        if ($n->isIdentifier() && $this->peek(1)->isCharacter(Chars::COLON)) {
            return $this->parseLabeledStatement();
        } elseif ($n->isKeywordAssert()) {
            return $this->parseAssertStatement();
        } elseif ($n->isCharacter(Chars::LBRACE)) {
            return $this->parseBlock();
        } elseif ($n->isCharacter(Chars::SEMICOLON)) {
            return $this->parseEmptyStatement();
        } elseif ($n->()) {
            return $this->parseStatementExpression();
        } elseif ($n->isKeywordSwitch()) {
            return $this->parseSwitchStatement();
        } elseif ($n->isKeywordIf()) {
            return $this->parseIfStatement();
        } elseif ($n->isKeywordWhile()) {
            return $this->parseWhileStatement();
        } elseif ($n->isKeywordDo()) {
            return $this->parseDoStatement();
        } elseif ($n->isKeywordFor()) {
            return $this->parseForStatement();
        } elseif ($n->isKeywordBreak()) {
            return $this->parseBreakStatement();
        } elseif ($n->isKeywordContinue()) {
            return $this->parseContinueStatement();
        } elseif ($n->isKeywordReturn()) {
            return $this->parseReturnStatement();
        } elseif ($n->isKeywordThrow()) {
            return $this->parseThrowStatement();
        } elseif ($n->isKeywordSynchronized()) {
            return $this->parseSynchronizedStatement();
        } elseif ($n->isKeywordTry()) {
            return $this->parseTryStatement();
        }
    }

    public function parseBlockStatement()
    {
        $start    = $this->getInputIndex();
        $modifier = $this->getModifier();

        if ($this->getNext()->isKeywordClass()
            || $this->getNext()->isKeywordInterface()
        ) {
            $typeDeclaration = $this->parseClassOrInterfaceDeclaration($modifier);
            return new LocalClassDeclarationStmt($this->span($start), $typeDeclaration);
        } elseif (xxx) {
            $expr = $this->parseVariableDeclarationExpression();
            $this->expectCharacter(Chars::SEMICOLON);
            return new ExpressionStmt($expr, $this->span($start));
        } else {
            return $this->parseStatement();
        }


    }


    //region statements
    public function parseLabeledStatement()
    {
        $label = $this->parseSimpleName();
        $start = $this->getInputIndex();
        $this->expectCharacter(Chars::COLON);
        $stmt = $this->parseStatement();
        return new LabeledStmt($this->span($start), $label, $stmt);
    }

    public function parseAssertStatement()
    {
        $this->expectKeyword(Keywords::_ASSERT_);
        $start = $this->getInputIndex();
        $check = $this->parseExpression();
        $msg   = null;
        if ($this->optionalCharacter(Chars::COLON)) {
            $msg = $this->parseExpression();
        }
        $this->expectCharacter(Chars::SEMICOLON);
        return new AssertStmt($this->span($start), $check, $msg);
    }

    public function parseEmptyStatement()
    {
        $start = $this->getInputIndex();
        $this->expectCharacter(Chars::SEMICOLON);
        return new EmptyStmt($this->span($start));
    }

    public function parseStatementExpression()
    {
        $start = $this->getInputIndex();
        $n     = $this->getNext();
        if (
            $n->isCharacter(Chars::PLUS)
            && $this->peek(1)->isCharacter(Chars::PLUS)
        ) {
            $ret = $this->parseUnaryExpression();
            return new UnaryExpr($this->span($start), $ret, UnaryExpr::$INCREMENT);
        } elseif (
            $n->isCharacter(Chars::MINUS)
            && $this->peek(1)->isCharacter(Chars::MINUS)
        ) {
            $ret = $this->parseUnaryExpression();
            return new UnaryExpr($this->span($start), $ret, UnaryExpr::$DECREMENT);
        }
    }


    //endregion
}