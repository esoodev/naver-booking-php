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
        if ($this->getStatus() == 'cancelled') {
            if (empty($this->cancelledDesc)) {
                return '';}
            return $this->cancelledDesc;
        }
        return null;

    }

    public function getCancelBy()
    {
        if ($this->getStatus() == 'cancelled') {
            if (empty($this->cancelledBy)) {
                return null;}
            return $this->cancelledBy;
        }
        return null;

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
        if ($this->getStatus() == 'cancelled') {
            if (empty($this->refundPrice)) {
                return 0;}
            return intval($this->refundPrice);
        }
        return null;
    }

    public function getRefundRate()
    {
        if ($this->getStatus() == 'cancelled') {
            if (empty($this->refundRate)) {
                return 0;}
            return intval($this->refundRate);
        }
        return null;
    }

    public function getReservation()
    {
        return NaverReservation::create($this->bookingDetails);
    }
}
