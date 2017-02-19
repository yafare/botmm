<?php


namespace src\trans\JavaCompiler\Lexer\Tests;


use PHPUnit\Framework\TestCase;
use trans\JavaCompiler\Lexer\Lexer;
use Symfony\Component\Yaml\Yaml;
use trans\JavaCompiler\Lexer\Token;

class LexerTest extends TestCase
{

    private function getFiles()
    {
        return [
            __DIR__ . '/sample/sample001.yml',
            __DIR__ . '/sample/sample002.yml'
        ];
    }

    /**
     * @return array
     */
    public function getData()
    {
        $yaml     = new Yaml();
        $files    = $this->getFiles();
        $datasets = [];

        foreach ($files as $file) {
            $data           = $yaml->parse(file_get_contents($file));
            $item = [];
            $item['file']   = file_get_contents(dirname($file) . "/" . $data['file']);

            foreach ($data['tokens'] as $token) {
                $item['tokens'][] = new Token($token['index'], $token['type'], $token['numValue'], $token['strValue']);
            }
            $datasets[]     = $item;
        }

        return $datasets;
    }

    /**
     * @dataProvider getData()
     */
    public function testSample($file, $expected)
    {
        $lexer  = new Lexer();
        $tokens = $lexer->tokenize($file);

//        foreach ($tokens as $token) {
//            $str = <<<EOL
// -
//    index: "{$token->index}"
//    type: "{$token->type}"
//    numValue: "{$token->numValue}"
//    strValue: "{$token->strValue}"
//
//EOL;
//
//            echo $str;
//        }

        $this->assertEquals($expected, $tokens);
    }

}