<?php


namespace src\trans\JavaCompiler;


class Lexer
{

}

const KEYWORDS = ['var', 'let', 'null', 'undefined', 'true', 'false', 'if', 'else', 'this'];
const EOF = new Token(-1, TokenType.Character, 0, '');

class Lexer {
tokenize(text: string): Token[] {
    const scanner = new _Scanner(text);
    const tokens: Token[] = [];
    let token = scanner.scanToken();
    while (token != null) {
      tokens.push(token);
      token = scanner.scanToken();
    }
    return tokens;
  }
}




}