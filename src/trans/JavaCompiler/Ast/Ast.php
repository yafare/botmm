<?php


namespace trans\JavaCompiler;





class AST
{
    public $span;

    public function __construct(ParseSpan $span)
    {
        $this->span = $span;

    }

    public function visit(AstVisitor $visitor, $context = null)
    {
        return null;
    }

    public function toString(): string
    {
        return 'AST';
    }
}

/**
 * Represents a quoted expression of the form:
 *
 * quote = prefix `:` uninterpretedExpression
 * prefix = identifier
 * uninterpretedExpression = arbitrary string
 *
 * A quoted expression is meant to be pre-processed by an AST transformer that
 * converts it into another AST that no longer contains quoted expressions.
 * It is meant to allow third-party developers to extend Angular template
 * expression language. The `uninterpretedExpression` part of the quote is
 * therefore not interpreted by the Angular's own expression parser.
 */
class Quote extends AST
{
    public $prefix;
    public $uninterpretedExpression;
    public $location;

    public function __construct(ParseSpan $span, string $prefix, string $uninterpretedExpression, $location)
    {

        parent::__construct($span);
        $this->prefix = $prefix;
        $this->uninterpretedExpression = $uninterpretedExpression;
        $this->location = $location;
    }

    public function visit(AstVisitor $visitor, $context = null)
    {
        return $visitor->visitQuote($this, $context);
    }

    public function toString(): string
    {
        return 'Quote';
    }
}

class EmptyExpr extends AST
{
    public function visit(AstVisitor $visitor, $context = null)
    {
        // do nothing
    }
}

class ImplicitReceiver extends AST
{
    public function visit(AstVisitor $visitor, $context = null)
    {
        return $visitor->visitImplicitReceiver($this, $context);
    }
}

/**
 * Multiple expressions separated by a semicolon.
 */
class Chain extends AST
{
    public $expressions;

    public function __construct(ParseSpan $span, array $expressions)
    {
        parent::__construct($span);
    }

    public function visit(AstVisitor $visitor, $context = null)
    {
        return $visitor->visitChain($this, $context);
    }
}

class Conditional extends AST
{
    public $condition;
    public $trueExp;
    public $falseExp;

    public function __construct(ParseSpan $span, AST $condition, AST $trueExp, AST $falseExp)
    {
        parent::__construct($span);
        $this->condition=$condition;
        $this->trueExp=$trueExp;
        $this->falseExp=$falseExp;
    }

    public function visit(AstVisitor $visitor, $context = null)
    {
        return $visitor->visitConditional($this, $context);
    }
}

class PropertyRead extends AST
{
    public $receiver;
    public $name;

    public function __construct(ParseSpan $span, AST $receiver, string $name)
    {
        parent::__construct($span);
        $this->receiver = $receiver;
        $this->name = $name;
    }

    public function visit(AstVisitor $visitor, $context = null)
    {
        return $visitor->visitPropertyRead($this, $context);
    }
}

class PropertyWrite extends AST
{
    public $receiver;
    public $name;
    public $value;

    public function __construct(ParseSpan $span, $receiver, $name, $value)
    {
        parent::__construct($span);
        $this->receiver=$receiver;
        $this->name=$name;
        $this->value=$value;
    }

    public function visit(AstVisitor $visitor, $context = null)
    {
        return $visitor->visitPropertyWrite($this, $context);
    }
}

class SafePropertyRead extends AST
{
    public $receiver;
    public $name;

    public function __construct(ParseSpan $span, AST $receiver, string $name)
    {
        parent::__construct($span);
        $this->receiver = $receiver;
        $this->name = $name;
    }

    public function visit(AstVisitor $visitor, $context = null)
    {
        return $visitor->visitSafePropertyRead($this, $context);
    }
}

class KeyedRead extends AST
{
    public $obj;
    public $key;

    public function __construct(ParseSpan $span, AST $obj, AST $key)
    {
        parent::__construct($span);
        $this->obj = $obj;
        $this->key = $key;
    }

    public function visit(AstVisitor $visitor, $context = null)
    {
        return $visitor->visitKeyedRead($this, $context);
    }
}

class KeyedWrite extends AST
{
    public $obj;
    public $key;
    public $value;

    public function __construct(ParseSpan $span, AST $obj, AST $key, AST $value)
    {
        parent::__construct($span);
        $this->obj = $obj;
        $this->key = $key;
        $this->value = $value;
    }

