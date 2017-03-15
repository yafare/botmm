<?php


namespace Cryptor;


use botmm\GradeeBundle\Oicq\Cypher\Cryptor;
use botmm\GradeeBundle\Oicq\Tools\Hex;
use botmm\GradeeBundle\Tests\Tlv\TlvTestCase;

class TEATest extends TlvTestCase
{

    public function testDec001()
    {
        $data = "
 500333B8E5C2C2931E6654B8CF559D1F6A67652860616921AB02FDEBE69EB086B38A0375F4E68EFEB9E6C4D7DABB781655AEEC79DD2ACFD370453F2F17C301360FEAB5F09FFFE961F2E86A88DF3F17B8CC5BCF723F4ED0E1315274B210FCCE385DEEDC3108A8B17D79F9FA20AE459B108A6DE7BB8A86AAC35495C61D61A00839F5581F77F25905463CEC87D4A7C468DA71B8CDF413810924E8F5A1D5DCF1561D055844B5040AC67DF9CDD1E1815F9ACABA2F034FE0B67CD5A39A6FE6E16F19B31A03E84BF7F1BA4BF182E4AAE7F2767462DE5DB444EE3F87CFB36618675C8C7E8AF940A46170B6D57A93504E7628DAA562AEC43798DC84AB74A6DFB6B0446A78337F8EE45FDB2DC89E4F30DF50204FAE36FB28C9BF67FD781D368C6170928BBDA1FB92957B85DE1A133898BEBFCF2CC43B2D3B0A18781EC60B7A5DCAACC7B8A70B904220E0745458D0F490C3FDE8B59F6FCE47B51DC6AA791CF2ED60701925F7C50AE4F58F03E91EEEEED20781EB3C0A1AF5081D5178BE34FB120BFC1884D2732C59EE665106E2959B28A4DAD6C6762582CEA0D1BAA401AF34083668E77B9001BD1EB3685CDB649EB845625C7631CAB9E3F76528FF883BAD2C46513DDD962FC5030B723F1385518BEC7770ADBF096241651BD5FE2C6AA959E7E092F603A2DD562F3D297F6BEEB37C856E0E06F8AD6AE4FB233E04587DD14DC29893EE85375B4A399EDF52B81833FD057B3757C2A625A01C8AD852E1D0BDCF827C7BFB9EF86754712FABC414396CDEF57F59963D0F3B66F49B3DF5F7E000605E5D4DCC2EE78AB2CF1C25C959E818E11E197F44C43DCAA32AA5493F4F37B18106F71DEF339CA829988AF85E288052322D88145B6EBF4B50245A78E52738E8A90EADF2A1C328494C6BB91129AF6C100A4AFA5051AD337850B37F54CE3C47CFB0E0DC455AB1B5D897D9182F40F09CCCB1FC4DEC0661A2FBE15D24C689EC9FE1F42DE7DBE07132A9DDD821D9560DD639BEB4E26720E94093593B79F5852BF6F1E88C4C5DF3B5F785C632C9DC23F74F07080B73499AFB24BC745F9AB7FF255BFD8F0AAD178BD2C9306A73BA9D209CBA23AECEC814E85F1884E8244F09FFECAD5D965DC48C6032D6DC92003A3EF8417D4D5444548C9B63204611173AE8DE3E7AC3B8A242E49B2E4FE07220065A385DF24F5B5DCC8363C355AC1D5E1E9E9175F2907C6DE0E41CDD5272EB1DD340AD6037894223CA160F110B25E4FFC42F5BD49D54F8167C482B3D68E93D5E47D1E91E9B5E9FFC7A7D1C36A0F4EF60BBA964ABE8C5482DCBCA3A9D2BD5E3D269789B9A8C7B084CDA3C91AA05294BB5279A6AB16A9CAB10191D25A3449A6BCAFE7F1B358172C2E85FE8B484266F676A242460CCF5C45EB4A0A49164D22F11583D71941355D3E1B67B52DD53C4A801211C877FB9D18B556BF3D3A472927F0CD040EFD38C5CBD236BEB5976A35F2D6D85EBF0174FDDBD496053E8D5423FAF0A0E0E75D57DE91218D5C44073B450BB9222A497A914ED9AF8B3A637DCD22947B051F009CA6EE1E9D4B321455F7B7A1EEF834B08193B40393FC5BA5900287139B2EE23D87B16BDF63757F88BF4B1D16BB55B02A90D3B692EB685BB98720EB78790C9FB400C62BFFEF2398C36D36757B4086F4594A0B4017D1A841A8101C6393B041A0B0FFD091B1F57F491190056EE7EE78B4722E777CB91E1F3B2B9A1D84172E6CB13D26A33BF56363354C8050402213D59D7842575B130FB2D4F31856B2E86BE25CAAC710FE4F2A275F303A58E6C7B996B48A67657B5B1D3A20163C991AE171BBD8D9640C57B6AD5870E1B6033FF8C5517EFC960A36EC511A2835BE2434244293A11EB90D9BBFC16F34F537B46E6687A602892E258C85DDA7056B40073EB92299EECAABF1B9F67B23E429DAD800917BE0EA4B55519C77AE1A6D35A7AF21782BE3111A441140A3B1F2F4A1D98C679D0238C7AA5201881FC738081DA966107473762D7163D60FF3BE93110D86E67445856938EAFEA8E7654C73EDECB5C6A520751CB3B9E190CE81E94594001546B3B43D0032CE84DA902A6976725FE8B69FA222CDA08285AFDCB3DA314B6B8D2C38692EC8EDD3EE2E140712C5753C1F72D12B82A1B8CE47218B53E5A5DC19E5A9973FB23BA204B297828526F69131A6824253AF1735199F7B149FD25F01197E6E6427CE9F5D535AA56D935C69CA4BA34DEA9B09892BA35EBF9FC0717186DEA968CC27D1316FCFF87276E8EEC7CFE4495DE26CE440BFD3F6FAD025FC0DF9A37B8E52F851007204CAD79E65C6C63305C56DCF74025B7613611D5F940616632D04F30CD16514E1AA6DD6700968F32B69F7B083ED511ACCBD53F0C9DFF2582616B9D64584A9F43354BEE5A4398A8D71276518E898FF840C5A61D4FCC8AEF06BEBD718D29E78205C36B15052A7D29C88CBE5B4DE0457FCA8BE7F99FA82EEA0BD252192C900B952089FBEAC97FFABF808552DEB920E6FABE8D6FDC3E027565B22D17F6AAD842124BD79869EF754528EF8046D7995E20C0CF517BFC96FA48689EE55993371822A02FC505AB2152715CFC25F2FFD461805F8BCC12DCEAF86C53CB1C602737D66DE73ABF23EF87A815D6BFD74EFBA3F4715C6CC55D197A4AE43A41865169009AFC92FD8E21E921FABDF39ECC49DBC03A54B9ABEB7F3846B9C84DA9761AEE44698D9D30207EED514C2E7752582C9F9039DBA858BA4708DB268112BF851E31D3A1A395EE81C3CFF5C5011BBECA90D6EF03EE76D41A37BED4533296460590AAA027B8BE620416D1D17D88BB5BECD3F6917E4F72A4DD5A565B621DAE22E7A10257E515918CAFC9138AE0AA365BCCECF2C19EB5FE8CC801ED4C538EC56C98B282D9D34CE5BF48DFDC06EC8891A1AE1211A0EAEAA3740FE0B37D4711F5E7C7069297C558F150264349580B71F397D14ED823108146F330C537D21A29FECA15E9E01FFF11AA0E9299825825FE8831F504E4AD613EF7B700A8E9D1279E80387AB828F41F6ECF94A4DE711C91E75793C467B7E403147DA1CA0B6AF1ABE5E98FA66C9471C257B3CA2315B7B65B56D706F7650F750A56F2AFFB10A4DB83242D36E86825B1BD01DC498C3D6D70218DFF35B9623F35D1C09A22AF46891DB984AEC3B4F521ADB5CE86D4948A3EE1AD58EF5F3606D97ED9D60D4F19C5405A1284EBD41006E611704EEAD92F78054247D9772D21D6621801DD6F890E241296A412CFB07D687CF510D35B72DF99047BDE27B5D64FDAC3EC36217916D3DE013E63ECC0E1AFC905A2B9666CB35118E921FE65B29DE5E1AA2F31E6C97B1959754005E6074126732B04455C945FD3D98014F7B546C8AFE2305A8AA0E8097E51B7C6ED71E3EFDD22759B9BF07175CAE0D3B08FDAD341F69CDCEAA32E5C277BE43574DF15A80C5B68D3410635AAFA27CD55F1C4DC7EE0C3A60A74EED14D021838E5677874BEAF5606E1EAA246C3EA6AAEA87347FDC932DCAF7207B71CEA3EE03F0A7A69646DEF8AB35C393137F18A2E14BE19CA42C118AF80343DEB6F380EE2EA529F395C1108579F2DE03E0A5E88C7E377BEFFEEF6FA9E03A9BF72399A97E67F23E8D478A6DFB01F612CD36EBFE239A16CF257E481A7B23E7AC828859FB62845E6AF7C2C4DEF44EE78A231A01B665414CFA1DE3746451C2E8F1FE164B31F3E5B1B8E811C13487CE5D5C34B9109E7C062E8A4DF2ACFAB2333BFE4F367E829122B51CAC26F0506EFBA29997DDF584B41287A6B4EFFABDA3223E025174995D7B12DF1DBE8EA8A2A1698379B90E569B93AE62BF45676C84688C441A97C73D9389B02B2DB906C24E1151D876D91A23C9A14A1439E667BC7476E4603250719E1EA3204989E4B0DAC6C9F0F5C94951998236D9771FB242D7906B20D804D98D80202AA89E03646CF0BC2E0497DFDE63542B23C245EDC4098DDBDD5FAB0BC48C12D994463420F595E9100C08EFBF7B0FB796148CBFFBA77B13E970976EEC563574FE259DD2955CAD9CCD417EAF0ED9C2E81BA607CC4C7B20313CF4E0F50041D5787841B03D5632E72F5DBABD46B03FFF10CF8C5E260AC54BD7FB6BA6D31A95BB7E12E93FF68231A5678ACB9102BBA5361B4178F0E5171CB4A86B63846B1266FD7C95A58B663B1D9F9FBC38641D9DFDFD4A278074EFEA72B88DCC1D0166670485B4136E95D4EEF5252E53B92B16C0C225340AC84CA383563CF07659C23F9FF5D09AD4A67AC5F6D3F1B4636F33E39CC91310D2794472694A26B8E8BA4EA4CB9AEF4A66B76350B71D94C9B8D7D4DA322CE5084D8288ABDB96AE53070C7A5866DE7B4099EAF00BFB1C99542720C79CBFA600EA06FBEC74EBE09A13E595BBD596DEAAB9C3A03790B1C3153C4820D6086E4A3B82F488AFBE0D403ECF1D4709504E31F0603D4B7392F4CC7FBB19F32B835B45B5B441ACCA2F93AA9C6FF15D0F0DC885C1738719D97365FA4E8C96E40974BE8C991348F515653962E755DEDBE4B804F785934AA232F5B39F2D604D3D692513E5B948F591091630D9D9DA292DBF7D21A65D3842AC98A5F8E12631790E7ACED62123C305AED7270A39EC0DFBBA5459F3925B5C2D06A230634974DEECE96F0ABC8774636564FBC1EE8F3B544AACE996154FF3562EF0B2A875932EDA439610D11CEB529F0586F35E09BD66994B8C15643DCCAEC24822EAE27BECF05DA79536B9136A0C2A221633D0E2F6A78FEFDA863C8D0C8A1523400DEA69324D4266A3F795251383546E6D2C52D546EC54690F7C03A1A86895B32D27F034EF9F6FA0C42995840C24EF803E395A9414EC60F9314798B4783370804FC28BBB298584E88B23166651BCBE20F234815A6AA3797D9FF90C1A078E38D2765716332AAC763A6919F03C53D7B98E82A0D00839A086E006E65051977588EE4228865060CF7E80EAACDA9F8BBD07731C1A86FA77246710C374F7025E9159897E1D0336CE9F64117C111D5EEBC6D3FDE807B0A0CB7CC9F86391F861E746C37E816401DC55FC8C9133C34E2396C2B1AF11B8E23A152D77E6056EAF43C167F8053E816FC10C9070FB748A169A28C6457766C3067589A9F61EA5F4B33DB83B210B0B5E88EACDD7C4603EC28A08A87F260DA2789D24E3F7C8DCBC9830FB11BC1658647BD7A59206364FA2B881FB9F36192FAB741CB8878588C8D1CE9CB0B48823A089DA6ECAD805796DDDC7A33705F1939E55390A4FBF0962B9DF9A5892B42BB598A94B249D4865BDDB2BEF1290C2C2426C4023F35D67E3D614E5EF9AA5E03CF3176BB3BD0ECC7BF1AF80DE69A9EF70BAFDFEA71935B268F54BBB78F1E016143B48723D76FE6A58E51E15DA872C91251C44C51F67B71285728331D08DF74A026D599DD0F8E2AB9FBC6

";
        $key = '00 00 00 00 00 00 00 00 00 00 00 00 00 00 00 00';
        //$key  = '7d1ffc96239d17a236f122d2b497a300';//sharekey
        //$key = '74ccb6a8c92f95de435fa9c329f2c816';//md5_2+uin 123456789
        $key = md5(md5('thirstyzebra', true).hex2bin('00000000002bc065'));//md5_2+uin 12345678
        print $key;
        //$key = md5(md5('123456', true).hex2bin('00000000002bc065'));//md5_2+uin 12345678
        //$key = 'cf 2c 33 2a 1b af 36 d0 34 9f ab 27 ac 0b 29 2c';//tmp 009 tgtgt
        //$key  = '66 6f 55 bc 4d 6b 3a 34 6c f4 b0 b1 b4 b9 6c a9';
        //$key = '67 24 2e 42 35 55 74 55 44 62 67 73 3c 38 66 58';
        //$key = '3f 25 4b 0e 79 39 59 32 55 30 9b 31 d0 ba d5 82';//101 randkey
        $key = '40 6a 6b 21 7d 45 62 3f 27 4d 75 2d 68 57 2e 45';//101 sessionkey

        $str    = Hex::HexStringToBin($data);
        $result = Cryptor::decrypt($str, 0, strlen($str), Hex::HexStringToBin($key));


        $this->assertBinEqualsHex("0c", $result, "should equal");
    }

