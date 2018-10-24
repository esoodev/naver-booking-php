<?php

require_once dirname(__FILE__) . "/NaverDictionary.php";
require_once dirname(__FILE__) . "/NaverReservation.php";
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

    public static function create(array $data)
    {
        return new self($data);
    }

    public function getStatus()
    {
        // paid, payCompleted, confirmed, cancelled, completed
        return $this->status;
    }

    public function getBookingId()
    {
        return $this->getReservation()->getReservationId();
    }

    public function getDateTime($format = 'Y-m-d H:i:s')
    {
        return (new DateTime($this->dateTime))->format($format);
    }

    /**
     * eg) 2018-10-16
     */
    public function getDateString($format = 'Y-m-d')
    {
        return (new DateTime($this->dateTime))->format($format);
    }

    /**
     * eg) 07:20
     */
    public function getTimeString($format = 'H:i')
    {
        return (new DateTime($this->dateTime))->format($format);
    }

    public function getReservationDetails()
    {
        return $this->bookingDetails;
    }

    public function getCancelDesc()
    {
        return $this->cancelledDesc;
    }

    public function getCancelBy()
    {
        return $this->cancelledDesc;
    }

    public function isCancelByUser()
    {
        return ($this->getCancelBy() === 'USER');
    }

    public function isCancelByBusinessOwner()
    {
        return ($this->getCancelBy() === 'OWNER');
    }

    public function getRefundPrice()
    {
        return $this->refundPrice;
    }

    public function getRefundRate()
    {
        return $this->refundRate;
    }

    public function getReservation()
    {
        return NaverReservation::create(
            json_decode($this->bookingDetails));
    }

}