    public function visit(AstVisitor $visitor, $context = null)
    {
        return $visitor->visitKeyedWrite($this, $context);
    }
}

class BindingPipe extends AST
{
    public $exp;
    public $name;
    public $args;

    public function __construct(ParseSpan $span, AST $exp, string $name, array $args)
    {
        parent::__construct($span);
        $this->exp = $exp;
        $this->name = $name;
        $this->args = $args;
    }

    public function visit(AstVisitor $visitor, $context = null)
    {
        return $visitor->visitPipe($this, $context);
    }
}

class LiteralPrimitive extends AST
{
    public $value;

    public function __construct(ParseSpan $span, $value)
    {
        parent::__construct($span);
        $this->value = $value;
    }

    public function visit(AstVisitor $visitor, $context = null)
    {
        return $visitor->visitLiteralPrimitive($this, $context);
    }
}

class LiteralArray extends AST
{
    public $expressions;

    public function __construct(ParseSpan $span, array $expressions)
    {
        parent::__construct($span);
        $this->expressions = $expressions;
    }

    public function visit(AstVisitor $visitor, $context = null)
    {
        return $visitor->visitLiteralArray($this, $context);
    }
}

class LiteralMap extends AST
{
    public $keys;
    public $values;

    public function __construct(ParseSpan $span, array $keys, array $values)
    {
        parent::__construct($span);
        $this->keys = $keys;
        $this->values = $values;
    }

    public function visit(AstVisitor $visitor, $context = null)
    {
        return $visitor->visitLiteralMap($this, $context);
    }
}

class Interpolation extends AST
{
    public $strings;
    public $expressions;

    public function __construct(ParseSpan $span, array $strings, array $expressions)
    {
        parent::__construct($span);
        $this->strings = $strings;
        $this->expressions = $expressions;
    }

    public function visit(AstVisitor $visitor, $context = null)
    {
        return $visitor->visitInterpolation($this, $context);
    }
}

class Binary extends AST
{
    public $operation;
    public $left;
    public $right;

    public function __construct(ParseSpan $span, string $operation, AST $left, AST $right)
    {
        parent::__construct($span);
        $this->operation = $operation;
        $this->left = $left;
        $this->right = $right;
    }

    public function visit(AstVisitor $visitor, $context = null)
    {
        return $visitor->visitBinary($this, $context);
    }
}

class PrefixNot extends AST
{
    public $expression;

    public function __construct(ParseSpan $span, AST $expression)
    {
        parent::__construct($span);
        $this->expression = $expression;
    }

    public function visit(AstVisitor $visitor, $context = null)
    {
        return $visitor->visitPrefixNot($this, $context);
    }
}

class MethodCall extends AST
{
    public $receiver;
    public $name;
    public $args;

    public function __construct(ParseSpan $span, AST $receiver, string $name, array $args)
    {
        parent::__construct($span);
        $this->receiver = $receiver;
        $this->name = $name;
        $this->args = $args;
    }

    public function visit(AstVisitor $visitor, $context = null)
    {
        return $visitor->visitMethodCall($this, $context);
    }
}

class SafeMethodCall extends AST
{
    public $receiver;
    public $name;
    public $args;

    public function __construct(ParseSpan $span, AST $receiver, string $name, array $args)
    {
        parent::__construct($span);
        $this->receiver = $receiver;
        $this->name = $name;
        $this->args = $args;
    }

    public function visit(AstVisitor $visitor, $context = null)
    {
        return $visitor->visitSafeMethodCall($this, $context);
    }
}

class FunctionCall extends AST
{
    public $target;
    public $args;

    public function __construct(ParseSpan $span, AST $target, array $args)
    {
        parent::__construct($span);
        $this->target = $target;
        $this->args = $args;
    }

    public function visit(AstVisitor $visitor, $context = null)
    {
        return $visitor->visitFunctionCall($this, $context);
    }
}

class ASTWithSource extends AST
{
    public $ast;
    public $source;
    public $location;
    public $errors;

    public function __construct(
        AST $ast, string $source, string $location,
        array $errors)
    {
        parent::__construct(new ParseSpan(0, empty($source) ? 0 : strlen($source)));
    }

    public function visit(AstVisitor $visitor, $context = null)
    {
        return $this->ast->visit($visitor,$context);
    }

    public function toString(): string
    {
        return "{$this->source} in {$this->location}";
    }
}




