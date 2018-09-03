<?php
/**
 *  Naver Booking Delivery Routing test
 */

declare (strict_types = 1);
use PHPUnit\Framework\TestCase;

final class MiscServiceTest extends TestCase
{

    const ACCESS_TOKEN = '4175d932e639db100683724' .
        'c85ba696c665d1b10d3f4283764d169c831698ea8e742466' .
        'f829ceedf04d48ce9f5ae618043ec6a0f333a227bfff3ca32' .
        '0c0ce78bfb61e62f51b4540877be772764139cc6f28272d32' .
        'f6dd21a4c9a619df99347e046d81ec74e57ac5fdc2a61b4e1' .
        '30ff9087c4d44c5f548715f7c28d6d684039eee00b680406c1' .
        '6a993242e486e4fee5f5b14bb7f0594789a07ead0fa6207da' .
        'b882102b0d01eeb07f73e180f7ccc319a9cef49e566d0f9346' .
        '1b212638e653d4570087a32631d518588a45a30259d174bec' .
        'c0583dee7f5aca17515d58d15911e416';

    const TEST_SEARCH_ADDRESS = 1;
    const TEST_UPLOAD_IMAGE_FILE = 1;

    public function testCanSearchAddress(): void
    {
        if (self::TEST_SEARCH_ADDRESS) {
            $service = new NaverMiscService(self::ACCESS_TOKEN);
            $res = $service->searchAddress('트러스트어스', 10);
            self::_outputFile('search-address.json',
                json_encode($res, JSON_UNESCAPED_UNICODE));

            $this->expectOutputString('');
            var_dump($res);
        } else {
            echo ("\nSkipping testCanSearchAddress()");
        }
    }

    public function testCanUploadImageFile(): void
    {
        if (self::TEST_UPLOAD_IMAGE_FILE) {
            $service = new NaverMiscService(self::ACCESS_TOKEN);
            $fileLoc = '/Users/nathanlee/Work/docker-naver-booking/lib' .
                '/tests/inputs/sample460.jpeg';
            $res = $service->uploadImageFile($fileLoc);
            self::_outputFile('upload-image-file-res.json',
                json_encode($res, JSON_UNESCAPED_UNICODE));

            $this->expectOutputString('');
            var_dump($res);
        } else {
            echo ("\nSkipping testCanUploadImageFile()");
        }
    }

    private static function _outputFile($filename, $data): void
    {
        $fp = fopen(dirname(__FILE__) . "/outputs/NaverMiscService/${filename}", 'w');
        fwrite($fp, $data);
        fclose($fp);
    }

}
