<?php


namespace trans\JavaCompiler\Parser\Tests;


use PHPUnit\Framework\TestCase;
use Symfony\Component\Yaml\Yaml;
use trans\JavaCompiler\Lexer\Lexer;
use trans\JavaCompiler\Lexer\Token;
use trans\JavaCompiler\Parser\Parser;

class ParserTest extends TestCase
{

    private function getFiles()
    {
        return [
            __DIR__ . '/spec/sample001.yml',
            __DIR__ . '/spec/sample002.yml'
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
            $item['file']   = file_get_contents(__DIR__ . "/../sample/" . $data['file']);

            foreach ($data['tokens'] as $token) {
                $item['tokens'][] = new Token($token['index'], $token['type'], $token['numValue'], $token['strValue']);
            }
            $datasets[]     = $item;
        }

        return $datasets;
    }
    /**
     * @dataProvider getData
     * @param $input
     */
    public function testParse($input, $expected) {

        $parser = new Parser(new Lexer());


        $result = $parser->parseAction($input, null);

        print_r($result);
    }
}