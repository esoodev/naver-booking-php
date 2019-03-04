<?php
namespace NaverBooking\Services;

use NaverBooking\Objects\RefundPolicy;

require_once dirname(__FILE__) . "/ServiceBase.php";

class RefundPolicyService extends ServiceBase
{

    public function attachPolicy($businessId, RefundPolicy $policy)
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
