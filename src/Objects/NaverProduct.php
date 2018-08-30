<?php

require_once dirname(__FILE__) . "/NaverDictionary.php";
require_once dirname(__FILE__) . "/../Helpers/ArrayHelper.php";

class NaverProduct
{

    public function __construct($data = null, $setDefault = false)
    {
        if (isset($data)) {
            foreach ($data as $key => $value) {
                $this->{$key} = $value;
            }
        } else {
            foreach (array_merge_recursive(self::requiredFields($setDefault),
                self::optionalFields($setDefault)) as $key => $value) {
                $this->{$key} = $value;
            }
        }
    }

    public static function example()
    {
        return new self(null, true);
    }

    public static function requiredFields($setDefault = false)
    {
        $f['agencyKey'] = 'PREFIX_01234';   // 12자리 이상일 시 에러남
        $f['name'] = '상품명'; // 업체명
        $f['stock'] = 10; // 기본 재고 (change to optional)
        $f['price'] = 10000; // 기본 가격 (change to optional)
        $f['minBookingCount'] = 1; // 예약 최소 수량
        $f['maxBookingCount'] = 10; // 예약 최대 수량
        $f['isSeatUsed'] = false; // 좌석 회차 사용 여부

        $f['bizItemResources'][0]['resourceTypeCode'] =
        NaverDictionary::RESOURCE_TYPE_CODES['대표이미지']; // 상품 리소스 list
        $f['businessResources'][0]['resourceUrl'] = "";

        // 추후 비필요 사항으로 검토
        $f['bookingCountSettingJson']['minBookingCount'] = 1;
        $f['bookingCountSettingJson']['maxBookingCount'] = 10;
        $f['bookingCountSettingJson']['maxPersonBookingCount'] = 10;

        if (!$setDefault) {
            ArrayHelper::setValuesNullRecursive($f);
        }

        return $f;
    }

    public static function optionalFields($setDefault = false)
    {
        $f = [];
        // $f['bizNumber'] = '2178139965'; // 사업자 등록번호
        // $f['cbizNumber'] = '2018-서울용산-0189'; // 통신판매업 신고번호

        // $f['addressJson']['address'] = '경기도 성남시 분당구 정자동 178-1'; // ?
        // $f['addressJson']['detail'] = '999층'; // 상세 위치

        if (!$setDefault) {
            self::_arraySetValuesNull($f);
        }

        return $f;
    }

    public function toJSON()
    {
        return json_encode(array_merge_recursive($this->requiredFields,
            $this->optionalFields), JSON_UNESCAPED_UNICODE);
    }

    public function setData(array $data)
    {
        foreach ($data as $key => $value) {
            $this->{$key} = $value;
        }
    }

}
