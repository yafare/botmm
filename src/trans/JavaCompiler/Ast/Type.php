<?php


namespace trans\JavaCompiler\Output;


use trans\JavaCompiler\Output\Type\BuiltinType;

abstract class Type
{

    public static $DYNAMIC_TYPE ;
    public static $BOOL_TYPE     ;
    public static $INT_TYPE      ;
    public static $NUMBER_TYPE   ;
    public static $STRING_TYPE   ;
    public static $FUNCTION_TYPE ;
    public static $NULL_TYPE     ;


    public $modifiers;

    public function __construct(array $modifiers = null)
    {
        self::$DYNAMIC_TYPE  = new BuiltinType(BuiltinTypeName :: Dynamic);
        self::$BOOL_TYPE     = new BuiltinType(BuiltinTypeName :: Bool);
        self::$INT_TYPE      = new BuiltinType(BuiltinTypeName :: Int);
        self::$NUMBER_TYPE   = new BuiltinType(BuiltinTypeName :: Number);
        self::$STRING_TYPE   = new BuiltinType(BuiltinTypeName :: String);
        self::$FUNCTION_TYPE = new BuiltinType(BuiltinTypeName ::Function);
        self::$NULL_TYPE     = new BuiltinType(BuiltinTypeName :: null);


        if (!$modifiers) {
            $this->$modifiers = [];
        }
        $this->modifiers=$modifiers;
    }

    abstract public function visitType(TypeVisitor $visitor, $context);

    public function hasModifier(TypeModifier $modifier): boolean
    {
        return $this->modifiers . indexOf(modifier) !== -1;
    }
}