    public function testGzinflate()
    {
        //$source   = Hex::HexStringToBin("7B226170705F736967223A22EFBFBDEFBFBD45EFBFBD24EFBFBDEFBFBD7752775C7530303136EFBFBDEFBFBD6EEFBFBDEFBFBD222C226170705F6E223A22636F6D2E74656E63656E742E6D6F62696C657171222C226F73223A2232222C2262766572223A22362E332E312E31393933222C226F735F76223A22342E342E32222C22646973705F6E616D65223A225151222C226274696D65223A22323031365C2F31325C2F32382031333A35303A3432222C22646576696365223A224D4920344C5445222C226170705F76223A22362E362E39222C226B736964223A223966323638613662353231623532333364616266663561663862653531393435222C226C7374223A5B7B22737562617070223A22353337303439373232222C22617070223A223136222C2272737431223A2230222C2272737432223A2230222C226170706C697374223A2231363030303030323236222C22656D61696C223A2232383637333031222C227374617274223A2231343836333936383239222C226F706572223A22434D4343222C2261747472223A302C2275696E223A2232383637333031222C2275736564223A22343934222C2274797065223A226C6F67696E222C226C6F67223A5B7B22776170223A2233222C22706F7274223A2230222C22737562223A22307839222C22636F6E6E223A2230222C22686F7374223A22222C22726C656E223A223733222C226E6574223A2230222C2275736564223A223335222C226970223A22222C22736C656E223A22393038222C22636D64223A223078383130222C22737472223A22222C2272737432223A2230222C22747279223A2230227D2C7B22776170223A2233222C22706F7274223A2230222C22737562223A22307839222C22636F6E6E223A2230222C22686F7374223A22222C22726C656E223A2231353933222C226E6574223A2230222C2275736564223A22313338222C226970223A22222C22736C656E223A22393135222C22636D64223A223078383130222C22737472223A22222C2272737432223A2230222C22747279223A2230227D5D7D5D2C2273646B5F76223A2235227D");
        //$composed = gzcompress($source, -1, ZLIB_ENCODING_DEFLATE);
        //$composed2 = gzencode($source, -1, FORCE_DEFLATE);
        //$this->assertEquals($composed, $composed2);
        //print_r(Hex::BinToHexString($composed));
        //$uncomposed = gzuncompress($composed);
        //print_r(Hex::BinToHexString($uncomposed));

        $str = Hex::HexStringToBin("
                                    cd bf 52 07 dd 94 e3
2f 4f 26 f7 f7 8a b0 7c  9e d3 f5 5e a6 17 e4 15
b5 6a 93 28 bd c8 8f 89  b7 6f c0 1d db 17 0f 7c
fa 6d 05 2f 47 df f8 12  23 60 81 ab 73 10 13 2e
b4 7e 74 d4 72 bf 52 ec  64 84 8b 93 ec 1a 02 28
2b c4 21 4c 2c 79 f9 d9  f6 1a 08 b0 40 83 67 56
38 9b 9a b7 77 9f 97 2b  6f 85 56 19 c9 8c f9 5c
13 5c 03 db 35 aa ce 10  34 04 e7 21 40 2b 21 85
09 85 3d 16 41 38 ee 08  82 a6 5d 50 47 10 b7 cd
b8 46 45 ff 53 44 6a 1e  b1 ef b0 dd 4d d2 2a c3
09 37 fe b9 60 55 d0 fc  4a f5 87 1e 9e d7 8c 27
5b d1 9d b5 3b 35 07 e8  06 04 a6 76 3e 11 64 88
e1 66 12 4d 68 3a 47 fc  ba ed 5e 88 64 c3 68 7a
f1 5d 54 50 a5 85 ff 42  fe c1 65 55 2b c0 6e 4c
87 d1 98 8c f5 da f5 6a  66 78 56 28 92 76 11 e8
e2 3d e5 a9 47 59 48 f3  91                     
        ");

        //$bin = gzinflate($str);
        //
        $bin = gzuncompress($str);
        print_r($bin) ;
        print  "\n";
        print_r(Hex::BinToHexString($bin));

    }
}