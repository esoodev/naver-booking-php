<?php

require_once dirname(__FILE__) . "/NaverDictionary.php";

class NaverBusiness
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
        $f['agencyKey'] = 'PREFIX_01234';
        $f['name'] = '업체명'; // 업체명
        $f['serviceName'] = '서비스 이름'; // 서비스 이름
        $f['desc'] = '네이버 예약 PHP 라이브러리를 통한 업체 설명 텍스트입니다.';          // 서비스 소개
        $f['businessTypeId'] = NaverDictionary::BUSINESS_TYPE_ID['식당'];;     // 서비스 유형
        $f['businessCategory'] = NaverDictionary::BUSINESS_CATEGORIES['식당']; // 업종 구분
        $f['reprOwnerName'] = '대표자명'; // 대표자명
        $f['email'] = 'businessemail@gmail.com'; // 업체 이메일
        $f['addressJson']['jibun'] = '경기도 성남시 분당구 정자동 178-1';
        $f['addressJson']['posLat'] = 37.359544;
        $f['addressJson']['posLong'] = 127.105473;
        $f['phoneInformationJson']['wiredPhone'] = '02-123-4567'; // 업체 연락처(?)
        $f['phoneInformationJson']['reprPhone'] = '02-567-1234'; // "전화번호"
        $f['phoneInformationJson']['phoneList'] = ['02-548-0620']; // 관리자 연락처
        $f['bookingConfirmCode'] =  NaverDictionary::BOOKING_CONFIRM_CODES['즉시'];
        $f['bookingTimeUnitCode'] = NaverDictionary::BOOKING_TIME_UNIT_CODES['30분'];
        $f['uncompletedBookingProcessCode'] = NaverDictionary::UNCOMPLETED_BOOKING_PROCESS_CODES['취소'];
        $f['businessResources'][0]['resourceTypeCode'] =
        NaverDictionary::RESOURCE_TYPE_CODES['대표이미지'];
        $f['businessResources'][0]['order'] = 0;
        $f['businessResources'][0]['resourceUrl'] = '';

        if (!$setDefault) {
            self::_arraySetValuesNull($f);
        }

        return $f;
    }

    public static function optionalFields($setDefault = false)
    {
        $f['bizNumber'] = '2178139965'; // 사업자 등록번호
        $f['cbizNumber'] = '2018-서울용산-0189'; // 통신판매업 신고번호
        $f['addressJson']['detail'] = '999층'; // 상세 위치

        if (!$setDefault) {
            self::_arraySetValuesNull($f);
        }

        return $f;
    }

    /**
     * GETTERS
     */

    public function getBusinessId()
    {
        return $this->businessId;
    }

    public function getAddresses()
    {
        return $this->addressJson;
    }

    public function getPhones()
    {
        return $this->phoneInformationJson;
    }

    public function getBusinessName()
    {
        return $this->name;
    }

    public function getOwnerName()
    {
        return $this->reprOwnerName;
    }

    public function setData(array $data)
    {
        foreach ($data as $key => $value) {
            $this->{$key} = $value;
        }
    }

    public function getBusinessEmail()
    {
        return $this->email;
    }

    public function getServiceName()
    {
        return $this->serviceName;
    }

    public function getServiceDesc()
    {
        return $this->desc;
    }

    public function getAgencyKey()
    {
        return $this->agencyKey;
    }

    /**
     * SETTERS
     */

    public function setAddressJibun($newAddressJibun)
    {
        $this->addressJson['jibun'] = $newAddressJibun;
    }

    public function setAddressRoad($newAddressRoad)
    {
        $this->addressJson['roadAddr'] = $newAddressJibun;
    }

    public function setAddressDetail($newAddressDetail)
    {
        $this->addressJson['detail'] = $newAddressDetail;
    }

    public function setAddressCoord($posLat, $posLong)
    {
        $this->addressJson['posLat'] = $posLat;
        $this->addressJson['posLong'] = $posLong;
    }

    public function setPhoneWired($wiredPhone)
    {
        $this->phoneInformationJson['wiredPhone'] = $wiredPhone;
    }

    public function setPhoneRep($reprPhone)
    {
        $this->phoneInformationJson['reprPhone'] = $reprPhone;
    }

    public function setPhoneList(array $phoneList)
    {
        $this->phoneInformationJson['phoneList'] = $phoneList;
    }

    public function addPhoneList($phone)
    {
        array_push($this->phoneInformationJson['phoneList'], $phone);
    }

    public function setBusinessName($name)
    {
        $this->name = $name;
    }

    public function setOwnerName($reprOwnerName)
    {
        $this->reprOwnerName = $reprOwnerName;
    }

    public function setBusinessEmail($email)
    {
        $this->email = $email;
    }

    public function setServiceName($serviceName)
    {
        $this->serviceName = $serviceName;
    }

    public function setServiceDesc($desc)
    {
        $this->desc = $desc;
    }

    public function setAgencyKey($agenctKey)
    {
        $this->agenctKey = $agenctKey;
    }

    public function setMainImage($imgUrl)
    {
        $f['businessResources'][0]['resourceTypeCode'] =
        NaverDictionary::RESOURCE_TYPE_CODES['대표이미지'];
        $f['businessResources'][0]['order'] = 0;
        $f['businessResources'][0]['resourceUrl'] = $imgUrl;

        $this->setData($f);
    }

    public function setBusinessType($key)
    {
        $this->businessTypeId = NaverDictionary::BUSINESS_TYPE_ID[$key];
    }

    public function setBusinessCategory($key)
    {
        $this->businessCategory = NaverDictionary::BUSINESS_CATEGORIES[$key];
    }

    public function setBookingConfirm($key)
    {
        $this->bookingConfirmCode = NaverDictionary::BOOKING_CONFIRM_CODES[$key];
    }

    public function setBookingTimeUnit($key)
    {
        $this->bookingTimeUnitCode = NaverDictionary::BOOKING_TIME_UNIT_CODES[$key];
    }

    public function setIncompleteBookingProcess($key)
    {
        $this->uncompletedBookingProcessCode =
        NaverDictionary::UNCOMPLETED_BOOKING_PROCESS_CODES[$key];
    }

    private static function _arraySetValuesNull(&$arr)
    {
        foreach ($arr as $key => &$value) {
            if (is_array($value)) {
                if (count($value) > 0) {
                    self::_arraySetValuesNull($value);
                }
            } else {
                if (isset($value)) {
                    $value = null;
                }
            }
        }
    }

}
