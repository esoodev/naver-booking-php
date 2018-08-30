<?php
/**
 *  Naver Booking Delivery Routing test
 */

declare (strict_types = 1);
use PHPUnit\Framework\TestCase;

final class BusinessTest extends TestCase
{

    const TEST_GET_ADDRESSES = 0;
    const TEST_SHOW_REQUIRED_FIELDS = 0;

    public function testCangetAddrs(): void
    {
        if (self::TEST_GET_ADDRESSES) {
            $business = Business::example();
            $addrs = $business->getAddrs();
            self::_outputFile('get-addresses.json',
                json_encode($addrs, JSON_UNESCAPED_UNICODE));
            $this->assertEquals(0, 0);
        } else {
            echo ("\nSkipping testCangetAddrs()");
        }
    }

    public function testCanShowRequiredFields(): void
    {
        if (self::TEST_SHOW_REQUIRED_FIELDS) {
            self::_outputFile('required-fields.json',
                json_encode(Business::requiredFields(), JSON_UNESCAPED_UNICODE));

            $this->expectOutputString('');
            var_dump(Business::requiredFields());

        } else {
            echo ("\nSkipping testCanShowRequiredFields()");
        }
    }

    private static function _outputFile($filename, $data): void
    {
        $fp = fopen(dirname(__FILE__) . "/outputs/Business/${filename}", 'w');
        fwrite($fp, $data);
        fclose($fp);
    }

}
