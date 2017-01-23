<?php

namespace botmm\tools\Cypher\Tests;

use AppBundle\Cypher\Tea;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class QqTeaTest extends WebTestCase
{
    public function testIndex()
    {

    }

    public function testCypher()
    {
        $data   = 'abcdef';
        $key    = '00 00 00 00 00 00 00 00 00 00 00 00 00 00 00 00';
        $result = TEA::encrypt($key, $data);

        print_r($result);

    }
}
