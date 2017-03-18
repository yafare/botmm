<?php


namespace trans\JavaParser\Parser;

use trans\JavaParser\Ast\Statement\LocalClassDeclarationStmt;


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

    }

    public function parseBlockStatement()
    {
        $start = $this->getInputIndex();
        $modifier = $this->getModifier();

        if ($this->getNext()->isKeywordClass()
            || $this->getNext()->isKeywordInterface()
        ) {
            $typeDeclaration = $this->parseClassOrInterfaceDeclaration($modifier);
            return new LocalClassDeclarationStmt($this->span($start), $typeDeclaration);
        }elseif(){
            $this->parseVariableDeclarationExpression();
        }


    }
}