<?php


namespace trans\JavaParser\Lexer;


use trans\JavaParser\Keywords;

class Lexer
{
    public static $KEYWORDS;
    public static $EOF;

    public function __construct()
    {
        self::$KEYWORDS = [
            Keywords::_ABSTRACT_,
            Keywords::_CONTINUE_,
            Keywords::_FOR_,
            Keywords::_NEW_,
            Keywords::_SWITCH_,
            Keywords::_ASSERT_,
            Keywords::_DEFAULT_,
            Keywords::_GOTO_,
            Keywords::_PACKAGE_,
            Keywords::_SYNCHRONIZED_,
            Keywords::_BOOLEAN_,
            Keywords::_DO_,
            Keywords::_IF_,
            Keywords::_PRIVATE_,
            Keywords::_THIS_,
            Keywords::_BREAK_,
            Keywords::_DOUBLE_,
            Keywords::_IMPLEMENTS_,
            Keywords::_PROTECTED_,
            Keywords::_THROW_,
            Keywords::_BYTE_,
            Keywords::_ELSE_,
            Keywords::_IMPORT_,
            Keywords::_PUBLIC_,
            Keywords::_THROWS_,
            Keywords::_CASE_,
            Keywords::_ENUM_,
            Keywords::_INSTANCEOF_,
            Keywords::_RETURN_,
            Keywords::_TRANSIENT_,
            Keywords::_CATCH_,
            Keywords::_EXTENDS_,
            Keywords::_INT_,
            Keywords::_SHORT_,
            Keywords::_TRY_,
            Keywords::_CHAR_,
            Keywords::_FINAL_,
            Keywords::_INTERFACE_,
            Keywords::_STATIC_,
            Keywords::_VOID_,
            Keywords::_CLASS_,
            Keywords::_FINALLY_,
            Keywords::_LONG_,
            Keywords::_STRICTFP_,
            Keywords::_VOLATILE_,
            Keywords::_CONST_,
            Keywords::_FLOAT_,
            Keywords::_NATIVE_,
            Keywords::_SUPER_,
            Keywords::_WHILE_,
        ];
        self::$EOF      = new Token(-1, TokenType::Character, 0, '');
    }

    public function tokenize($text)
    {
        $scanner = new Scanner($text);
        $tokens  = [];
        $token   = $scanner->scanToken();
        while ($token != null) {
            $tokens[] = $token;
            $token    = $scanner->scanToken();
        }
        return $tokens;
    }
}