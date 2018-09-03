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

    public static function requiredFields($setDefault = false)
    {
        $f['businessTypeId'] = NaverDictionary::BUSINESS_TYPE_ID['숙박']; // 서비스 유형
        $f['serviceName'] = '서비스 이름'; // 서비스 이름
        $f['desc'] = '네이버 예약 PHP 라이브러리를 통한 업체 설명 텍스트입니다.'; // 서비스 소개

        $f['businessCategory'] =
        NaverDictionary::BUSINESS_CATEGORIES['호텔']; // 업종 구분
        $f['email'] = 'businessemail@gmail.com'; // 업체 이메일
        $f['name'] = '업체명'; // 업체명
        $f['reprOwnerName'] = '대표자명'; // 대표자명

        $f['addressJson']['jibun'] = '경기도 성남시 분당구 정자동 178-1';
        $f['addressJson']['roadAddr'] = '경기도 성남시 불정로 6 그린팩토리';
        $f['addressJson']['posLat'] = 37.359544;
        $f['addressJson']['posLong'] = 127.105473;

        $f['phoneInformationJson']['wiredPhone'] = '02-123-4567'; // 업체 연락처(?)
        $f['phoneInformationJson']['reprPhone'] = '02-567-1234'; // "전화번호"
        $f['phoneInformationJson']['phoneList'] = ['02-548-0620']; // 관리자 연락처

        $f['bookingConfirmCode'] = NaverDictionary::BOOKING_CONFIRM_CODES['즉시'];
        $f['bookingTimeUnitCode'] = NaverDictionary::BOOKING_TIME_UNIT_CODES['30분'];
        $f['uncompletedBookingProcessCode'] =
        NaverDictionary::UNCOMPLETED_BOOKING_PROCESS_CODES['취소'];

        $f['agencyKey'] = 'PREFIX_01234';

        $f['businessResources'][0]['resourceTypeCode'] =
        NaverDictionary::RESOURCE_TYPE_CODES['대표이미지'];
        $f['businessResources'][0]['order'] = 0;
        $f['businessResources'][0]['resourceUrl'] = "";

        if (!$setDefault) {
            self::_arraySetValuesNull($f);
        }

        return $f;
    }

    public static function optionalFields($setDefault = false)
    {
        $f['bizNumber'] = '2178139965'; // 사업자 등록번호
        $f['cbizNumber'] = '2018-서울용산-0189'; // 통신판매업 신고번호

        $f['addressJson']['address'] = '경기도 성남시 분당구 정자동 178-1'; // ?
        $f['addressJson']['detail'] = '999층'; // 상세 위치

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

    public function getBusinessId()
    {
        if (isset($this->businessId)) {
            return $this->businessId;
        }
        return null;
    }

    public function getAddresses()
    {
        $f['addressJson'] = $this->addressJson;
        return $f;
    }

    public function setAddresses(array $newAddressJson, $returnJson = false)
    {
        $f['addressJson'] = $newAddressJson;
        if ($returnJson) {
            return $f;
        }
        $this->setData($f);
    }

    public function setAddressJibun(string $newAddressJibun, $returnJson = false)
    {
        $f['addressJson']['jibun'] = $newAddressJibun;
        if ($returnJson) {
            return $f;
        }
        $this->setData($f);
    }

    public function setAddressRoad(string $newAddressRoad, $returnJson = false)
    {
        $f['addressJson']['roadAddr'] = $newAddressRoad;
        if ($returnJson) {
            return $f;
        }
        $this->setData($f);
    }

    public function setAddressDetail(string $newAddressDetail, $returnJson = false)
    {
        $f['addressJson']['detail'] = $newAddressDetail;
        if ($returnJson) {
            return $f;
        }
        $this->setData($f);
    }

    public function getPhones()
    {
        $f['phoneInformationJson'] = $this->phoneInformationJson;
        return $f;
    }

    public function setPhones(array $newPhoneInfoJson, $returnJson = false)
    {
        $f['phoneInformationJson'] = $newPhoneInfoJson;
        if ($returnJson) {
            return $f;
        }
        $this->setData($f);
    }

    public function setPhoneWired(string $newPhoneWired, $returnJson = false)
    {
        $f['phoneInformationJson']['wiredPhone'] = $newPhoneWired;
        if ($returnJson) {
            return $f;
        }
        $this->setData($f);
    }
    
    public function setPhoneRep(string $newPhoneRep, $returnJson = false)
    {
        $f['phoneInformationJson']['reprPhone'] = $newPhoneRep;
        if ($returnJson) {
            return $f;
        }
        $this->setData($f);
    }

    public function setPhoneList(array $newPhoneList, $returnJson = false)
    {
        $f['phoneInformationJson']['phoneList'] = $newPhoneList;
        if ($returnJson) {
            return $f;
        }
        $this->setData($f);
    }

    public function addPhoneList(string $newPhone, $returnJson = false)
    {
        array_push($this->phoneInformationJson['phoneList'], $newPhone);
        if ($returnJson) {
            $f['phoneInformationJson'] = $this->phoneInformationJson;
            return $f;
        }
    }

    public function getBusinessName()
    {
        $f['name'] = $this->name;
        return $f;
    }

    public function setBusinessName($newBusinessName, $returnJson = false)
    {
        $f['name'] = $newBusinessName;
        if ($returnJson) {
            return $f;
        }
        $this->setData($f);
    }

    public function getOwnerName()
    {
        $f['reprOwnerName'] = $this->reprOwnerName;
        return $f;
    }

    public function setOwnerName($newOwnerName, $returnJson = false)
    {
        $f['reprOwnerName'] = $newOwnerName;
        if ($returnJson) {
            return $f;
        }
        $this->setData($f);
    }

    public function getBusinessEmail()
    {
        $f['email'] = $this->email;
        return $f;
    }

    public function setBusinessEmail($newBusinessEmail, $returnJson = false)
    {
        $f['email'] = $newBusinessEmail;
        if ($returnJson) {
            return $f;
        }
        $this->setData($f);
    }

    public function getServiceName()
    {
        $f['serviceName'] = $this->serviceName;
        return $f;
    }

    public function setServiceName($newServiceName, $returnJson = false)
    {
        $f['serviceName'] = $newServiceName;
        if ($returnJson) {
            return $f;
        }
        $this->setData($f);
    }

    public function getServiceDesc()
    {
        $f['desc'] = $this->desc;
        return $f;
    }

    public function setServiceDesc($newServiceDesc, $returnJson = false)
    {
        $f['desc'] = $newServiceDesc;
        if ($returnJson) {
            return $f;
        }
        return $f;
    }

    public function getAgencyKey()
    {
        $f['agencyKey'] = $this->agencyKey;
        return $f;
    }

    public function setAgencyKey($newAgencyKey, $returnJson = false)
    {
        $f['agencyKey'] = $newAgencyKey;
        if ($returnJson) {
            return $f;
        }
        $this->setData($f);
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
