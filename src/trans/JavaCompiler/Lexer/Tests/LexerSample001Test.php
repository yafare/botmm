<?php


namespace src\trans\JavaCompiler\Lexer\Tests;


use PHPUnit\Framework\TestCase;
use trans\JavaCompiler\Lexer\Lexer;
use Symfony\Component\Yaml\Yaml;

class LexerTest extends TestCase
{

    private function getFiles() {
        return [
            __DIR__ . '/sample001.yml'
        ];
    }

    /**
     * @return array
     */
    public function getData() {
        $yaml = new Yaml();
        $files = $this->getFiles();
        $datasets = [];

        foreach ($files as $file) {
            $data = $yaml->parse(file_get_contents($file));
            $data['file'] = file_get_contents($data['file']);
            $datasets[] = $data;
        }

        return $datasets;
    }

    /**
     * @dataProvider getData()
     */
    public function testSample001($file, $tokens) {
        $lexer = new Lexer();
        $tokens = $lexer->tokenize($file);
        print_r($tokens);
    }

}