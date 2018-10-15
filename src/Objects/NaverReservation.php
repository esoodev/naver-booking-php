<?php

require_once dirname(__FILE__) . "/NaverDictionary.php";
require_once dirname(__FILE__) . "/../Helpers/ArrayHelper.php";

/**
 * NaverReservation 는 API 문서상 Booking 과 동일.
 */
class NaverReservation
{

    public function __construct(array $data)
    {
        /**
         * status
         * 페이 예약인 경우 - 무조건 "confirmed"
         * 예약신청 시 즉시확정 경우 - 무조건 "confirmed"
         * 관리자 확인 후 확정인 경우 - "requested"
         */
        $this->status; // required
        $this->bookingId; // required
        $this->userId; // required
        $this->name; // required
        $this->phone; // required

        $this->email;
        $this->previousBookingId;
        $this->scheduleId;
        $this->date;
        $this->minute;
        $this->startDate;
        $this->endDate;
        $this->details;

        foreach ($data as $key => $value) {
            $this->{$key} = $value;
        }
    }

    /**
     * GETTERS
     */

    public function getStatus()
    {
        return $this->status;
    }

    public function getReservationId()
    {
        return $this->bookingId;
    }

    public function getNaverUserId()
    {
        return $this->userId;
    }

    public function getNaverUserName()
    {
        return $this->name;
    }

    public function getNaverUserPhone()
    {
        return $this->phone;
    }

    public function getNaverUserEmail()
    {
        return $this->email;
    }

    public function getReservationDetails()
    {
        return $this->details;
    }

    public function setData(array $data)
    {
        foreach ($data as $key => $value) {
            $this->{$key} = $value;
        }
    }

}
