<?php

require_once dirname(__FILE__) . "/NaverDictionary.php";
require_once dirname(__FILE__) . "/../Helpers/ArrayHelper.php";

/**
 * NaverReservation 는 API 문서상 Booking 과 동일.
 * Booking Transaction / 예약 상태 업데이트 (from 대행사 to 네이버)
 */
class NaverReservationStatusTo
{
    public function __construct($status_string)
    {
        $this->_checkStatusIsValid($status_string);
    }

    /**
     * SETTERS
     */
    public function setConfirmDesc($desc)
    {
        $this->bookingGuide = $desc;
    }

    public function setCancelDesc($desc)
    {
        $this->cancelledDesc = $desc;
    }

    public function setRefundPrice($price)
    {
        $this->refundPrice = $price;
    }

    public function setRefundRate($rate)
    {
        $this->refundRate = $rate;
    }

    public function setData(array $data)
    {
        foreach ($data as $key => $value) {
            $this->{$key} = $value;
        }
    }

    /**
     * PRIVATE
     */
    private function _checkStatusIsValid($status_string)
    {
        $status_string = strtoupper($status_string);
        $isValidStatus = in_array($status_string,
            NaverDictionary::BOOKING_STATUS_STRINGS);

        if (!$isValidStatus) {
            throw new Exception("Invalid booking status ${status_string}");
        }
        $this->status = $status_string;
    }

}
