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

    public static function exampleRequiredOnly()
    {
        return new self(self::requiredFields(true));
    }

    public static function requiredFields($setDefault = false)
    {
        $f['agencyKey'] = 'PREFIX_01234'; // 12자리 이상일 시 에러남
        $f['name'] = '상품명'; // 상품명
        $f['minBookingCount'] = 1; // 예약 최소 수량 추후 비필요 사항으로 검토
        $f['maxBookingCount'] = 10; // 예약 최대 수량 추후 비필요 사항으로 검토
        $f['uncompletedBookingProcessCode'] =
        NaverDictionary::UNCOMPLETED_BOOKING_PROCESS_CODES['완료']; // 미사용 티켓 처리 코드

        $f['bizItemResources'][0]['resourceTypeCode'] =
        NaverDictionary::RESOURCE_TYPE_CODES['대표이미지']; // 상품 리소스 list
        $f['businessResources'][0]['resourceUrl'] = "";

        if (!$setDefault) {
            ArrayHelper::setValuesNullRecursive($f);
        }

        return $f;
    }

    public static function optionalFields($setDefault = false)
    {
        $f['desc'] = '예제 상품 설명입니다.'; // 상품 설명
        $f['bookingPrecation'] = '상품예약 주의사항입니다.'; // 상품예약 주의사항
        $f['phone'] = '010-123-1234'; // 상품 전화번호
        $f['isImpStock'] = true; // 재고 수량 노출 여부
        $f['startDate'] = '2018-11-09'; // 예약 시작일
        $f['endDate'] = '2018-11-21'; // 예약 종료일
        $f['bookingGuideJson']['words'] = '예약 가이드'; // 예약 가이드
        $f['bookingCancelGuideJson']['words'] = '예약 취소 가이드'; // 예약 취소 가이드
        $f['bookableSettingJson']['isUseOpen'] = false; // 예약 오픈 시간 사용 여부
        $f['bookableSettingJson']['openDateTime'] =
        DateTime::createFromFormat('Y-m-d', '2018-2-15',
            new DateTimeZone('Asia/Seoul'))->format(DateTime::W3C);
        $f['bookableSettingJson']['isUseClose'] = false; // 예약 마감 시간 사용 여부
        $f['bookableSettingJson']['closeDays'] = 0; // 시작일 + 1일 이후 마감
        $f['bookableSettingJson']['closeHours'] = 0; // 시작일 + 1시간 이후 마감

        if (!$setDefault) {
            self::_arraySetValuesNull($f);
        }

        return $f;
    }

    /**
     * MISC
     */
    public function isEnded()
    {

    }

    /**
     * GETTERS
     */

    public function getProductName()
    {
        return $this->name;
    }

    public function getProductDesc()
    {
        return $this->desc;
    }

    public function getProductPrecation()
    {
        return $this->bookingPrecation;
    }

    public function getBookingGuide()
    {
        return $this->bookingGuideJson['words'];
    }

    public function getBookingCancelGuide()
    {
        return $this->bookingCancelGuideJson['words'];
    }

    public function getStartDateString()
    {
        return $this->startDate;
    }

    public function getStartDate()
    {
        return DateTime::createFromFormat(DateTime::W3C,
            $this->bookableSettingJson['openDateTime'],
            new DateTimeZone('Asia/Seoul'));
    }

    public function getEndDateString()
    {
        return $this->endDate;
    }

    public function getEndDate()
    {
        $startDate = $this->getStartDate();
        $days = empty($this->bookableSettingJson['closeDays']) ?
        $this->bookableSettingJson['closeDays'] . 'D' : '';
        $hours = empty($this->bookableSettingJson['closeHours']) ?
        $this->bookableSettingJson['closeHours'] . 'H' : '';
        return $startDate->add(new DateInterval("P${days}${hours}"));
    }

    /**
     * SETTERS
     */

    public function setAgencyKey($agencyKey)
    {
        $this->agencyKey = $agencyKey;
    }

    public function setProductName($name)
    {
        $this->name = $name;
    }

    public function setProductDesc($desc)
    {
        $this->desc = $desc;
    }

    public function setProductPrecation($bookingPrecation)
    {
        $this->bookingPrecation = $bookingPrecation;
    }

    public function setIsShowRemaining($isImpStock)
    {
        $this->isImpStock = $isImpStock;
    }

    public function setBookingGuide($words)
    {
        $this->bookingGuideJson['words'] = $words;
    }

    public function setBookingCancelGuide($words)
    {
        $this->bookingCancelGuideJson['words'] = $words;
    }

    /**
     * 오픈 및 종료 시간 설정
     */

    public function setStartDateTime($dateString, $format = 'Y-m-d H:i:s')
    {
        $this->bookableSettingJson['isUseOpen'] = true; // 예약 오픈 시간 사용 여부
        $this->bookableSettingJson['openDateTime'] =
        DateTime::createFromFormat($format, $dateString,
            new DateTimeZone('Asia/Seoul'))->format(DateTime::W3C);
    }

    private function setEndDateTime($dateString, $format = 'Y-m-d H:i:s')
    {
        $endDate = DateTime::createFromFormat($format, $dateString);
        $startDate = $this->getStartDate();
        $diff = $startDate->diff($endDate, true);
        $this->addEndDays($diff->d);
        $this->addEndHours($diff->h);
    }

    private function addEndDays($nDays)
    {
        $this->bookableSettingJson['isUseClose'] = true;
        $closeDays = &$this->bookableSettingJson['closeDays'];
        if (isset($closeDays)) {
            $closeDays += $nDays;
        } else {
            $closeDays = $nDays;
        }
    }

    private function addEndHours($nHours)
    {
        $this->bookableSettingJson['isUseClose'] = true;
        $closeHours = &$this->bookableSettingJson['closeHours'];
        if (isset($closeHours)) {
            $closeHours += $nHours;
        } else {
            $closeHours = $nHours;
        }
    }

    private function unsetEndDateTime()
    {
        $this->bookableSettingJson['isUseClose'] = false;
        $this->bookableSettingJson['closeDays'] = 0;
        $this->bookableSettingJson['closeHours'] = 0;
    }

    public function setMainImage($imgUrl)
    {
        $f['bizItemResources'][0]['resourceTypeCode'] =
        NaverDictionary::RESOURCE_TYPE_CODES['대표이미지'];
        $f['bizItemResources'][0]['order'] = 0;
        $f['bizItemResources'][0]['resourceUrl'] = $imgUrl;

        $this->setData($f);
    }

    public function setData(array $data)
    {
        foreach ($data as $key => $value) {
            $this->{$key} = $value;
        }
    }

    /**
     * UNUSED / UNSURE
     */

    public function setStartDate($dateString, $format = 'Y-m-d H:i:s')
    {
        $this->startDate = DateTime::createFromFormat($format, $dateString,
            new DateTimeZone('Asia/Seoul'))->format('Y-m-d');
    }

    public function setEndDate($dateString, $format = 'Y-m-d H:i:s')
    {
        $this->endDate = DateTime::createFromFormat($format, $dateString,
            new DateTimeZone('Asia/Seoul'))->format('Y-m-d');
    }

}
