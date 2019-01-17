<?php
namespace NaverBooking\Objects;

/**
 * NaverReservation 는 API 문서상 Booking 과 동일.
 */
class Reservation
{

    public function __construct(array $data)
    {
        /**
         * $data 의 형식
         *
         * $this->status; // required
         * $this->bookingId; // required
         * $this->userId; // required
         * $this->name; // required
         * $this->phone; // required
         *
         * $this->email;
         * $this->previousBookingId;
         * $this->scheduleId;
         * $this->date;
         * $this->minute;
         * $this->startDate;
         * $this->endDate;
         * $this->details;
         */

        foreach ($data as $key => $value) {
            $this->{$key} = $value;
        }
    }

    public static function create(array $data)
    {
        return new self($data);
    }

    /**
     * GETTERS
     */

    /**
     * getStatus()
     * 페이 예약인 경우 - 무조건 "confirmed"
     * 예약신청 시 즉시확정 경우 - 무조건 "confirmed"
     * 관리자 확인 후 확정인 경우 - "requested"
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

    public function getNaverUserPhoneNumber()
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

    public function getReservationRequestMessage()
    {
        if (isset($this->details['requestMessage'])) {
            return $this->details['requestMessage'];}
        return '';
    }

    public function getTotalPrice()
    {
        return $this->details['price'];
    }

    public function getPartySize()
    {
        return $this->details['count'];
    }

    public function getMenuPurchase()
    {
        return array_values($this->details['options']);
    }

    public function getDateTimeString($format = 'Y-m-d H:i:s')
    {
        $date = $this->getDateString();
        $time = $this->getTimeString();
        return (new \DateTime("${date} ${time}"))->format($format);
    }

    /**
     * eg) 2018-10-16
     */
    public function getDateString($format = 'Y-m-d')
    {
        return (new \DateTime($this->date))->format($format);
    }

    /**
     * eg) 07:20
     */
    public function getTimeString($format = 'H:i')
    {
        $hours = intval($this->minute / 60);
        $mins = $this->minute % 60;
        return (new \DateTime("${hours}:${mins}"))->format($format);
    }

    public function setData(array $data)
    {
        foreach ($data as $key => $value) {
            $this->{$key} = $value;
        }
    }

}
