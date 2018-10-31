<?php

require_once dirname(__FILE__) . "/NaverServiceBase.php";
require_once dirname(__FILE__) . "/../Objects/NaverRefundPolicy.php";

class NaverRefundPolicyService extends NaverServiceBase
{

    public function attachPolicy($businessId, NaverRefundPolicy $policy)
    {
        $res = $this->requestHandler->post(
            $this->hostUri . "/v3.1/businesses/${businessId}/refund-policies",
            json_encode($policy));
        return json_decode($res, true);
    }

    public function getPolicy($businessId)
    {
        $res = $this->requestHandler->get(
            $this->hostUri . "/v3.1/businesses/${businessId}/refund-policies");
        return json_decode($res, true);
    }
}
