<?php

require_once dirname(__FILE__) . "/NaverDictionary.php";
require_once dirname(__FILE__) . "/../Helpers/ArrayHelper.php";

/**
 * Misc Service 의 Search 개념에 맞음. NaverBusiness 에 적용하려면 toReformattedJSON() 을 사용.
 */
class NaverAddress
{

    public function __construct($searchData = null, $setDefault = false)
    {
        if (isset($searchData)) {
            foreach ($searchData as $key => $value) {
                $this->{$key} = $value;
            }
        } else {
            foreach (array_merge_recursive(self::requiredFields($setDefault),
                self::optionalFields($setDefault)) as $key => $value) {
                $this->{$key} = $value;
            }
        }

        $this->longitude = number_format($this->longitude, 4);
        $this->latitude = number_format($this->latitude, 4);
    }

    public static function example()
    {
        return new self(null, true);
    }

    public static function requiredFields($setDefault = false)
    {
        $f['name'] = '트러스트어스';
        $f['address'] = '서울특별시 용산구 한남동 33-6';
        $f['roadAddress'] = '서울특별시 용산구 독서당로 93';
        $f['longitude'] = '127.0105';
        $f['latitude'] = '37.5350';

        if (!$setDefault) {
            ArrayHelper::setValuesNullRecursive($f);
        }

        return $f;
    }

    public static function optionalFields($setDefault = false)
    {
        $f['detail'] = '3층'; // 상세주소
        $f['zoomLevel'] = 11; // 지도상 zoom level

        if (!$setDefault) {
            ArrayHelper::setValuesNullRecursive($f);
        }
        return $f;
    }

    /**
     * NaverBusiness 에 사용할 형식으로 변환.
     */
    public function toReformatJSON()
    {
        $f['jibun'] = $this->address;
        $f['roadAddr'] = $this->roadAddress;
        $f['address'] = $this->address;
        $f['posLat'] = number_format($this->longitude, 4);
        $f['posLong'] = number_format($this->latitude, 4);

        if (isset($f['detail'])) {
            $f['detail'] = $this->detail;
        }
        if (isset($f['zoomLevel'])) {
            $f['zoomLevel'] = $this->zoomLevel;
        }

        return $f;
    }

    public function setData(array $data)
    {
        foreach ($data as $key => $value) {
            $this->{$key} = $value;
        }
    }

    public function setDetail($newDetail, $returnJson = false)
    {
        $f['detail'] = $newDetail;
        if ($returnJson) {
            return $f;
        }
        $this->setData($f);
    }

    public function setZoomLevel(int $newZoomLevel, $returnJson = false)
    {
        $f['zoomLevel'] = $newZoomLevel;
        if ($returnJson) {
            return $f;
        }
        $this->setData($f);
    }

}
