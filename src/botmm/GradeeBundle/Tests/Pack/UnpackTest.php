<?php


namespace botmm\GradeeBundle\Tests\Pack;


use Beta\B;
use botmm\BufferBundle\Buffer\Buffer;
use botmm\BufferBundle\Buffer\StreamInputBuffer;
use botmm\GradeeBundle\Oicq\Cypher\Cryptor;
use botmm\GradeeBundle\Oicq\Tools\Hex;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UnpackTest extends WebTestCase
{

    public function getData()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/gradee/loginpacksimple');

        //$this->assertContains('Hello World', $client->getResponse()->getContent());

        return [
            [
                $client->getResponse()->getContent()
            ],
            [
                '00 00 03 d9 
                 00 00 00 0b 
                 02 00 00 82
                 97 00 
                 00 00 00 0b 32383637333031
                 c846b68edf159d8ab7df204288ae293862c1c09d7c13ab6e465da574fc11990c2aa3c8654aa8b082e0b11087701d2bda7d35e8f2a057597ecf84999ff5a14efaf6d49978116c311a9864296ab3d8866f9f80881fe59d03f7470ac2d56fe9b2285f840d900c4fc796337dfe63ea0cb269c19d4fd7fea07ad3263e092d3f43f2be81b454fcec6484c00e1a3b36e9e0aa33e09b1186674417aee3f47638d6ef654df0177639964ca149cb4cecfda635305a4e41a0c31da407aa60c5512b3799d85662ac6ada9492388f04de38f5d987dc96860df2ffb0275b5373beffe11f7368990f476cfed99bc34ed45efe1aa390b304f759b3ecfd74974e9a314e5cbe1f06b11b74a99a7f78587d2ecc6d5a23e19d66d7d52e1457b33670d19b06e9d9809ba1e7674c8b7a94f87afca72701a7222f51fadb778598bebb24f64096cd8cdc76631647d7098f3c2a6a138f9bbd84008bf4b45dbafc6c407fcbfe9a9ae0c687d45495826945e431050a7a13c0e2faeea39a17d2f0b6deef4431915e9927e189d574f2a288d248e162933c4da9bf4e57dee165746ede4710f58ee866fcc29c0b2bb37ffc366bb1dc67c14a5e784c19b25941f4d9e979407dacf925c327f1a2fb7b24c4ad81c71dc6462ed2ad2aa05f8ab910197bc4f2278233ddd5ab7beadbbcba8438cc2bf45b2b9ebca78d62fae9d088db3917e6b209a211e6b05e95f3f6d0b147fd354719b45f79fa1b669c257f1df265368aa5a30d14781988e11c3ccdf30b6bb520f29084c4c21f3d1121339b193468eeef032885bc201e5dcec0cdb9414ef5fdfacd31b249ee4639ed1e84ce8355fed3920d1dd8aaa87dee3be6e3a25b2cb65d8ab5827acb3329896ca525a9b8c47f5d529099619f635dacc7ff35f8efa90afcc97754e4d3bbf599c83e78a42dd6cc6f588ec0829b6c8f0b4f580cc481917a74042ee684dbc1aaa537d8184d652668a897f72cc6878abdbe13c62c99d9ab04789d50498cb1838d5d811e947bdc68b32eb9c6fe514d2e645c62293c54722930a9c8cbf9269b62e9fd55c4111017c0ca3d9be5d3070994634c7e2a81e50c5297312db91cdeb9329ed265a6e084256ac66ea22113b804752eaaa76e3cae0dea857f5a3e8113aa2e628c72e35b82f6bfd88bcd7fef177553d10d310ce1c7f9e4bf20329ca262bb42d6546908c6ba099575b14ca897f03e5767dbdc28961ba9b07b5897ab8c696231f4e10ab36c0c0ee19ce3f07fcf621fe46d67efa8f4e37e8e2001d73353e474e340aa323749640ab3f235be2d333a63262c346cdcfd85c9a699c226714a0cf40b4141aa896cd1b2a23d0d317ad7c8be4efacb05abdb09edea4b'
            ],
        ];
    }

    public $data;

    /**
     * @dataProvider getdata
     * @param $data
     */
    public function testUnpak($data)
    {
        $this->data        = Hex::HexStringToBin($data);
        $streamInputBuffer = new StreamInputBuffer(Buffer::from($this->data));

        $len = $streamInputBuffer->readInt32BE();
        $this->assertEquals(strlen($this->data), $len);
        $head = $streamInputBuffer->readHex(10);
        $this->assertEquals('00 00 00 0b 02 00 00 82 97 00', $head);

        //print Hex::BinToHexString($head);

        $qqLen = $streamInputBuffer->readInt32BE();
        $qq    = $streamInputBuffer->read($qqLen - 4);
        $this->assertEquals('2867301', $qq);
        echo $qq . "\n";

        $encrypted = $streamInputBuffer->read(strlen($this->data) - ($qqLen + 14));

        $data = Cryptor::decrypt($encrypted, 0, strlen($encrypted), pack('a16', null));

        //echo Hex::BinToHexString($data);
        $input = new StreamInputBuffer(Buffer::from($data));

        //echo Hex::BinToHexString($input->read(16));
        $headLen = $input->readInt32BE();
        echo $headLen . "\n";
        //$headInfo['ssoSeq']   = $input->readInt32BE();
        //$headInfo['subAppId'] = dechex($input->readInt32BE());
        //$headInfo['wxAppId']  = dechex($input->readInt32BE());
        $headInfo['cmd']        = $input->read($input->readInt32BE() - 4);
        $headInfo['msgCookies'] = Hex::BinToHexString($input->read($input->readInt32BE() - 4));
        $headInfo['extBin']     = Hex::BinToHexString($input->read($input->readInt32BE() - 4));

        //$headInfo['extBin']     = Hex::BinToHexString($input->read($input->readInt32BE() - 4));
        print_r($headInfo);

        //oicq wupbuffer
        $bodyLen = $input->readInt32BE();
        $this->assertEquals('02', $input->readHex(1));
        //$this->assertEquals($bodyLen - 4, $input->readInt16BE());
        $oicqLen = $input->readInt16BE();
        $input   = new StreamInputBuffer(Buffer::from($input->read($oicqLen - 4)));


        $this->assertEquals('1f 41', $input->readHex(2));
        $this->assertEquals('08 10', $input->readHex(2));
        $oicq['seq'] = $input->readInt16BE();
        $this->assertEquals(2867301, $input->readInt32BE());
        $this->assertEquals('03', $input->readHex(1));
        $this->assertEquals('87', $input->readHex(1));
        $oicq['retry']          = $input->readInt8();
        $oicq['ext_type']       = $input->readInt32BE();
        $oicq['client_version'] = $input->readInt32BE();
        $oicq['ext_instance']   = $input->readInt32BE();
        $this->assertEquals('01 01', $input->readHex(2));
        $oicq['randKey'] = $input->readHex(16);
        $this->assertEquals('01 02', $input->readHex(2));
        $oicq['pubKey'] = Hex::BinToHexString($input->read($input->readInt16BE()));
        $this->assertEquals('03 4b 6b 9f 22 ce c8 67 83 97 87 aa 32 06 7a e2 b3 bd 9d 57 8f 20 97 6d b4',
                            $oicq['pubKey']);

        $shareKeyEncrypted = $input->read($oicqLen - 4 - $input->getOffset());

        //tlv
        $decrypted = Cryptor::decrypt($shareKeyEncrypted, 0, strlen($shareKeyEncrypted),
                                      Hex::HexStringToBin('7d1ffc96239d17a236f122d2b497a300')
        );


        //echo Hex::BinToHexString($decrypted);

        $this->handleTlv($decrypted);

    }

    public function handleTlv($tlvs)
    {
        $input = new StreamInputBuffer(Buffer::from($tlvs));
        $this->assertEquals('00 09', $input->readHex(2));
        $this->assertEquals(24, $input->readInt16BE());


        $this->testTlv18($input);
        $this->testTlv1($input);
        $this->testTlv106($input);
    }

    public function testTlv18($input)
    {
        $this->assertEquals('00 18', $input->readHex(2));
        $tlv18Len = $input->readInt16BE();
        $this->assertEquals('00 01', $input->readHex(2));
        $this->assertEquals('00 00 06 00', $input->readHex(4));
        $this->assertEquals('00 00 00 10', $input->readHex(4));
        $this->assertEquals('00 00 00 00', $input->readHex(4));
        $this->assertEquals(2867301, $input->readInt32BE());
        $this->assertEquals(0, $input->readInt32BE());

    }

    public function testTlv1($input)
    {
        $this->assertEquals('00 01', $input->readHex(2));
        $len = $input->readInt16BE();
        $this->assertEquals('00 01', $input->readHex(2));
        $input->readHex(4);
        $this->assertEquals(2867301, $input->readInt32BE());
        echo date('Y-m-d H:i:s', $input->readInt32BE()) . "\n";
        $this->assertEquals('00 00 00 00 00 00', $input->readHex(6));
    }

    public function testTlv106($input)
    {
        $this->assertEquals('01 06', $input->readHex(2));
        $len = $input->readInt16BE();

        $encrypted = $input->read($len);

        $decrypted = Cryptor::decrypt($encrypted, 0, strlen($encrypted),
                                      md5(md5('thirstyzebr', true) . Hex::HexStringToBin('00 00 00 00 00 2B C0 65'),
                                          true)
        );

        $input = new StreamInputBuffer(Buffer::from($decrypted));

        $this->assertEquals('00 04', $input->readHex(2));
        echo $input->readHex(4) . "\n";
        $this->assertEquals('00 00 00 05', $input->readHex(4));
        $this->assertEquals('00 00 00 10', $input->readHex(4));
        $this->assertEquals('00 00 00 00', $input->readHex(4));
        $this->assertEquals('00 00 00 00', $input->readHex(4));
        $this->assertEquals(2867301, $input->readInt32BE());
        echo date('Y-m-d H:i:s', $input->readInt32BE()) . "\n";
        $this->assertEquals('00 00 00 00', $input->readHex(4));
        $this->assertEquals('01', $input->readHex(1));
        $this->assertEquals('c7 ea bf 0b 2b e3 e6 73 12 c5 ee 69 ed 20 7e bf', $input->readHex(16));
        $this->assertEquals('12 09 53 a3 bc d5 fd e5 87 7f 1e 60 a1 a0 94 12', $input->readHex(16));
        $this->assertEquals('00 00 00 00', $input->readHex(4));
        $this->assertEquals('01', $input->readHex(1));

    }


}