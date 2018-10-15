<?php

require_once dirname(__FILE__) . "/NaverDictionary.php";
require_once dirname(__FILE__) . "/../Helpers/ArrayHelper.php";

/**
 * NaverReservation 는 API 문서상 Booking 과 동일.
 * Booking Transaction / 예약 상태 업데이트 (from 네이버 to 대행사)
 */
class NaverReservationStatusFrom
{
    public function __construct(array $data)
    {
        foreach ($data as $key => $value) {
            $this->{$key} = $value;
        }
    }

    /**
     * GETTERS
     */

    public function getStatus()
    {
        // paid, payCompleted, confirmed, cancelled, completed
        return $this->status;
    }

    public function getReservationDetails()
    {
        return $this->bookingDetails;
    }

    public function getCancelDesc()
    {
        return $this->cancelledDesc;
    }

    public function getRefundPrice()
    {
        return $this->refundPrice;
    }

    public function getRefundRate()
    {
        return $this->refundRate;
    }
}
