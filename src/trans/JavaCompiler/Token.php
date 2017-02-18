<?php
/**
 * Created by IntelliJ IDEA.
 * User: hugo
 * Date: 2017/2/18
 * Time: 21:59
 */

namespace src\trans\JavaCompiler;


class Token
{

constructor(
public index: number, public type: TokenType, public numValue: number,
public strValue: string) {}

isCharacter(code: number): boolean {
    return this.type == TokenType.Character && this.numValue == code;
}

  isNumber(): boolean { return this.type == TokenType.Number; }

  isString(): boolean { return this.type == TokenType.String; }

  isOperator(operater: string): boolean {
    return this.type == TokenType.Operator && this.strValue == operater;
}

  isIdentifier(): boolean { return this.type == TokenType.Identifier; }

  isKeyword(): boolean { return this.type == TokenType.Keyword; }

  isKeywordLet(): boolean { return this.type == TokenType.Keyword && this.strValue == 'let'; }

  isKeywordNull(): boolean { return this.type == TokenType.Keyword && this.strValue == 'null'; }

  isKeywordUndefined(): boolean {
    return this.type == TokenType.Keyword && this.strValue == 'undefined';
}

  isKeywordTrue(): boolean { return this.type == TokenType.Keyword && this.strValue == 'true'; }

  isKeywordFalse(): boolean { return this.type == TokenType.Keyword && this.strValue == 'false'; }

  isKeywordThis(): boolean { return this.type == TokenType.Keyword && this.strValue == 'this'; }

  isError(): boolean { return this.type == TokenType.Error; }

  toNumber(): number { return this.type == TokenType.Number ? this.numValue : -1; }

  toString(): string {
    switch (this.type) {
        case TokenType.Character:
        case TokenType.Identifier:
        case TokenType.Keyword:
        case TokenType.Operator:
        case TokenType.String:
        case TokenType.Error:
            return this.strValue;
        case TokenType.Number:
            return this.numValue.toString();
        default:
            return null;
    }
}
}