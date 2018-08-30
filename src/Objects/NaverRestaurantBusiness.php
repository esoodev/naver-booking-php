<?php

require_once dirname(__FILE__) . "/NaverDictionary.php";
require_once dirname(__FILE__) . "/NaverBusiness.php";

class NaverRestaurantBusiness extends NaverBusiness
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

        $this->businessTypeId = NaverDictionary::BUSINESS_TYPE_ID['식당']; // 서비스 유형
        $this->businessCategory =
        NaverDictionary::BUSINESS_CATEGORIES['식당']; // 업종 구분
    }

    public static function requiredFields($setDefault = false)
    {
        $f = parent::requiredFields($setDefault);
        $f_set['businessTypeId'] = NaverDictionary::BUSINESS_TYPE_ID['식당']; // 서비스 유형
        $f_set['businessCategory'] =
        NaverDictionary::BUSINESS_CATEGORIES['식당']; // 업종 구분

        return array_merge_recursive($f, $f_set);
    }

    public function toJSON()
    {return parent::toJSON();}

    public function setData(array $data)
    {return parent::setData($data);}

    public function getAddrs()
    {return parent::getAddrs();}

    public function getPhones()
    {return parent::getPhones();}

    public function getBusinessName()
    {return parent::getBusinessName();}

    public function setBusinessName(string $newBusinessName, $returnJson = false)
    {return parent::setBusinessName($newBusinessName, $returnJson);}

    public function getBusinessEmail()
    {return parent::getBusinessEmail();}

    public function setBusinessEmail(string $newBusinessEmail, $returnJson = false)
    {return parent::setBusinessEmail($newBusinessEmail, $returnJson = false);}

    public function getServiceName()
    {return parent::getServiceName();}

    public function setServiceName(string $newServiceName, $returnJson = false)
    {return parent::setServiceName($newServiceName, $returnJson = false);}

    public function getServiceDesc()
    {return parent::getServiceDesc();}

    public function setServiceDesc(string $newServiceDesc, $returnJson = false)
    {return parent::setServiceDesc($newServiceDesc, $returnJson = false);}

}
