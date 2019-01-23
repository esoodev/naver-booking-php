<?php
/**
 *  Naver Booking Delivery Routing test
 */

declare (strict_types = 1);

use NaverBooking\Objects\Product;
use NaverBooking\Services\ProductService;
use PHPUnit\Framework\TestCase;

require_once dirname(__FILE__) . "/../src/Services/ProductService.php";
require_once dirname(__FILE__) . "/../src/Handlers/RequestHandler.php";
require_once dirname(__FILE__) . "/../src/Helpers/ArrayHelper.php";
require_once dirname(__FILE__) . "/../src/Config/NaverBookingConfig.php";
require_once dirname(__FILE__) . "/../src/Objects/Product.php";
require_once dirname(__FILE__) . "/../src/Objects/Dictionary.php";

final class ProductServiceTest extends TestCase
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

    const TEST_GET_PRODUCTS = 1;
    const TEST_GET_PRODUCT = 1;
    const TEST_CREATE_PRODUCT = 1;
    const TEST_EDIT_PRODUCT = 1;

    public function testCanGetProducts(): void
    {
        $error = null;
        self::_test('Get Products', function () use (&$error) {
            try {
                $service = new ProductService(self::ACCESS_TOKEN);
                $res = $service->getProducts(16363);
            } catch (\Exception $e) {$error = $this->_catchException($e);}
        }, self::TEST_GET_PRODUCTS);
        $this->assertNull($error);
    }

    public function testCanGetProduct(): void
    {
        $error = null;
        self::_test('Get Product', function () use (&$error) {
            try {
                $service = new ProductService(self::ACCESS_TOKEN);
                $res = $service->getProduct(16363, 107713);
            } catch (\Exception $e) {$error = $this->_catchException($e);}
        }, self::TEST_GET_PRODUCT);
        $this->assertNull($error);
    }

    public function testCanCreateProduct(): void
    {
        $error = null;
        self::_test('Create Product', function () use (&$error) {
            try {
                $service = new ProductService(self::ACCESS_TOKEN);
                $product = Product::exampleRequiredOnly();
                $product->setAgencyKey($this->_createAgencyKey());
                $res = $service->createProduct(16363, $product);
            } catch (\Exception $e) {$error = $this->_catchException($e);}
        }, self::TEST_CREATE_PRODUCT);
        $this->assertNull($error);
    }

    public function testCanEditProduct(): void
    {
        $error = null;
        self::_test('Edit Product', function () use (&$error) {
            try {
                $service = new ProductService(self::ACCESS_TOKEN);
                $product = Product::createEmpty();
                $product->setProductPrecaution('ttasdfasdfasdf');
                $product->setIsShow(false);
                $res = $service->editProduct(20180, 108917, $product);
            } catch (\Exception $e) {$error = $this->_catchException($e);}
        }, self::TEST_EDIT_PRODUCT);
        $this->assertNull($error);
    }

    /**
     *  PRIVATE METHODS
     */

    private static function _test($test_name, $test_function, $is_skip)
    {if ($is_skip) {$test_function();} else {echo ("\nSkipping ${test_name}..");}}

    private static function _outputFile($filename, $data): void
    {
        $fp = fopen(dirname(__FILE__) . "/outputs/ProductService/${filename}", 'w');
        fwrite($fp, $data);
        fclose($fp);
    }

    private static function _catchException(\Exception $e): array
    {
        $_e['message'] = $e->getMessage();
        $_e['code'] = $e->getCode();
        return $_e;
    }

    private static function _createAgencyKey()
    {
        $createRandString = function ($length) {
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
        return 'NBT_' . $createRandString(8);
    }

}
