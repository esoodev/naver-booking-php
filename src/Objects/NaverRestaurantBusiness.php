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

    /**
     * Getters
     */
    public function getAddresses()
    {return parent::getAddresses();}

    public function getBusinessId()
    {return parent::getBusinessId();}

    public function getBusinessEmail()
    {return parent::getBusinessEmail();}

    public function getPhones()
    {return parent::getPhones();}

    public function getBusinessName()
    {return parent::getBusinessName();}

    public function getOwnerName()
    {return parent::getOwnerName();}

    public function getServiceName()
    {return parent::getServiceName();}

    public function getServiceDesc()
    {return parent::getServiceDesc();}

    public function getAgencyKey()
    {return parent::getAgencyKey();}

    /**
     * Setters
     */
    public function setAddresses(array $newAddressJson, $returnJson = false)
    {return parent::setAddresses($newAddressJson, $returnJson);}

    public function setBusinessName($newBusinessName, $returnJson = false)
    {return parent::setBusinessName($newBusinessName, $returnJson);}

    public function setBusinessEmail($newBusinessEmail, $returnJson = false)
    {return parent::setBusinessEmail($newBusinessEmail, $returnJson);}

    public function setServiceName($newServiceName, $returnJson = false)
    {return parent::setServiceName($newServiceName, $returnJson);}

    public function setServiceDesc($newServiceDesc, $returnJson = false)
    {return parent::setServiceDesc($newServiceDesc, $returnJson);}

}
