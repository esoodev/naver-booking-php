<?php

require_once dirname(__FILE__) . "/NaverDictionary.php";
require_once dirname(__FILE__) . "/../Helpers/ArrayHelper.php";

/**
 * NaverOption 는 API 문서상 NaverOption 과 동일.
 */
class NaverOption
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

    public static function exampleRequiredOnly()
    {
        return new self(self::requiredFields(true));
    }

    public static function requiredFields($setDefault = false)
    {
        $f['agencyKey'] = 'PREFIX_01234'; // 대행사에서 사용하는 메뉴 ID
        $f['categoryId'] = 16900; // 메뉴카테고리 ID
        $f['name'] = '옵션명'; // 옵션명
        $f['stock'] = 100; // 기본 재고
        $f['price'] = 10000; // 기본 가격
        $f['minBookingCount'] = 1; // 예약 최소 수량
        $f['maxBookingCount'] = 4; // 예약 최대 수량

        $f['optionResources'][0]['resourceTypeCode'] =
        NaverDictionary::RESOURCE_TYPE_CODES['대표이미지'];
        $f['optionResources'][0]['resourceUrl'] = "";

        if (!$setDefault) {
            self::_arraySetValuesNull($f);
        }

        return $f;
    }

    public static function optionalFields($setDefault = false)
    {
        $f['normalPrice'] = 20000; // 정상가
        $f['order'] = 0; // 노출 순서
        $f['desc'] = '네이버 예약 PHP 라이브러리를 통한 메뉴 설명 텍스트입니다.'; // 메뉴 설명
        $f['priceDesc'] = '초특가! 테스트 환경에서만 제공하는 반값 이벤트!'; // 가격 설명
        $f['startDate'] = '2018-08-27'; // 운영 시작 날짜
        $f['endDate'] = '2018-10-27'; // 운영 종료 날짜

        if (!$setDefault) {
            ArrayHelper::setValuesNullRecursive($f);
        }

        return $f;
    }

    /**
     * MISC
     */

    public function addStock($count)
    {
        $currStock = $this->stock;
        $finalStock = $currStock + $count;
        if ($finalStock < 0) {
            throw new InvalidArgumentException("Cannot add ${count} to stock count " .
                "${currStock}. The result is less than zero.");
        }
        $this->stock = $final;
        return $this->stock;
    }

    /**
     * GETTERS
     */

    public function getAgencyKey()
    {
        return $this->agencyKey;
    }

    public function getCategoryId()
    {
        return $this->categoryId;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getStock()
    {
        return $this->stock;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function getPriceOriginal()
    {
        return $this->normalPrice;
    }

    public function getMinBookingCount()
    {
        return $this->minBookingCount;
    }

    public function getMaxBookingCount()
    {
        return $this->maxBookingCount;
    }

    public function getImages()
    {
        return $this->optionResources;
    }

    public function getDesc()
    {
        return $this->desc;
    }

    public function getPriceDesc()
    {
        return $this->priceDesc;
    }

    
    /**
     * NOT
     */
    // public function getStartDate()
    // {
    //     return $this->startDate;
    // }
    // public function getEndDate()
    // {
    //     return $this->endDate;
    // }

    /**
     * SETTERS
     */

    public function setAgencyKey($agencyKey)
    {
        $this->agencyKey = $agencyKey;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setCategoryId($categoryId)
    {
        $this->categoryId = $categoryId;
    }

    public function setDesc($desc)
    {
        $this->desc = $desc;
    }

    public function setPriceDesc($priceDesc)
    {
        $this->priceDesc = $priceDesc;
    }

    public function setStock($stock)
    {
        $this->stock = $stock;
    }

    public function setPrice($price)
    {
        $this->price = $price;
    }

    public function setPriceOriginal($price)
    {
        $this->normalPrice = $price;
    }

    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;
    }
    
    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;
    }

    public function setMinBookingCount($minBookingCount)
    {
        $this->minBookingCount = $minBookingCount;
    }

    public function setMaxBookingCount($maxBookingCount)
    {
        $this->maxBookingCount = $maxBookingCount;
    }

    public function setMainImage($imageUrl)
    {
        $f['optionResources'][0]['resourceTypeCode'] =
        NaverDictionary::RESOURCE_TYPE_CODES['대표이미지'];
        $f['optionResources'][0]['resourceUrl'] = $imageUrl;
        if ($returnJson) {
            return $f;
        }
        $this->setData($f);
    }

    public function setData(array $data)
    {
        foreach ($data as $key => $value) {
            $this->{$key} = $value;
        }
    }

}
