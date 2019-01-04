<?php
/**
 *  Naver Booking Delivery Routing test
 */

declare (strict_types = 1);
use NaverBooking\Objects\Business;
use NaverBooking\Objects\Address;
use NaverBooking\Services\BusinessService;
use NaverBooking\Services\MiscService;
use NaverBooking\Services\OptionService;
use PHPUnit\Framework\TestCase;

final class CombinedTest extends TestCase
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
    const BUSINESS_ID = 16363;

    const TEST_EDIT_BUSINESS_ADDR_TO_SEARCH_RES = 1;
    const TEST_LINK_OPTION_TO_BUSINESS = 1;

    public function testCanEditBusinessAddressToSearchResult(): void
    {
        if (self::TEST_EDIT_BUSINESS_ADDR_TO_SEARCH_RES) {
            $bs = new BusinessService(self::ACCESS_TOKEN);
            $ms = new MiscService(self::ACCESS_TOKEN);
            $business = new Business($bs->getBusiness(self::BUSINESS_ID));
            $address = (new Address($ms->searchAddress('김가네')[0]))->toReformatJSON();
            self::_outputFile('edit-address-search-addr.json',
                json_encode($address, JSON_UNESCAPED_UNICODE));

            $res = $bs->editBusiness($business->getBusinessId(), $body);

            self::_outputFile('edit-address-search-res.json',
                json_encode($res, JSON_UNESCAPED_UNICODE));

            $this->expectOutputString('');
            var_dump($res);
        } else {
            echo ("\nSkipping testCanEditBusinessAddressToSearchResult()");
        }
    }

    public function testCanLinkOptionToBusiness(): void
    {
        $bs = new BusinessService(self::ACCESS_TOKEN);
        $os = new OptionService(self::ACCESS_TOKEN);
        $ms = new MiscService(self::ACCESS_TOKEN);

        $businessId = $bs->getBusinessIdByBusinessName('trustusdev',
            '아웃백 스테이크 하아 힘들다!');
        $categoryId = $os->getDefaultOptionCategoryId($businessId);

        $option = NaverOption::example();

        // 이미지 업로드
        $imgFileUrl = $ms->uploadImageFile(dirname(__FILE__) .
            '/inputs/sample460.jpeg');

        $option->setMainImage($imgFileUrl);
        $option->setCategoryId($categoryId);
        $option->setName('테스트 옵션!');

        $res = $os->createOption($businessId, $option);
        self::_outputFileJSON('link-option.json', $res);

    }

    private static function _outputFile($filename, $data): void
    {
        $fp = fopen(dirname(__FILE__) . "/outputs/Combined/${filename}", 'w');
        fwrite($fp, $data);
        fclose($fp);
    }

    private static function _outputFileJSON($filename, $data): void
    {
        self::_outputFile($filename, json_encode($data, JSON_UNESCAPED_UNICODE));
    }

}
