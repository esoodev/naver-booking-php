<?php
/**
 *  Naver Booking Delivery Routing test
 */

declare (strict_types = 1);

use NaverBooking\Objects\Business;
use NaverBooking\Services\BusinessService;
use PHPUnit\Framework\TestCase;

require_once dirname(__FILE__) . "/../src/Services/BusinessService.php";
require_once dirname(__FILE__) . "/../src/Handlers/RequestHandler.php";
require_once dirname(__FILE__) . "/../src/Config/NaverBookingConfig.php";
require_once dirname(__FILE__) . "/../src/Objects/Business.php";
require_once dirname(__FILE__) . "/../src/Objects/Dictionary.php";

final class BusinessServiceTest extends TestCase
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

    const TEST_GET_BUSINESSES = 0;
    const TEST_GET_BUSINESS = 0;
    const TEST_GET_BUSINESSIDS_BY_NAME = 0;
    const TEST_GET_BUSINESSES_BY_NAME = 0;
    const TEST_CREATE_BUSINESS = 1;
    const TEST_EDIT_BUSINESS = 0;
    const TEST_EDIT_BUSINESS_ADDR_BY_ID = 0;
    const TEST_MAP_BUSINESS = 0;
    const TEST_UNMAP_BUSINESS = 0;

    public function testCanGetBusinesses(): void
    {
        if (self::TEST_GET_BUSINESSES) {
            $service = new BusinessService(self::ACCESS_TOKEN);
            $res = $service->getBusinesses('yata62', 10);
            self::_outputFile('get-businesses.json',
                json_encode($res, JSON_UNESCAPED_UNICODE));

            $this->expectOutputString('');
            var_dump($res);
        } else {
            echo ("\nSkipping testCanGetBusinesses()");
        }
    }

    public function testCanGetBusiness(): void
    {
        if (self::TEST_GET_BUSINESS) {
            $service = new BusinessService(self::ACCESS_TOKEN);
            $res = $service->getBusiness(16363);
            self::_outputFile('get-business.json',
                json_encode($res, JSON_UNESCAPED_UNICODE));

            $this->expectOutputString('');
            var_dump($res);
        } else {
            echo ("\nSkipping testCanGetBusiness()");
        }
    }

    public function testCanGetBusinessIdsByBusinessName(): void
    {
        $accountName = 'trustusdev';
        $businessName = 'Soomin Lee';

        if (self::TEST_GET_BUSINESSIDS_BY_NAME) {
            $service = new BusinessService(self::ACCESS_TOKEN);
            $ids = $service->getBusinessIdsByBusinessName($accountName,
                $businessName);
            self::_outputFile('get-businessids-by-name.json',
                json_encode($ids));
            $this->expectOutputString('');
            var_dump($ids);
        } else {
            echo ("\nSkipping testCanGetBusinessIdsByName()");
        }
    }

    public function testCanGetBusinessesByBusinessName(): void
    {
        $accountName = 'trustusdev';
        $businessName = 'Soomin Lee';

        if (self::TEST_GET_BUSINESSES_BY_NAME) {
            $service = new BusinessService(self::ACCESS_TOKEN);
            $businesses = $service->getBusinessesByBusinessName($accountName,
                $businessName);
            self::_outputFile('get-businesses-by-name.json',
                json_encode($businesses, JSON_UNESCAPED_UNICODE));
            $this->expectOutputString('');
            var_dump($businesses);
        } else {
            echo ("\nSkipping testCanGetBusinessesByBusinessName()");
        }
    }

    public function testCanCreateBusiness(): void
    {
        $error = null;
        self::_test('Create Business', function() use (&$error) {
            try {
                $service = new BusinessService(self::ACCESS_TOKEN);
                $business = Business::example();
                // $agency_key = $this->_createAgencyKey();
                $agency_key = 'NBT_gsrHoGjh ';
                $business->setAgencyKey($agency_key);
                $business->setServiceName($agency_key, true);
                $res = $service->createBusiness($business);
            } catch (\Exception $e) {
                $error = $this->_catchException($e);
            }
        }, self::TEST_CREATE_BUSINESS);
        $this->assertNull($error);
    }

    public function testCanEditBusiness(): void
    {   
        $error = null;
        self::_test('Edit Business', function() use ($error) {
            try {
                $service = new BusinessService(self::ACCESS_TOKEN);
                $business = Business::example();
                $business->setServiceName('new damn name!', true);
                $business->setServiceDesc('new damn service desc', true);
                $business->setBusinessName('아웃백 스테이크 하아 힘들다!', true);
                $business->setBusinessEmail('123@naver.com', true);
                unset($business->agencyKey);
                unset($business->bookingTimeUnitCode);
                unset($business->businessTypeId);
                unset($business->businessCategory);
                $data = json_decode(json_encode($business, JSON_UNESCAPED_UNICODE), true);
                $res = $service->editBusiness(19835, $data);
            } catch (\Exception $e) {
                $error = $this->_catchException($e);
            }
        }, self::TEST_EDIT_BUSINESS);
        $this->assertNull($error);
    }

    public function testCanEditBusinessAddressById(): void
    {
        if (self::TEST_EDIT_BUSINESS_ADDR_BY_ID) {
            $service = new BusinessService(self::ACCESS_TOKEN);
            $addrRoad1 = "서울특별시 강남구 압구정로 165";
            $addrRoad2 = "서울특별시 강남구 강남대로102길 34";
            $addrJibun1 = "서울특별시 서초구 잠원로 51";
            $addrJibun2 = "서울특별시 강남구 신사동 623-2";
            $res = $service->editBusinessAddressById(19835, [$addrJibun2, '주소 상세'],
                true);
            self::_outputFile('edit-business-addr-res.json',
                json_encode($res, JSON_UNESCAPED_UNICODE));
            $this->expectOutputString('');
            var_dump($res);
        } else {
            echo ("\nSkipping testCanEditBusinessAddressById()");
        }
    }

    public function testCanMapBusiness(): void
    {
        if (self::TEST_MAP_BUSINESS) {
            $service = new BusinessService(self::ACCESS_TOKEN);
            $businessId = 19695;
            $agencyKey = 'POI_dnFUoGbc';
            $res = $service->mapBusiness('yata62', $businessId, $agencyKey);
            self::_outputFile('map-business.json',
                json_encode($res, JSON_UNESCAPED_UNICODE));

            $this->expectOutputString('');
            var_dump($res);
        } else {
            echo ("\nSkipping testCanMapBusiness()");
        }
    }

    public function testCanUnmapBusiness(): void
    {
        if (self::TEST_UNMAP_BUSINESS) {
            $service = new BusinessService(self::ACCESS_TOKEN);
            $businessId = 19695;
            $agencyKey = 'POI_dnFUoGbd';
            try {
                $res = $service->unmapBusiness('yata62', $businessId, $agencyKey);
                self::_outputFile('unmap-businesses.json',
                    json_encode($res, JSON_UNESCAPED_UNICODE));

                $this->expectOutputString('');
                var_dump($res);
            } catch (\Exception $e) {
                var_dump($e->getMessage());
            }
        } else {
            echo ("\nSkipping testCanUnmapBusiness()");
        }
    }

    private static function _test($test_name, $test_function, $is_skip)
    {if ($is_skip) {$test_function();} else {echo ("\nSkipping ${test_name}...");}}

    private static function _outputFile($filename, $data): void
    {
        $fp = fopen(dirname(__FILE__) . "/outputs/BusinessService/${filename}", 'w');
        fwrite($fp, $data);
        fclose($fp);
    }

    private static function _catchException(\Exception $e): array
    {
        $_e['message'] = $e->getMessage();
        $_e['code'] = $e->getCode();
        return $_e;
    }

    private static function _createAgencyKey() {
        $createRandString = function($length) {
            $random = '';
            for ($i = 0; $i < $length; $i++) {
                $is_cap = mt_rand(0, 1);
                if ((bool) $is_cap) {
                    $random .= chr(mt_rand(97, 122));
                } else {
                    $random .= chr(mt_rand(65, 90));
                }
            }
            return $random;
        };
        return 'NBT_'.$createRandString(8);
    }

}
