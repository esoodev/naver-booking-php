<?php

require_once dirname(__FILE__) . "/NaverServiceBase.php";
require_once dirname(__FILE__) . "/../Objects/NaverBusiness.php";

class NaverBusinessService extends NaverServiceBase
{
    public function getBusinesses($accountName)
    {
        $res = $this->requestHandler->get(
            $this->hostUri . "/v3.0/businesses?account=${accountName}");
        return json_decode($res, true);
    }

    public function getBusiness($businessId)
    {
        $res = $this->requestHandler->get(
            $this->hostUri . "/v3.1/businesses/{$businessId}");
        return json_decode($res);
    }

    public function getBusinessIdsByBusinessName($accountName,
        $businessName) {
        $businesses = $this->getBusinesses($accountName);
        return ArrayHelper::mapForKey('name', $businessName,
            'businessId', $businesses);
    }

    /**
     * Returns the first occurence.
     */
    public function getBusinessIdByBusinessName($accountName, $businessName) {
        return $this->getBusinessIdsByBusinessName($accountName, $businessName)[0];
    }

    public function getBusinessesByBusinessName($accountName, $businessName) {
        $businesses = $this->getBusinesses($accountName);
        return ArrayHelper::searchForKey('name', $businessName, $businesses);
    }

    public function createBusiness(Business $business)
    {
        $res = $this->requestHandler->post(
            $this->hostUri . "/v3.1/businesses", json_encode($business));
        return json_decode($res);
    }

    public function editBusinessById($businessId, array $data)
    {
        $data['businessId'] = $businessId;
        $res = $this->requestHandler->patch(
            $this->hostUri . "/v3.1/businesses/${businessId}",
            json_encode($data));
        return $res;
    }

}
