<?php
/**
 *  Naver Booking Delivery Routing test
 */

declare (strict_types = 1);
use PHPUnit\Framework\TestCase;

final class RestaurantBusinessTest extends TestCase
{

    const TEST_MAKE_NEW_RESTAURANT = 1;
    const TEST_GET_ADDRESSES = 1;

    public function testCanMakeNewRestaurant(): void
    {
        if (self::TEST_MAKE_NEW_RESTAURANT) {
            $restaurant = new RestaurantBusiness();
            self::_outputFile('make-restaurant.json',
                json_encode($restaurant, JSON_UNESCAPED_UNICODE));
            $this->assertEquals(0, 0);
        } else {
            echo ("\nSkipping testCanMakeNewRestaurant()");
        }
    }

    public function testCanMakeNewRestaurantExample(): void
    {
        if (self::TEST_MAKE_NEW_RESTAURANT) {
            $restaurant = RestaurantBusiness::example();
            self::_outputFile('make-restaurant-example.json',
                json_encode($restaurant, JSON_UNESCAPED_UNICODE));
            $this->assertEquals(0, 0);
        } else {
            echo ("\nSkipping testCanMakeNewRestaurantExample()");
        }
    }

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

    private static function _outputFile($filename, $data): void
    {
        $fp = fopen(dirname(__FILE__) . "/outputs/RestaurantBusiness/${filename}", 'w');
        fwrite($fp, $data);
        fclose($fp);
    }

}
